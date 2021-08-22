<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/restapi/db.php';
 
function listAvisos() {
    $data = [];
    $result = select("SELECT * FROM avisos");
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
    $fecha = $aviso->fechaPublicacion;
    $contenido = $aviso->contenido;
    $titulo = $aviso->titulo;
    $pro_id= $aviso -> profesionales_id;
    $query = "UPDATE avisos SET fechaPublicacion='$fecha', contenido='$contenido',titulo='$titulo', profesionales_id=$pro_id WHERE id=$id";
    $result = executeStatement($query);
    return $result;
}

function deleteAviso($id) {
    $query = "DELETE FROM avisos WHERE id = $id";
    $result = executeStatement($query);
    return $result;
}

?>