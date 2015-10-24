<?php
  include("./../common.php");
  for($i=0; $i<100; $i++){
    $username = "test".$i."@gmail.com";
    $password = sha1("".$i);
    // var_dump($username);
    // var_dump($password);
    $name = "full name ".$i;
    $age = rand(15,60);
    $APIKey = "-1";
    $con = ConnectDB();
    mysqli_query($con,"INSERT INTO users (username, password, name, age, APIKey) VALUES ('$username', '$password', '$name', '$age', '$APIKey')");
    $tagRange = rand(2,9);
    $tagIDs = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11");
    foreach (array_rand($tagIDs, $tagRange) as $key => $value) {
      $tagID = $value + 1;
      mysqli_query($con,"INSERT INTO taglist (userID, tagID) VALUES ('$i', '$tagID')");
    }
  }
?>