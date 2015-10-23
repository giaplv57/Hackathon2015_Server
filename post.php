<?php
  include("common.php");
  $receivedRequest = json_decode(file_get_contents('php://input'), true);
  $result = array();

  if($receivedRequest['action'] === "listAllTag"){