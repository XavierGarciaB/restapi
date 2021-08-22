<?php

require 'base_connection.php';
require $_SERVER['DOCUMENT_ROOT'] . '/restapi/models/profesionales.php';

function profesionalesQuery($action) {
  if ($action == 'list') {
    listAll();
  } else {
    echo "$action";
  }
}

function listAll() {
  $strErrorDesc = '';
  $requestMethod = $_SERVER["REQUEST_METHOD"];
  $arrQueryStringParams = getQueryStringParams();

  if (strtoupper($requestMethod) == 'GET') {
    try {
      $arrUsers = getProfesionales();
      $data = json_encode($arrUsers);
    } catch (Error $e) {
      $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
      $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
    }
  } else {
    $strErrorDesc = 'Method not supported';
    $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
  }

  // send output
  if (!$strErrorDesc) {
    sendOutput(
      $data,
      array('Content-Type: application/json', 'HTTP/1.1 200 OK')
    );
  } else {
    sendOutput(json_encode(array('error' => $strErrorDesc)), 
      array('Content-Type: application/json', $strErrorHeader)
    );
  }
}

?>