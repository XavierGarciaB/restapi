<?php

/**
 * __call magic method.
 */
function __call($name, $arguments) {
  $this->sendOutput('', array('HTTP/1.1 404 Not Found'));
}

/**
 * Get URI elements.
 *
 * @return array
 */
function getUriSegments() {
  $uri = parse_url($_SERVER['REQUEST_URI'], '/restapi');
  $uri = explode( '/', $uri );

  return $uri;
}

/**
 * Get querystring params.
 * 
 * @return array
 */
function getQueryStringParams() {
  return parse_str($_SERVER['QUERY_STRING'], $query);
}

/**
 * Send API output.
 *
 * @param mixed  $data
 * @param string $httpHeader
 */
function sendOutput($data, $httpHeaders=array()) {
  header_remove('Set-Cookie');

  if (is_array($httpHeaders) && count($httpHeaders)) {
    foreach ($httpHeaders as $httpHeader) {
      header($httpHeader);
    }
  }
  echo $data;
  exit;
}

?>