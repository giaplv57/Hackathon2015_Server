<?php
  include("common.php");
  if(!isset($_POST['action'])){
    exit();
  }
  // APIKey = -1 for default !IMPORTANT
  if($_POST['action'] === "register" && $_POST['username'] && $_POST['password'] && $_POST['name'] && $_POST['age'] && $_POST['APIKey']){
    $con = ConnectDB();
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $password = sha1($_POST['password']);
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $age = $_POST['age'];
    $APIKey = mysqli_real_escape_string($con, $_POST['APIKey']);
    if($username===''|$password===''|$name===''|$age===''|$APIKey==='') exit();
    $checkDuplicate = mysqli_query($con,"SELECT id FROM `users` WHERE username='$username'");
    if(mysqli_num_rows($checkDuplicate) == 0){
      mysqli_query($con,"INSERT INTO users (username, password,APIKey) VALUES ('$username', '$password', '$APIKey')");
      echo 1;
    }else{
      echo 0; //DUPLICATED USERNAME
    }
    @mysqli_close($con) or die("-1"); //CANNOT EXIT DB
  }

  if($_POST['action'] === "login" && $_POST['username'] && $_POST['password']){
    $con = ConnectDB();
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $password = sha1($_POST['password']);
    if($username===''|$password==='') exit();
    
    $checkUser = mysqli_query($con, "SELECT * FROM `users` where username = '$username' AND password = '$password'");
      $row = mysqli_fetch_array($checkUser);
      if(!empty($row['username']) AND !empty($row['password']) AND !empty($row['id'])) {
        echo $row['id'];
      }else{
        echo 0; //NOT FOUND ANY USER
      }
      @mysqli_close($con) or die("-1"); //CANNOT EXIT DB
  }
?>