<?php

namespace AppBundle\Component\Response;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class CustomResponse
 * @package AppBundle\Component\Response
 */
class CustomResponse
{

  private $data;

  /**
   * @var int
   */
  private $status;

  /**
   * @var array
   */
  private $headers;

  /**
   * @var Request
   */
  private $request;

  /**
   * CustomResponse constructor.
   * @param null $data
   * @param int $status
   * @param array $headers
   * @param Request $request
   */
  public function __construct($data = null, $status = 200, $headers = [], Request $request)
  {
    $this->data = $data;
    $this->status = $status;
    $this->headers = $headers;
    $this->request = $request;
    $this->processResponse();
  }


  /**
   * @return XmlResponse|JsonResponse
   */
  protected function processResponse()
  {
    switch ($this->request->headers->get('Content-Type')) {
      case 'application/xml':
        return new XmlResponse($this->data, $this->status, $this->headers);
        break;
      default:
        return new JsonResponse($this->data, $this->status, $this->headers);
    }
  }


}