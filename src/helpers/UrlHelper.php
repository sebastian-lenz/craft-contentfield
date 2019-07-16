<?php

namespace lenz\contentfield\helpers;

/**
 * Class Url
 *
 * A url helper class for manipulating urls.
 */
class UrlHelper
{
  /**
   * @var array
   */
  private $_parts;


  /**
   * Url constructor.
   * @param string $url
   */
  public function __construct($url) {
    $this->_parts = parse_url($url);
  }

  /**
   * @return string
   */
  public function __toString() {
    $parts    = $this->_parts;
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
    if (!isset($this->_parts['query'])) {
      return array();
    }

    $result = array();
    foreach (explode('&', $this->_parts['query']) as $param) {
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
      unset($this->_parts['query']);
    } else {
      $parts = array();
      foreach ($query as $key => $value) {
        $parts[] = $key . '=' . urlencode($value);
      }

      $this->_parts['query'] = implode('&', $parts);
    }
  }
}
