<?php

namespace AppBundle\Component\Response;

use RecursiveArrayIterator;
use SimpleXMLElement;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class XmlResponse
 */
class XmlResponse extends Response
{

  /**
   * @var string
   */
  private $rootEntityName;

  /**
   * XmlResponse constructor.
   * @param null $data
   * @param int $status
   * @param array $headers
   * @param string $rootEntityName
   */
  public function __construct($data = null, $status = 200, $headers = [], $rootEntityName = 'content')
  {
    parent::__construct('', $status, $headers);

    if (null === $data) {
      $data = [];
    }
    $this->rootEntityName = $rootEntityName;
    $this->setData($data);
  }

  /**
   * @param array $data
   * @return string
   */
  public function setData(array $data)
  {
    $xml = $this->prepareXml($data);
    $this->headers->set('Content-Type', 'application/xml');
    header('Content-Type: application/xml');
    return $this->setContent($xml->asXML());
  }

  /**
   * @param array $data
   * @return SimpleXMLElement
   */
  protected function prepareXml(array $data)
  {
    $iterator = new RecursiveArrayIterator($data);
    $xml = new SimpleXMLElement('<xml/>');
    /**
     * @param RecursiveArrayIterator $iterator
     * @param SimpleXMLElement $xml
     * @param $rootEntityName
     */
    function traverseXmlStructure(RecursiveArrayIterator $iterator, SimpleXMLElement $xml, $rootEntityName)
    {
      while ($iterator->valid()) {
        if ($iterator->hasChildren()) {
          if (is_string($iterator->key())) {
            $rootEntityName = $iterator->key();
          }
          traverseXmlStructure($iterator->getChildren(), $xml->addChild($rootEntityName), $rootEntityName);
        } else {
          $xml->addChild($iterator->key(), $iterator->current());
        }
        $iterator->next();
      }
    }
    traverseXmlStructure($iterator, $xml, $this->rootEntityName);

    return $xml;
  }
}