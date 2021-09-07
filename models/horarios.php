<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/restapi/db.php';
 
function listHorarios($profesionalId) {
    $data = [];
    $result = select("SELECT * FROM profesionales join horarios on profesionales.id=profesionales_id");
    foreach($result as $profi){
        array_push($data, $profi);
    }
    return $data;
}

function listHorariosByProfesional($profesionalId) {
    $data = [];
    $result = select("SELECT * FROM horarios WHERE profesionales_id=$profesionalId");
    foreach($result as $profi){
        array_push($data, $profi);
    }
    return $data;
}

function getHorario($id) {
    $data = [];
    $result = select("SELECT * FROM horarios WHERE id=$id");
    foreach($result as $horario) {
        array_push($data, $horario);
    }
    return $data[0];
}

function createHorario($horario) {
    $fecha = $horario->fecha;
    $disponible=$horario->disponible;
    $horaInicio = $horario->horaInicio;
    $horaFin = $horario->horaFin;
    $profesionales_id = $horario->profesionales_id;
    $query = "INSERT INTO horarios(disponible,horaInicio,horaFin,profesionales_id) VALUES ($disponible,'$horaInicio','$horaFin',$profesionales_id)";
    $result = executeStatement($query);
    return $result;
}

function updateHorario($horario) {
    $id = intval($horario->id);
    $fecha = $horario->fecha;
    $disponible = $horario->disponible ? 'true' : 'false';
    $inicio = $horario->horaInicio;
    $fin = $horario->horaFin;
    $profesional_id = intval($horario->profesionales_id);
    $query = "UPDATE horarios SET fecha='$fecha', disponible=$disponible, horaInicio='$inicio', horaFin='$fin', profesionales_id=$profesional_id WHERE id=$id";
    $result = executeStatement($query);
    return $result;
}

function deleteHorario($id) {
    $query = "DELETE FROM horarios WHERE id = $id";
    $result = executeStatement($query);
    return $result;
}

?>