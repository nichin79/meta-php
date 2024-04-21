<?php
$short_options = "u:";
$long_options = ["url:"];
$options = getopt($short_options, $long_options);

foreach ($options as $key => $value) {

  switch ($key) {
    case ('u' || 'url'):
      $url = $value;
      break;
  }

}
