<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/restapi/db.php';
 
function listProfesionales() {
    $data = [];
    $result = select("SELECT * FROM profesionales");
    foreach($result as $profi){
        array_push($data, $profi);
    }
    return $data;
}

function createProfesional($profesional) {
    $nombre = $profesional->nombre;
    $edad = $profesional->edad;
    $direccion = $profesional->direccion;
    $query = "INSERT INTO profesionales(nombre,edad,direccion) VALUES ('$nombre',$edad,'$direccion')";
    $result = executeStatement($query);
    return $result;
}

function updateProfesional($profesional) {
    $id = $profesional->id;
    $nombre = $profesional->nombre;
    $edad = $profesional->edad;
    $direccion = $profesional->direccion;
    $query = "UPDATE profesionales SET nombre='$nombre', edad=$edad, direccion='$direccion' WHERE id=$id";
    $result = executeStatement($query);
    return $result;
}

function deleteProfesional($id) {
    $query = "DELETE FROM profesionales WHERE id = $id";
    $result = executeStatement($query);
    return $result;
}

?>