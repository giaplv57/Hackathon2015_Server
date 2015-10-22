<?php
  function ConnectDB(){
    $db_username="root";
    $db_password="";
    $database="Hackathon2015";
    $con=mysqli_connect('127.0.0.1', $db_username, $db_password, $database);
    return $con;
  }
?>