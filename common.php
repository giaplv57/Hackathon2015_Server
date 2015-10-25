<?php
  function ConnectDB(){
    $db_username="root";
    $db_password="";
    $database="Hackathon2015";
    $con=mysqli_connect('127.0.0.1', $db_username, $db_password, $database);
    return $con;
  }

  function pushGCM($eventID,$title,$tagID,$posterID){
    $msg = array(
            'eventID' => $eventID,
            'title' => $title,
            'tagID' => $tagID,
            'posterID' => $posterID
        );
    $fields = array(
        'to' => "/topics/tagID".$tagID,
        'data' => $msg
    );

    $headers = array(
        'Authorization: key=AIzaSyCosDg2TpdCOwczc7wAAYiw4Pjx-AFjFDs ',
        'Content-Type: application/json'
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'http://android.googleapis.com/gcm/send');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;   
  }
?>


