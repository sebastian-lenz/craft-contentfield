<?php

namespace contentfield\utilities;

/**
 * Class Url
 * @package contentfield\utilities
 */
class Url
{
  /**
   * @var array
   */
  private $parts;


  /**
   * Url constructor.
   * @param string $url
   */
  public function __construct($url) {
    $this->parts = parse_url($url);
  }

  /**
   * @return string
   */
  public function __toString() {
    $parts    = $this->parts;
    $scheme   = isset($parts['scheme']) ? $parts['scheme'] . '://' : '';
    $host     = isset($parts['host']) ? $parts['host'] : '';
    $port     = isset($parts['port']) ? ':' . $parts['port'] : '';
    $user     = isset($parts['user']) ? $parts['user'] : '';
    $pass     = isset($parts['pass']) ? ':' . $parts['pass']  : '';
    $pass     = ($user || $pass) ? "$pass@" : '';
    $path     = isset($parts['path']) ? $parts['path'] : '';
    $query    = isset($parts['query']) ? '?' . $parts['query'] : '';
    $fragment = isset($parts['fragment']) ? '#' . $parts['fragment'] : '';

    return "$scheme$user$pass$host$port$path$query$fragment";
  }

  /**
   * @return array
   */
  public function getQuery() {
    if (!isset($this->parts['query'])) {
      return array();
    }

    $result = array();
    foreach (explode('&', $this->parts['query']) as $param) {
      list($key, $value) = explode('=', $param, 2);
      $result[$key] = urldecode($value);
    }

    return $result;
  }

  /**
   * @param array $query
   */
  public function setQuery(array $query) {
    if (count($query) === 0) {
      unset($this->parts['query']);
    } else {
      $parts = array();
      foreach ($query as $key => $value) {
        $parts[] = $key . '=' . urlencode($value);
      }

      $this->parts['query'] = implode('&', $parts);
    }
  }
}
