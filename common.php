<?php
  function ConnectDB(){
    $db_username="root";
    $db_password="";
    $database="Hackathon2015";
    $con=mysqli_connect('127.0.0.1', $db_username, $db_password, $database);
    return $con;
  }

  function urlArrayDecode($inputArray){
    foreach ($inputArray as $key => $value) {
        $inputArray[$key] = urldecode($inputArray[$key]);
    }
    return $inputArray;
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
    $options = array(
        'http' => array(
            'header'  => array('Authorization: key=AIzaSyCosDg2TpdCOwczc7wAAYiw4Pjx-AFjFDs ',
                                'Content-Type: application/json'),
            'method'  => 'POST',
            'content' => json_encode($fields),
        ),
    );

    $context  = stream_context_create($options);
    file_get_contents("http://android.googleapis.com/gcm/send", false, $context);
  }
?>


