<?php
use Nichin79\Meta\Meta;

require_once (__DIR__ . '/_getopt.php');
require_once (__DIR__ . '/vendor/autoload.php');

if (!isset($url)) {
  $url = 'https://www.google.com/';
}

$tags = new Meta($url);
print_r($tags->getTags());