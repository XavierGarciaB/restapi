<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/restapi/db.php';
 
function listCitasbyUsuario($id) {
    $idUser = $id->id;
    $datos = [];
    $resultado = select("SELECT * FROM citas WHERE usuarios_id == $idUser");
    foreach($resultado as $cita){
        array_push($datos, $cita);
    }
    return $datos;
}

function createCita($cita) {
    $horario = $cita->horario;
    $usuarios_id = $cita->usuarios_id;
    $estado = $cita->estado;
    $query = "INSERT INTO citas(estado,horarios_id,usuarios_id) VALUES ('$estado','$horario','$usuarios_id')";
    $result = executeStatement($query);
    return $result;
}

function updateEstadoCita($estado, $id) {
    $query = "UPDATE citas SET estado='$estado' WHERE id=$id";
    $result = executeStatement($query);
    return $result;
}

function deleteCita($id) {
    $query = "DELETE FROM citas WHERE id = $id";
    $resultado = executeStatement($query);
    return $resultado;
}

?>