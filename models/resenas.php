<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/restapi/db.php';
 
function listResenas() {
    $datos = [];
    $resultado = select("SELECT * FROM resenas");
    foreach($resultado as $review){
        array_push($datos, $review);
    }
    return $datos;
}

function createResena($review) {
    $usuario = $review->usuario_id;
    $comentario = $review->comentario;
    $profesional = $review->profesionales_id;
    $fecha = $review->fechaPublicacion;
    $query = "INSERT INTO resenas(fechaPublicacion,comentario,usuarios_id,profesionales_id) VALUES ('$fecha','$comentario','$usuario','$profesional')";
    $result = executeStatement($query);
    return $result;
}

function updateResena($review) {
    $fecha = $review->fechaPublicacion;
    $comentario = $review->comentario;
    $query = "UPDATE resenas SET fechaPublicacion='$fecha', comentario='$comentario' WHERE id=$id";
    $result = executeStatement($query);
    return $result;
}

function deleteResena($id) {
    $query = "DELETE FROM resenas WHERE id = $id";
    $resultado = executeStatement($query);
    return $resultado;
}

?>