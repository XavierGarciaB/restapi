<?php


function open() {
  $dbhost = "localhost";
  $dbport = 3306;
  $dbuser = "root";
  $dbpass = "";
  $db = "proyectolp";

  $connection = null;
  try {
    $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $db, $dbport);
  
    if (mysqli_connect_errno()) {
      throw new Exception("Could not connect to database.");   
    }
  } catch (Exception $e) {
    throw new Exception($e->getMessage());   
  }
  return $connection;
}

function select($query = "" , $params = []) {
  try {
    $link = open();
    $result = mysqli_query($link, $query);

    if($result && $result->num_rows > 0){
      mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    return $result;
  } catch(Exception $e) {
    throw New Exception( $e->getMessage() );
  }
  return false;
}

function executeStatement($query = "", $params = []) {
  try {
    $link = open();
    $result = mysqli_query($link, $query);

    return $result;
  } catch(Exception $e) {
    throw New Exception( $e->getMessage() );
  }
  return false;
}

?>