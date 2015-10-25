<?php
  include("common.php");
  header("Content-Type:application/json");
  $receivedRequest = urlArrayDecode($_POST);
  $result = array();

  if($receivedRequest['action'] === "addComment"){
    echo addComment($receivedRequest);
  }
  if($receivedRequest['action'] === "getComments"){
    echo getComments($receivedRequest);
  }

  function addComment($receivedRequest){
    $con = ConnectDB();
    $userID = $receivedRequest['userID'];
    $eventID = $receivedRequest['eventID'];
    $content = $receivedRequest['content'];
    mysqli_query($con, "INSERT INTO comments (eventID, userID, content) VALUES ('$eventID', '$userID', '$content')");
    return getComments($receivedRequest);
  }

  function getComments($receivedRequest){
    $con = ConnectDB();
    $eventID = $receivedRequest['eventID'];
    $page = $receivedRequest['page'];
    $offset = (intval($page)-1) * 10;
    $result['message'] = "success";
    $getEvent = mysqli_query($con, "SELECT * FROM `comments` WHERE eventID='$eventID' ORDER BY time DESC LIMIT $offset,10");  
    while($event = mysqli_fetch_assoc($getEvent)){
      $result['data'][] = $event;
    }
    return json_encode($result);
  }
?>