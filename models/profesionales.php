<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/restapi/db.php';
 
function getProfesionales() {
    $data = [];
    $result = select("SELECT * FROM profesionales;");
    foreach($result as $profi){
        array_push($data, $profi);
    }
    return $data;
}

?>