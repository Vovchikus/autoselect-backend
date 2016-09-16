<?php

namespace DromBundle\Component;

/**
 * Class Drom
 */
class Drom
{
  const RESOURCE_URL = 'http://spec.drom.ru/moskva/';
  const TRUCK_PREFIX = 'truck';

  /**
   * @var array
   */
  public static $headers = [
    'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
    'Accept-Encoding' => 'gzip, deflate, sdch',
    'Connection' => 'keep-alive',
    'X-Robots-Tag' => 'Googlebot',
    'KeepAlive' => 'On',
    'Host' => 'spec.drom.ru'
  ];
}