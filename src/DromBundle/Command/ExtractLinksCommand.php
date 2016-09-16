<?php

namespace DromBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Stage 2
 * Class ParseRawDataCommand
 * @package DromBundle\Command
 */
class ExtractLinksCommand extends Command
{
  protected function configure()
  {
    $this->setName('parser:read-pages')
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
    $resource = __DIR__ . '/../../../data/raw-list-content/';

    $pack = [];

    for ($i = 1; $i < 150; $i++) {
      $page = $resource . 'page-' . $i . '.json';
      $content = file_get_contents($page);
      if (!$content) {
        continue;
      }
      $j = json_decode($content, true);
      if (!$j || !isset($j['feed'])) {
        continue;
      }
      $crawler = new Crawler($j['feed']);
      $pack[] = $crawler->filter('.pageableContent .bull-item')->each(function ($node, $i) {
        /** @var Crawler $node */
        $links = $node->filter('a')->extract('href', 'attr');
        if (!empty($links)) {
          return array_pop($links);
        }
      });
    }
    $fp = fopen(__DIR__ . '/../../../data/urls/item-urls.csv', 'w');
    $t = 0;
    foreach ($pack as $item) {
      $t += count($item);
      fputcsv($fp, $item);
    }
    fclose($fp);
  }
}