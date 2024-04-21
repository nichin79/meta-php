<?php
use Nichin79\Metas\Metas;

require_once (__DIR__ . '/_getopt.php');
require_once (__DIR__ . '/vendor/autoload.php');

if (!isset($url)) {
  $url = 'https://www.google.com/';
}

$tags = new Metas($url);
print_r($tags->getTags());