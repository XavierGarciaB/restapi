<?php

require_once 'base_connection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/restapi/models/citas.php';

function citasQuery($uri) {
  $data = null;
  $strErrorDesc = '';
  $strErrorHeader = '';
  $requestMethod = $_SERVER["REQUEST_METHOD"];
  $action = $uri[4];

  switch (strtoupper($requestMethod)) {
    case 'GET':
      if ($action == 'list') {
        $id = $uri[5];
        $data = listarCitas($strErrorDesc, $strErrorHeader, $id);
      }else if($action == 'get') {
        $id = $uri[5];
        $data = getCitabyId($strErrorDesc, $strErrorHeader, $id);
      }    
      break;

      if ($action == 'list') {
        $id = $uri[5];
        $data = listarCitas($strErrorDesc, $strErrorHeader, $id);
      }
      break;
    case 'POST':
      if ($action == 'create') {
        $data = crearCita($strErrorDesc, $strErrorHeader);
      }
      break;
    case 'PATCH':
      if ($action == 'update') {
        $data = actualizarCita($strErrorDesc, $strErrorHeader);
      }
      break;
    case 'DELETE':
      if ($action == 'delete') {
        $id = $uri[5];
        $data = eliminarCita($strErrorDesc, $strErrorHeader, $id);
      }
      break;
    default:
      $strErrorDesc = 'Method not supported';
      $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
      break;
  }
  sendCitas($data, $strErrorDesc, $strErrorHeader);
}

function sendCitas($data, $strErrorDesc, $strErrorHeader) {
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

function listarCitas($strErrorDesc, $strErrorHeader, $id) {
  $response = null;

  try {
    $citas = listCitasbyUsuario($id);
    $response = json_encode($citas);
  } catch (Error $e) {
    $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
    $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
  }

  return $response;
}

function getCitaById($strErrorDesc, $strErrorHeader, $id) {
  $response = null;

  try {
    $horario = getCita($id);
    $response = json_encode($horario);
  } catch (Error $e) {
    $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
    $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
  }

  return $response;
}

function crearCita($strErrorDesc, $strErrorHeader) {
  $response = null;

  try {
    $cita = json_decode(file_get_contents("php://input"));
    $result = createCita($cita);
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

function actualizarCita($strErrorDesc, $strErrorHeader) {
  $response = null;

  try {
    $cita = json_decode(file_get_contents("php://input"));
    $result = updateEstadoCita($cita);
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

function eliminarCita($strErrorDesc, $strErrorHeader, $id) {
  $response = null;

  try {
    $result = deleteCita($id);
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