<?php

namespace lenz\contentfield\services\oembeds;

use lenz\craft\utils\models\Url;

/**
 * Class YouTubeEmbed
 */
class YouTubeEmbed extends OEmbed
{
  /**
   * @var bool
   */
  static $USE_NOCOOKIE = true;


  /**
   * @inheritDoc
   */
  protected function modifyUrl(Url $url, array $options) {
    parent::modifyUrl($url, $options);

    // YouTube playlists forget to carry over the video index, patch it.
    $query = $url->getQuery();
    if (
      isset($query['list']) &&
      !isset($query['index'])
    ) {
      $originalUrl = new Url($this->_originalUrl);
      $originalQuery = $originalUrl->getQuery();

      if (isset($originalQuery['index']) && is_numeric($originalQuery['index'])) {
        $query['index'] = ($originalQuery['index'] - 1);
        $url->setQuery($query);
      }
    }

    // Use the no cookie domain
    if (self::$USE_NOCOOKIE) {
      $url->host = 'www.youtube-nocookie.com';
    }
  }
}
