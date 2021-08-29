<?php

require_once 'base_connection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/restapi/models/resenas.php';

function resenasQuery($uri) {
  $data = null;
  $strErrorDesc = '';
  $strErrorHeader = '';
  $requestMethod = $_SERVER["REQUEST_METHOD"];
  $action = $uri[4];

  switch (strtoupper($requestMethod)) {
    case 'GET':
      if ($action == 'list') {
        if (sizeof($uri) == 6) {
          $id = $uri[5];
          $data = listarResenasByProfesional($strErrorDesc, $strErrorHeader, $id);
        } else {
          $data = listarResenas($strErrorDesc, $strErrorHeader);
        }
      }
      break;
    case 'POST':
      if ($action == 'create') {
        $data = crearResena($strErrorDesc, $strErrorHeader);
      }
      break;
    case 'PATCH':
      if ($action == 'update') {
        $data = actualizarResena($strErrorDesc, $strErrorHeader);
      }
      break;
    case 'DELETE':
      if ($action == 'delete') {
        $id = $uri[5];
        $data = eliminarResena($strErrorDesc, $strErrorHeader, $id);
      }
      break;
    default:
      $strErrorDesc = 'Method not supported';
      $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
      break;
  }
  sendResenas($data, $strErrorDesc, $strErrorHeader);
}

function sendResenas($data, $strErrorDesc, $strErrorHeader) {
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

function listarResenas($strErrorDesc, $strErrorHeader) {
  $response = null;

  try {
    $resenas = listResenas();
    $response = json_encode($resenas);
  } catch (Error $e) {
    $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
    $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
  }

  return $response;
}

function listarResenasByProfesional($strErrorDesc, $strErrorHeader, $id) {
  $response = null;

  try {
    $resenas = listResenasByProfesional($id);
    $response = json_encode($resenas);
  } catch (Error $e) {
    $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
    $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
  }

  return $response;
}

function crearResena($strErrorDesc, $strErrorHeader) {
  $response = null;

  try {
    $resena = json_decode(file_get_contents("php://input"));
    $result = createResena($resena);
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

function actualizarResena($strErrorDesc, $strErrorHeader) {
  $response = null;

  try {
    $resena = json_decode(file_get_contents("php://input"));
    $result = updateResena($resena);
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

function eliminarResena($strErrorDesc, $strErrorHeader, $id) {
  $response = null;

  try {
    $result = deleteResena($id);
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