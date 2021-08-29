<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/restapi/db.php';
 
function listHorariosByProfesional($id) {
    $idPro = $id->id;
    $data = [];
    $result = select("SELECT * FROM profesionales join horarios on profesionales.id=profesionales_id where profesionales_id=$idPro");
    foreach($result as $profi){
        array_push($data, $profi);
    }
    return $data;
}

function createHorario($horario) {
    $disponible=$horario->$disponible;
    $horaInicio = $horario->horaInicio;
    $horaFin = $horario->horaFin;
    $profesionales_id = $horario->profesionales_id;
    $query = "INSERT INTO horarios(disponible,horaInicio,horaFin,profesionales_id) VALUES ($disponible,'$horaInicio','$horaFin',$profesionales_id)";
    $result = executeStatement($query);
    return $result;
}

function updateHorario($horario) {
    $id = $horario->id;
    $inicio = $horario->horaInicio;
    $fin = $horario->horaFin;
    $disponible=$horario->disponible;
    $profesional_id = $horario->profesionales_id;
    $query = "UPDATE horarios SET disponible=$disponible, horaInicio='$inicio', horaFin='$fin', profesionales_id=$profesional_id WHERE id=$id";
    $result = executeStatement($query);
    return $result;
}

function deleteHorario($id) {
    $query = "DELETE FROM horarios WHERE id = $id";
    $result = executeStatement($query);
    return $result;
}

?>