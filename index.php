<?php

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('content-type: application/json; charset=utf-8');

include 'db_connection.php';
include './connections/profesionales_conn.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode( '/', $uri );

$uri_string = $_SERVER['REQUEST_URI'];
 
if ($uri[3] == 'profesionales') {
  $strMethodName = $uri[4];
  profesionalesQuery($strMethodName);
}

if ((isset($uri[2]) && $uri[2] != 'user') || !isset($uri[3])) {
  header("HTTP/1.1 404 Not Found");
  exit();
}

?>