<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/restapi/db.php';
 
function listAvisos() {
    
    $data = [];
    $result = select("SELECT * FROM profesionales join avisos on profesionales.id=profesionales_id");
    //$result= select("SELECT * FROM avisos");
    foreach($result as $profi){
        array_push($data, $profi);
    }
    return $data;
}

function getAviso($id) {
    $data = [];
    $result = select("SELECT * FROM avisos WHERE id=$id");
    foreach($result as $aviso) {
        array_push($data, $aviso);
    }
    return $data[0];
}

function listAvisosByProfesional($profesionalId) {
    $data = [];
    $result = select("SELECT * FROM avisos WHERE profesionales_id=$profesionalId");
    foreach($result as $profi){
        array_push($data, $profi);
    }
    return $data;
}


function createAviso($aviso) {
    $fecha = $aviso->fechaPublicacion;
    $contenido = $aviso->contenido;
    $titulo = $aviso->titulo;
    $pro_id= $aviso -> profesionales_id;
    $query = "INSERT INTO avisos(fechaPublicacion,contenido,titulo,profesionales_id) VALUES ('$fecha','$contenido','$titulo',$pro_id)";
    $result = executeStatement($query);
    return $result;
}

function updateAviso($aviso) {
    $id = $aviso->id;
    $contenido = $aviso->contenido;
    $titulo = $aviso->titulo;
   
    $query = "UPDATE avisos SET  contenido='$contenido',titulo='$titulo' WHERE id=$id";
    $result = executeStatement($query);
    return $result;
}

function deleteAviso($id) {
    $query = "DELETE FROM avisos WHERE id = $id";
    $result = executeStatement($query);
    return $result;
}

?>