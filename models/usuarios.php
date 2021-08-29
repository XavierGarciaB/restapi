<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/restapi/db.php';
 
function listUsuarios() {
    $data = [];
    $result = select("SELECT * FROM usuarios");
    foreach($result as $usuario){
        array_push($data, $usuario);
    }
    return $data;
}

function getUsuario($id) {
    $data = [];
    $result = select("SELECT * FROM usuarios WHERE id=$id");
    foreach($result as $usuario){
        array_push($data, $usuario);
    }
    return $data[0];
}

function createUsuario($usuario) {
    $nombre = $usuario->nombre;
    $cedula = $usuario->cedula;
    $edad = $usuario->edad;
    $email = $usuario->email;
    $query = "INSERT INTO usuarios(nombre, cedula, edad, email) VALUES ('$nombre', '$cedula', $edad, '$email')";
    $result = executeStatement($query);
    return $result;
}

function updateUsuario($usuario) {
    $id = $usuario->id;
    $nombre = $usuario->nombre;
    $cedula = $usuario->cedula;
    $edad = $usuario->edad;
    $email = $usuario->email;
    $query = "UPDATE usuarios SET nombre='$nombre', cedula='$cedula', edad=$edad, email='$email' WHERE id=$id";
    $result = executeStatement($query);
    return $result;
}

function deleteUsuario($id) {
    $query = "DELETE FROM usuarios WHERE id = $id";
    $result = executeStatement($query);
    return $result;
}

?>