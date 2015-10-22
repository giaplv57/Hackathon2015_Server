<html>
<head>
  <title></title>
  <meta charset="UTF-8">
</head>
</html>

<?php
  include("common.php");
  $receivedRequest = json_decode(file_get_contents('php://input'), true);
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
    foreach ($receivedRequest['data'] as $tagID) {
      mysqli_query($con, "INSERT INTO taglist (userID,tagID) VALUES ('$userID','$tagID')");  
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