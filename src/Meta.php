<?php
namespace Nichin79\Meta;

use Nichin79\Curl\BasicCurl;
use Nichin79\Curl\Curl;

class Meta
{
  private object $doc;
  protected array $data = [];
  public string $url;
  private object $curl;

  public function __construct(string $url)
  {
    $this->url = $url;

    if (!filter_var($this->url, FILTER_VALIDATE_URL)) {
      throw new \Exception("Invalid URL (" . $this->url . ")");
    }
    $this->curl = new BasicCurl([
      'url' => $this->url,
      'options' => [
        'ENCODING' => 'gzip'
      ]
    ]);

    if (substr($this->curl->httpcode, 0, 2) == 20) {
      $this->doc();
      $this->data = array_merge($this->data, $this->getTitle(), $this->getMeta());
    }
  }

  private function doc()
  {
    $this->doc = new \DOMDocument();
    @$this->doc->loadHTML($this->curl->response);
  }

  public function getTags()
  {
    return $this->data;
  }

  public function getTitle()
  {
    if (isset($this->doc)) {
      $nodes = $this->doc->getElementsByTagName('title');
      $title = trim($nodes->item(0)->nodeValue);
      return ['title' => $title];
    }
  }

  public function getMeta()
  {
    if (isset($this->doc)) {
      $arr = [];
      $metas = $this->doc->getElementsByTagName('meta');

      for ($i = 0; $i < $metas->length; $i++) {
        $meta = $metas->item($i);

        if ($meta->getAttribute('name')) {
          $arr[$meta->getAttribute('name')] = $meta->getAttribute('content');
        }

        if ($meta->getAttribute('property')) {
          $arr[$meta->getAttribute('property')] = $meta->getAttribute('content');
        }
      }

      return $arr;
    }
  }
}