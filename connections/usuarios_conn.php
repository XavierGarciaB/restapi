<?php

require_once 'base_connection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/restapi/models/usuarios.php';

function usuariosQuery($uri) {
  $data = null;
  $strErrorDesc = '';
  $strErrorHeader = '';
  $requestMethod = $_SERVER["REQUEST_METHOD"];
  $action = $uri[4];
  // $arrQueryStringParams = getQueryStringParams();
  switch (strtoupper($requestMethod)) {
    case 'GET':
      if ($action == 'list') {
        $data = listarUsuarios($strErrorDesc, $strErrorHeader);
      } else if ($action == 'get') {
        $id = $uri[5];
        $data = getOneUsuario($strErrorDesc, $strErrorHeader, $id);
      } else if ($action == 'validate') {
        $usuario = $uri[5];
        $cedula = $uri[6];
        $data = validarUsuario($strErrorDesc, $strErrorHeader, $usuario, $cedula);
      }
      break;
    case 'POST':
      if ($action == 'create') {
        $data = crearUsuario($strErrorDesc, $strErrorHeader);
      }
      break;
    case 'PATCH':
      if ($action == 'update') {
        $data = actualizarUsuario($strErrorDesc, $strErrorHeader);
      }
      break;
    case 'DELETE':
      if ($action == 'delete') {
        $id = $uri[5];
        $data = eliminarUsuario($strErrorDesc, $strErrorHeader, $id);
      }
      break;
    default:
      $strErrorDesc = 'Method not supported';
      $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
      break;
  }
  sendOutputUsuarios($data, $strErrorDesc, $strErrorHeader);
}

function sendOutputUsuarios($data, $strErrorDesc, $strErrorHeader) {
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

function listarUsuarios($strErrorDesc, $strErrorHeader) {
  $response = null;

  try {
    $arrUsuarios = listUsuarios();
    $response = json_encode($arrUsuarios);
  } catch (Error $e) {
    $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
    $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
  }

  return $response;
}

function getOneUsuario($strErrorDesc, $strErrorHeader, $id) {
  $response = null;

  try {
    $usuario = getUsuario($id);
    $response = json_encode($usuario);
  } catch (Error $e) {
    $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
    $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
  }

  return $response;
}

function validarUsuario($strErrorDesc, $strErrorHeader, $usuario, $cedula) {
  $response = null;

  try {
    $usuario = validateUsuario($usuario, $cedula);
    $response = json_encode($usuario);
  } catch (Error $e) {
    $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
    $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
  }

  return $response;
}

function crearUsuario($strErrorDesc, $strErrorHeader) {
  $response = null;

  try {
    $usuario = json_decode(file_get_contents("php://input"));
    $result = createUsuario($usuario);
    if ($result) {
      $response = json_encode(array('message' => 'Usuario Created'));
    } else {
      $response = json_encode(array('message' => 'Usuario Not Created'));
    }
  } catch (Error $e) {
    $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
    $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
  }

  return $response;
}

function actualizarUsuario($strErrorDesc, $strErrorHeader) {
  $response = null;

  try {
    $usuario = json_decode(file_get_contents("php://input"));
    $result = updateUsuario($usuario);
    if ($result) {
      $response = json_encode(array('message' => 'Usuario updated'));
    } else {
      $response = json_encode(array('message' => 'Patch Not Done'));
    }
  } catch (Error $e) {
    $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
    $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
  }

  return $response;
}

function eliminarUsuario($strErrorDesc, $strErrorHeader, $id) {
  $response = null;

  try {
    $result = deleteUsuario($id);
    if ($result) {
      $response = json_encode(array('message' => 'Usuario Deleted'));
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