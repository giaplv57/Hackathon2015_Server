<?php
  include("common.php");
  header("Content-Type:application/json");
  if(!isset($_POST['action'])){
    exit();
  }
  // APIKey = -1 for default !IMPORTANT
  $result = array();

  if($_POST['action'] === "register" && $_POST['username'] && $_POST['password'] && $_POST['name'] && $_POST['age'] && $_POST['APIKey']){
    $con = ConnectDB();
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $password = sha1($_POST['password']);
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $age = (int)$_POST['age'];
    $APIKey = mysqli_real_escape_string($con, $_POST['APIKey']);
    if($username===''|$password===''|$name===''|$age===''|$APIKey==='') exit();
    $checkDuplicate = mysqli_query($con,"SELECT id FROM `users` WHERE username='$username'");
    if(mysqli_num_rows($checkDuplicate) == 0){
      mysqli_query($con,"INSERT INTO users (username, password, name, age, APIKey) VALUES ('$username', '$password', '$name', '$age', '$APIKey')");
      $getUserID = mysqli_query($con, "SELECT id FROM `users` where username = '$username' AND password = '$password'");  
      $userID = mysqli_fetch_array($getUserID);
      $result['status'] = "1";
      $result['userID'] = $userID[0];
    }else{
      $result['status'] = "0"; //DUPLICATED USERNAME
    }
    @mysqli_close($con) or die("-1"); //CANNOT EXIT DB
    echo json_encode($result);
  }

  if($_POST['action'] === "login" && $_POST['username'] && $_POST['password']){
    $con = ConnectDB();
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $password = sha1($_POST['password']);
    if($username===''|$password==='') exit();
    
    $checkUser = mysqli_query($con, "SELECT * FROM `users` where username = '$username' AND password = '$password'");
      $row = mysqli_fetch_array($checkUser);
      if(!empty($row['username'])) {
        $userID = $row['id'];
        $result['status'] = "1";
        $result['userID'] = $userID;
        $result['name'] = $row['name'];
        $getTags = mysqli_query($con, "SELECT tagID FROM `taglist` where userID = '$userID'");
        while($row = mysqli_fetch_assoc($getTags)){
          $result['tags'][] = $row['tagID'];
        }
        $result['avatar'] = "http://z1h4wk.me/otherStuffs/Hackathon2015_Server/media/avatars/".rand(1,11).".jpeg";
      }else{
        $result['status'] = "0"; //NOT FOUND ANY USER
      }
      @mysqli_close($con) or die("-1"); //CANNOT EXIT DB
      echo json_encode($result);
  }

  if($_POST['action'] === "getUser"){
    $con = ConnectDB();
    $userID =$_POST['userID'];
    $getUser = mysqli_query($con, "SELECT * FROM users WHERE id='$userID'");  
    $user = mysqli_fetch_array($getUser);
    $result['status'] = "1";
    $result['data'] = $user;
    echo json_encode($result);
  }
?>