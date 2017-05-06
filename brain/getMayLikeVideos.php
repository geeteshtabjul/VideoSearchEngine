<?php
require_once './Config.php';
require_once 'constants.php';
$con = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD,DB_DATABASE);
$res = mysqli_query($con,'SELECT videoId FROM click_log WHERE username = "' . $_POST["username"] . '" ORDER BY score DESC LIMIT 5');
$videos = array();
if(mysqli_num_rows($res) > 0) {
  $userList = array();
  foreach($res as $video) {
    $result = mysqli_query($con,'SELECT username FROM click_log WHERE videoId = "' . $video['videoId'] . '" ORDER BY score DESC LIMIT 2');
    foreach($result as $item) {
      array_push($userList, $item['username']);
    }
  }
  $userList = array_unique($userList);
  foreach($userList as $user) {
    $result = mysqli_query($con,'SELECT videoId FROM click_log WHERE username = "' . $user . '" ORDER BY score DESC LIMIT 2');
    foreach($result as $vide) {
      array_push($videos, $vide['videoId']);
    }
  }
  $videos = array_unique($videos);
} else {
  $videos = array();
  $result = mysqli_query($con,'SELECT videoId FROM click_log ORDER BY score DESC LIMIT 10');
  foreach($result as $item) {
    array_push($videos, $item['videoId']);
  }
  $videos = array_unique($videos);
}
$videos = implode($delimeter, $videos);
echo $videos;
?>
