<?php
  include("./../common.php");
  $data = json_decode(file_get_contents("data487.json"));
  foreach ($data as $eventData){
    addEvent($eventData);
    usleep(200000);
  }

  function addEvent($eventData){
    if($eventData->tagID === null){
      return;
    }else{
      $con = ConnectDB();
      $tagID = $eventData->tagID;
      if(in_array($tagID, array("3","4","5","6","7","8","9","13"))){
        $tagID = "".rand(9, 11);
      }else if(in_array($tagID, array("10","11","12","14","15","16"))){
        if($tagID == "10") $tagID = "3";
        if($tagID == "11") $tagID = "4";
        if($tagID == "12") $tagID = "5";
        if($tagID == "14") $tagID = "6";
        if($tagID == "15") $tagID = "7";
        if($tagID == "16") $tagID = "8";
      }
      $userID = rand(1,99);
      $eventID = sha1($userID."J4F2015".time());
      $title = $eventData->title;
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