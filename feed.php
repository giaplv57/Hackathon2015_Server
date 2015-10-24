<?php 
  include("common.php");
  header("Content-Type:application/json");
  $receivedRequest = $_POST;
  $result = array();
  if($receivedRequest['action'] === "getEventFeeds"){
    echo getEventFeeds($receivedRequest['userID'], $receivedRequest['page']);
  }

  function getEventFeeds($userID, $page){
    $con = ConnectDB();
    $offset = (intval($page)-1) * 10;
    $result['message'] = "success";
    $getEvents = mysqli_query($con, "SELECT * FROM events WHERE id IN (SELECT eventID FROM `feed` WHERE userID='$userID') order by timestamp LIMIT $offset,10");  
    while($event = mysqli_fetch_assoc($getEvents)){
      $result['data'][] = $event;
    }
    return json_encode($result);
  }
?>