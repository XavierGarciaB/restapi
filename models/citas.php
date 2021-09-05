<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/restapi/db.php';
 
function listCitasbyUsuario($idUser) {
    $data = [];
    $result = select("SELECT * FROM citas WHERE usuarios_id=$idUser");
    foreach($result as $cita) {
        array_push($data, $cita);
    }
    return $data;
}

function getCita($id) {
    $datos = [];
    $resultado = select("SELECT * FROM citas WHERE id=$id");
    foreach($resultado as $cita){
        array_push($datos, $cita);
    }
    return $datos[0];
}

function createCita($cita) {
    $horarios_id = $cita->horarios_id;
    $usuarios_id = $cita->usuarios_id;
    $estado = $cita->estado;
    $query = "INSERT INTO citas(estado,horarios_id,usuarios_id) VALUES ('$estado','$horarios_id','$usuarios_id')";

    $result = executeStatement($query);
    return $result;
}

function updateEstadoCita($cita) {
    $estado = $cita->estado;
    $id = $cita->id;
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