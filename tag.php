<?php
  include("common.php");
  // header("Content-Type:application/json");
  $receivedRequest = ($_POST);
  $result = array();

  if($receivedRequest['action'] === "listAllTag"){
    $con = ConnectDB();
    mysqli_query($con, "SET NAMES 'UTF8'");

    $getAllTags = mysqli_query($con, "SELECT * FROM `tags`");  
    $result['message'] = "success";
    while($row = mysqli_fetch_assoc($getAllTags)){
      $result['data'][$row['id']] = $row['tagTitle'];
    }
    echo json_encode($result);
  }

  if($receivedRequest['action'] === "updateTag"){
    $con = ConnectDB();
    $userID = $receivedRequest['userID'];
    mysqli_query($con, "DELETE FROM taglist WHERE userID='$userID'");  
    foreach ($receivedRequest['tags'] as $tagID) {
      mysqli_query($con, "INSERT INTO taglist (userID,tagID) VALUES ('$userID','$tagID')");
      mysqli_query($con, "INSERT INTO feed (userID, eventID) SELECT '$userID',id FROM events WHERE tagID='$tagID'");
    }
    $result['message'] = "success";
    echo json_encode($result);
  }

  if($receivedRequest['action'] === "listFavoriteTag"){
    $con = ConnectDB();
    $userID = $receivedRequest['userID'];
    $getFavoriteTags = mysqli_query($con, "SELECT * FROM `taglist` WHERE userID='$userID'");  
    $result['message'] = "success";
    while($row = mysqli_fetch_assoc($getFavoriteTags)){
      $result['data'][] = $row['tagID'];
    }
    echo json_encode($result);
  }
?>