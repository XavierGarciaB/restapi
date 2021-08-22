<?php

require_once 'base_connection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/restapi/models/horarios.php';

function horariosQuery($uri){
    $data = null;
    $strErrorDesc = '';
    $strErrorHeader = '';
    $requestMethod = $_SERVER["REQUEST_METHOD"];
    $action = $uri[4];

  // $arrQueryStringParams = getQueryStringParams();
  switch (strtoupper($requestMethod)) {
    case 'GET':
      if ($action == 'list') {
        $data = listAllB($strErrorDesc, $strErrorHeader);
      }
      break;
    case 'POST':
      if ($action == 'create') {
        $data = createB($strErrorDesc, $strErrorHeader);
      }
      break;
    case 'PATCH':
      if ($action == 'update') {
        $data = updateB($strErrorDesc, $strErrorHeader);
      }
      break;
    case 'DELETE':
      if ($action == 'delete') {
        $id = $uri[5];
        $data = deleteB($strErrorDesc, $strErrorHeader, $id);
      }
      break;
    default:
      $strErrorDesc = 'Method not supported';
      $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
      break;
  }
  sendOutputHorarios($data, $strErrorDesc, $strErrorHeader);




}


function sendOutputHorarios($data, $strErrorDesc, $strErrorHeader) {
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


function listAllB($strErrorDesc, $strErrorHeader) {
    $response = null;
  
    try {
      $arrHorarios = listHorarios();
      $response = json_encode($arrHorarios);
    } catch (Error $e) {
      $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
      $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
    }
  
    return $response;
}


function createB($strErrorDesc, $strErrorHeader) {
    $response = null;
  
    try {
      $horario = json_decode(file_get_contents("php://input"));
      $result = createHorario($horario);
      if ($result) {
        $response = json_encode(array('message' => 'Post Created'));
      } else {
        $response = json_encode(array('message' => 'Post Not Created'));
      }
    } catch (Error $e) {
      $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
      $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
    }
  
    return $response;
}

function updateB($strErrorDesc, $strErrorHeader) {
    $response = null;
  
    try {
      $horario = json_decode(file_get_contents("php://input"));
      $result = updateHorario($horario);
      if ($result) {
        $response = json_encode(array('message' => 'Patch Done'));
      } else {
        $response = json_encode(array('message' => 'Patch Not Done'));
      }
    } catch (Error $e) {
      $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
      $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
    }
  
    return $response;
}


function deleteB($strErrorDesc, $strErrorHeader, $id) {
    $response = null;
  
    try {
      $result = deleteHorario($id);
      if ($result) {
        $response = json_encode(array('message' => 'Item Deleted'));
      } else {
        $response = json_encode(array('message' => 'Item Not Deleted'));
      }
    } catch (Error $e) {
      $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
      $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
    }
  
    return $response;
}




?>