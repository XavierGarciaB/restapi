<?php

require_once 'base_connection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/restapi/models/profesionales.php';

function profesionalesQuery($uri) {
  $data = null;
  $strErrorDesc = '';
  $strErrorHeader = '';
  $requestMethod = $_SERVER["REQUEST_METHOD"];
  $action = $uri[4];
  // $arrQueryStringParams = getQueryStringParams();
  switch (strtoupper($requestMethod)) {
    case 'GET':
      if ($action == 'list') {
        $data = listAll($strErrorDesc, $strErrorHeader);
      }
      break;
    case 'POST':
      if ($action == 'create') {
        $data = create($strErrorDesc, $strErrorHeader);
      }
      break;
    case 'PATCH':
      if ($action == 'update') {
        $data = update($strErrorDesc, $strErrorHeader);
      }
      break;
    case 'DELETE':
      if ($action == 'delete') {
        $id = $uri[5];
        $data = delete($strErrorDesc, $strErrorHeader, $id);
      }
      break;
    default:
      $strErrorDesc = 'Method not supported';
      $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
      break;
  }
  sendOutputProfesionales($data, $strErrorDesc, $strErrorHeader);
}

function sendOutputProfesionales($data, $strErrorDesc, $strErrorHeader) {
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

function listAll($strErrorDesc, $strErrorHeader) {
  $response = null;

  try {
    $arrProfesionales = listProfesionales();
    $response = json_encode($arrProfesionales);
  } catch (Error $e) {
    $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
    $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
  }

  return $response;
}

function create($strErrorDesc, $strErrorHeader) {
  $response = null;

  try {
    $profesional = json_decode(file_get_contents("php://input"));
    $result = createProfesional($profesional);
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

function update($strErrorDesc, $strErrorHeader) {
  $response = null;

  try {
    $profesional = json_decode(file_get_contents("php://input"));
    $result = updateProfesional($profesional);
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

function delete($strErrorDesc, $strErrorHeader, $id) {
  $response = null;

  try {
    $result = deleteProfesional($id);
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