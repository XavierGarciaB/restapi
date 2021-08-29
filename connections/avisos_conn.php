<?php

require_once 'base_connection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/restapi/models/avisos.php';

function avisosQuery($uri){
    $data = null;
    $strErrorDesc = '';
    $strErrorHeader = '';
    $requestMethod = $_SERVER["REQUEST_METHOD"];
    $action = $uri[4];

    
  // $arrQueryStringParams = getQueryStringParams();
  switch (strtoupper($requestMethod)) {
    case 'GET':
      if ($action == 'list') {
        $data = listAllA($strErrorDesc, $strErrorHeader);
      }
      break;
    case 'POST':
      if ($action == 'create') {
        $data = createA($strErrorDesc, $strErrorHeader);
      }
      break;
    case 'PATCH':
      if ($action == 'update') {
        $data = updateA($strErrorDesc, $strErrorHeader);
      }
      break;
    case 'DELETE':
      if ($action == 'delete') {
        $id = $uri[5];
        $data = deleteA($strErrorDesc, $strErrorHeader, $id);
      }
      break;
    default:
      $strErrorDesc = 'Method not supported';
      $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
      break;
  }
  sendOutputAvisos($data, $strErrorDesc, $strErrorHeader);




}


function sendOutputAvisos($data, $strErrorDesc, $strErrorHeader) {
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


function listAllA($strErrorDesc, $strErrorHeader) {
    $response = null;
  
    try {
      
      $arrAvisos = listAvisos();
      $response = json_encode($arrAvisos);
    } catch (Error $e) {
      $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
      $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
    }
  
    return $response;
}


function createA($strErrorDesc, $strErrorHeader) {
    $response = null;
  
    try {
      $aviso = json_decode(file_get_contents("php://input"));
      $result = createAviso($aviso);
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

function updateA($strErrorDesc, $strErrorHeader) {
    $response = null;
  
    try {
      $aviso = json_decode(file_get_contents("php://input"));
      $result = updateAviso($aviso);
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


function deleteA($strErrorDesc, $strErrorHeader, $id) {
    $response = null;
  
    try {
      $result = deleteAviso($id);
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