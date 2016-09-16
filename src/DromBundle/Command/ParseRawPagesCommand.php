<?php
namespace DromBundle\Command;

use DromBundle\Component\Drom;
use GuzzleHttp\Client;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class Parser
 * @package DromBundle\Command
 */
class ParseRawPagesCommand extends Command
{
  const DEFAULT_PARSE_PAGES = 151;
  const TARGET_DIR = 'data/raw-list-content';

  /**
   *
   */
  protected function configure()
  {
    $this->setName('parser:drom')
      ->setDescription('Parsing drom web-site.')
      ->setHelp("This command allows you to parse Drom");
  }

  /**
   * Stage 1
   * @param InputInterface $input
   * @param OutputInterface $output
   * @return void
   */
  protected function execute(InputInterface $input, OutputInterface $output)
  {
    $client = new Client(['base_uri' => Drom::RESOURCE_URL]);

    for ($i = 1; $i < self::DEFAULT_PARSE_PAGES; $i++) {
      $response = $client->get(Drom::TRUCK_PREFIX . DIRECTORY_SEPARATOR, [
        'query' => [
          'page' => $i,
          '_lightweight' => 1,
          'status' => 'actual',
          'async' => 1,
          'ajax' => 1
        ],
        'headers' => Drom::$headers
      ]);

      if ($response->getStatusCode() != 200) {
        continue;
      }

      $output->writeln(sprintf('found page %d', $i));
      $chunk = $response->getBody()->read(1000);
      $container = '';
      while ($chunk == true) {
        $container .= $chunk;
        $chunk = $response->getBody()->read(1000);
        if (empty($chunk)) {
          $chunk = false;
        }
      }
      $name = sprintf('%s/page-%d.json', self::TARGET_DIR, $i);
      file_put_contents($name, $container);
    }
  }
}