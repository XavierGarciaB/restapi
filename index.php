<?php

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: HEAD, GET, POST, PUT, PATCH, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method,Access-Control-Request-Headers, Authorization");
header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];
if ($method == "OPTIONS") {
  header('Access-Control-Allow-Origin: *');
  header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method,Access-Control-Request-Headers, Authorization");
  header("HTTP/1.1 200 OK");
  die();
}

include './connections/profesionales_conn.php';
include './connections/horarios_conn.php';
include './connections/avisos_conn.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode( '/', $uri );

// uri: http://localhost/restapi/index.php/${uri[3]}
if ($uri[3] == 'profesionales') {
  profesionalesQuery($uri);
}elseif($uri[3] == 'horarios'){
  horariosQuery($uri);

}elseif($uri[3] == 'avisos'){
  avisosQuery($uri);

}
else {
  // NO EXISTE RUTA
  header("HTTP/1.1 404 Not Found");
  exit();
}

?>