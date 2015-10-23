<?php
  include("common.php");
  header("Content-Type:application/json");
  $receivedRequest = json_decode(file_get_contents('php://input'), true);
  $result = array();
  // var_dump($receivedRequest);
  if($receivedRequest['action'] === "add"){
    echo addEvent($receivedRequest['data']);
  }
  if($receivedRequest['action'] === "get"){
    echo getEvent($receivedRequest['data']);
  }

  function addEvent($eventData){
    $con = ConnectDB();
    $userID = $eventData['userID'];
    $eventID = sha1($userID+time());
    $title = $eventData['title'];
    $tagID = $eventData['tagID'];
    $time = $eventData['time'];
    $picture = $eventData['picture'];
    $location = $eventData['location'];
    $reference = $eventData['title'];

    mysqli_query($con, "INSERT INTO events (id,title,tagID,time,picture,location,reference) VALUES ('$eventID','$title','$tagID','$time','$picture','$location','$reference')");

    mysqli_query($con, "INSERT INTO eventList (userID, eventID) VALUES ('$userID','$eventID')");
    $result['message'] = "success";
    $result['eventID'] = $eventID;
    return json_encode($result);
  }

  function getEvent($eventData){
    $con = ConnectDB();
    $eventID = $eventData['eventID'];
    $getEvent = mysqli_query($con, "SELECT * FROM `events` where id='$eventID'");  
    $event = mysqli_fetch_array($getEvent);
    echo json_encode($event);
  }