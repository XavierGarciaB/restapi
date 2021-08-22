<?php

function __call($name, $arguments) {
  $this->sendOutput('', array('HTTP/1.1 404 Not Found'));
}

function getUriSegments() {
  $uri = parse_url($_SERVER['REQUEST_URI'], '/restapi');
  $uri = explode( '/', $uri );

  return $uri;
}

function getQueryStringParams() {
  return parse_str($_SERVER['QUERY_STRING'], $query);
}

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