<?php

namespace DromBundle\Command;

use GuzzleHttp\Client;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ParseFbCommand
 * @package DromBundle\Command
 */
class ParseFbCommand extends Command
{

  protected function configure()
  {
    $this->setName('parser:fb')
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
    $client = new Client(['base_uri' => 'https://www.facebook.com']);
    $response = $client->post('/ajax/login/help/identify.php?ctx=recover&dpr=1', [
      'headers' => [
        'authority' => 'www.facebook.com',
        'method' => 'POST',
        'path' => '/ajax/login/help/identify.php?ctx=recover&dpr=1',
        'scheme' => 'https',
        'accept' => '*/*',
        'accept-encoding' => 'gzip, deflate, br',
        'accept-language' => 'en-US,en;q=0.8',
        'content-type' => 'application/x-www-form-urlencoded',
        'origin' => 'https://www.facebook.com',
        'referer' => 'https://www.facebook.com/login/identify?ctx=recover&lwv=110',
        'user-agent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/52.0.2743.116 Chrome/52.0.2743.116 Safari/537.36'
      ],
      'form_params' => [
        'lsd' => 'AVrXRGzN',
        'email' => '+79261111111',
        'did_submit' => 'Search',
        '__user' => 0,
        '__a' => 1,
        '__dyn' => '7xeXxaER0gbgfodpbG4oy4S-C11xG12wAxu13wm8gxZ3ocU9UKaxeUW2y7E4iu3e225ob8aUbo6ucxG48hwv9Fovgkzonw',
        '__req' => 4,
        '__be' => '-1',
        '__pc' => 'EXP1:DEFAULT',
        '__rev' => '2577005'
      ]
    ]);


    print_r($response->getHeaders());

  }

}