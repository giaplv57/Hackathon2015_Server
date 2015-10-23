<?php
  include("common.php");
  header("Content-Type:application/json");
  $receivedRequest = $_POST;
  $result = array();
  if($receivedRequest['action'] === "add"){
    echo addEvent($receivedRequest);
  }
  if($receivedRequest['action'] === "get"){
    echo getEvent($receivedRequest);
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
    $content = $eventData['content'];
    mysqli_query($con, "INSERT INTO events (id,title,content,tagID,time,picture,location,reference) VALUES ('$eventID','$title','$content','$tagID','$time','$picture','$location','$reference')");
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
    return json_encode($event);
  }
?>
