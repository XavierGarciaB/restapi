<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/restapi/db.php';
 
function listCitasbyUsuario($id) {
    $idUser = $id->id;
    $datos = [];
    $resultado = select("SELECT * FROM (citas JOIN horarios JOIN profesionales ON (citas.horarios_id=horarios.id AND horarios.profesionales_id=profesionales.id)) WHERE citas.usuarios_id=$idUser");
    foreach($resultado as $cita){
        array_push($datos, $cita);
    }
    return $datos;
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