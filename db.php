<?php

include 'db_connection.php';

function open() {
  $dbhost = "localhost";
  $dbport = 3306;
  $dbuser = "root";
  $dbpass = "brosv1dv7z";
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

function select($query = "" , $params = [])
{
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

/*
function executeStatement($query = "" , $params = [])
{
  try {
    $link = open();
    $stmt = mysqli_prepare($link, $query);

    if($stmt === false) {
      throw New Exception("Unable to do prepared statement: " . $query);
    }

    if ($params) {
      mysqli_stmt_bind_param($stmt, $params[0], $params[1]);
    }

    mysqli_stmt_execute($stmt);

    return $stmt;
  } catch(Exception $e) {
    throw New Exception( $e->getMessage() );
  }   
}
*/
   
?>