<?php

namespace DromBundle\Command;

use DromBundle\Component\Drom;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Stage 3
 * Class ParseRawItemCommand
 * @package DromBundle\Command
 */
class ParseRawItemCommand extends Command
{

  const TARGET_DIR = 'data/raw-item-content';

  protected function configure()
  {
    $this->setName('parser:parse-item')
      ->setDescription('Parsing drom web-site.')
      ->setHelp("This command allows you to parse Drom");
  }

  /**
   * @param InputInterface $input
   * @param OutputInterface $output
   * @return int|null|void
   */
  protected function execute(InputInterface $input, OutputInterface $output)
  {
    $resource = __DIR__ . '/../../../data/urls/item-urls.csv';

    $fh = fopen($resource, 'r');
    $client = new Client(['base_uri' => Drom::RESOURCE_URL]);
    while (($data = fgetcsv($fh, 100000000, ",")) !== false) {
      foreach ($data as $url) {

        try {
          $response = $client->get($url, [
            'query' => [],
            'headers' => Drom::$headers
          ]);
        } catch (ClientException $ex) {
          continue;
        }

        if ($response->getStatusCode() != 200) {
          continue;
        }

        $chunk = $response->getBody()->read(1000);
        $container = '';
        while ($chunk == true) {
          $container .= $chunk;
          $chunk = $response->getBody()->read(1000);
          if (empty($chunk)) {
            $chunk = false;
          }
        }
        $splits = explode('/', $url);
        $name = array_pop($splits);

        if ($name) {
          $dir = sprintf('%s/%s', self::TARGET_DIR, $name);
          file_put_contents($dir, $container);
        }
      }
    }
  }
}