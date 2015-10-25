<?php
  include("common.php");
  header("Content-Type:application/json");
  $receivedRequest = urlArrayDecode($_POST);
  $result = array();

  if($receivedRequest['action'] === "add"){
    $con = ConnectDB();
    $userID = $receivedRequest['userID'];
    $eventID = $receivedRequest['eventID'];
    mysqli_query($con, "UPDATE `feed` SET bookmark='1' WHERE userID='$userID' and eventID='$eventID'");  
    $result['message'] = "success";
    echo json_encode($result);
  }

  if($receivedRequest['action'] === "remove"){
    $con = ConnectDB();
    $userID = $receivedRequest['userID'];
    $eventID = $receivedRequest['eventID'];
    mysqli_query($con, "UPDATE `feed` SET bookmark=0 WHERE userID='$userID' and eventID='$eventID'");  
    $result['message'] = "success";
    echo json_encode($result);
  }
?>