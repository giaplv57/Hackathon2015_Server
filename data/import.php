<?php
  include("./../common.php");
  $data = json_decode(file_get_contents("data487.json"));
  foreach ($data as $eventData){
    addEvent($eventData);
    usleep(200000);
  }

  function addEvent($eventData){
    if($eventData->tagID !== null){
      $con = ConnectDB();
      $userID = rand(1,99);
      $eventID = sha1($userID."J4F2015".time());
      $title = $eventData->title;
      $tagID = $eventData->tagID;
      $time = $eventData->time;
      $picture = $eventData->picture;
      $location = $eventData->location;
      $reference = $eventData->reference;
      $content = $eventData->content;
      mysqli_query($con, "INSERT INTO events (id,title,content,tagID,time,picture,location,reference) VALUES ('$eventID','$title','$content','$tagID','$time','$picture','$location','$reference')");
      mysqli_query($con, "INSERT INTO eventlist (userID, eventID) VALUES ('$userID','$eventID')");
      $result['message'] = "success";
      $result['eventID'] = $eventID;
      return json_encode($result);
    }
  }
?> 