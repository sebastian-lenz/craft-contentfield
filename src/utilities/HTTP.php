<?php

namespace contentfield\utilities;

/**
 * Class HTTP
 */
class HTTP {
  /**
   * @param string $url
   * @return mixed
   */
  static  public function fetch($url) {
    $channel = curl_init();
    curl_setopt($channel,CURLOPT_URL, $url);
    curl_setopt($channel,CURLOPT_CONNECTTIMEOUT, 2);
    curl_setopt($channel,CURLOPT_RETURNTRANSFER, true);
    curl_setopt($channel, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec($channel);

    if (curl_errno($channel)) {
      $result = null;
    } else {
      $resultCode = curl_getinfo($channel, CURLINFO_HTTP_CODE);
      if ($resultCode != 200) {
        $result = null;
      }
    }

    curl_close($channel);
    return $result;
  }
}
