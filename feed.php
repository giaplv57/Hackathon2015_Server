<?php 
  include("common.php");
  // header("Content-Type:application/json");
  $receivedRequest = $_POST;
  $result = array();
  if($receivedRequest['action'] === "getEventsRecommend"){
    echo getEventsRecommend($receivedRequest['userID'], $receivedRequest['page']);
  }
  if($receivedRequest['action'] === "getEventsPopular"){
    echo getEventsPopular($receivedRequest['userID'], $receivedRequest['page']);
  }
  if($receivedRequest['action'] === "getEventsNearby"){
    echo getEventsNearby($receivedRequest['userID'], $receivedRequest['page']);
  }

  function getEventsRecommend($userID, $page){
    $con = ConnectDB();
    $offset = (intval($page)-1) * 10;
    $result['message'] = "success";
    $getEvents = mysqli_query($con, "SELECT events.*,eventlist.userID AS posterID FROM events LEFT JOIN feed ON events.id=feed.eventID LEFT JOIN eventlist ON events.id=eventlist.eventID WHERE feed.userID='$userID' ORDER BY feed.score DESC LIMIT $offset,10");  
    while($event = mysqli_fetch_assoc($getEvents)){
      $result['data'][] = $event;
    }
    return json_encode($result);
  }

  function getEventsPopular($userID, $page){
    $con = ConnectDB();
    $offset = (intval($page)-1) * 10;
    $result['message'] = "success";
    $getEvents = mysqli_query($con, "SELECT events.*,eventlist.userID AS posterID FROM events LEFT JOIN feed ON events.id=feed.eventID LEFT JOIN eventlist ON events.id=eventlist.eventID WHERE feed.userID='$userID' ORDER BY feed.viewCount DESC LIMIT $offset,10");  
    while($event = mysqli_fetch_assoc($getEvents)){
      $result['data'][] = $event;
    }
    return json_encode($result);
  }

  function getEventsNearby($userID, $page){
    $con = ConnectDB();
    $offset = (intval($page)-1) * 10;
    $result['message'] = "success";
    $getEvents = mysqli_query($con, "SELECT events.*,eventlist.userID AS posterID FROM events LEFT JOIN feed ON events.id=feed.eventID LEFT JOIN eventlist ON events.id=eventlist.eventID WHERE feed.userID='$userID' LIMIT $offset,10");  
    while($event = mysqli_fetch_assoc($getEvents)){
      $result['data'][] = $event;
    }
    return json_encode($result);
  }
?>