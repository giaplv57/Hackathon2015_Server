<?php
  include("common.php");
  $con = ConnectDB();
  $i=1;
  while (True) {
     $getUserID = mysqli_query($con, "SELECT rand()");  
      $userID = mysqli_fetch_array($getUserID);
      // if(intval($userID[0])==0){
      //   echo "yea!";
      //   exit();
      // }
      echo floatval($userID[0]);
      echo PHP_EOL;
      $i++;
      if($i==100) exit();
  }
 
?>