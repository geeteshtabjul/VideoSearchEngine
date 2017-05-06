<?php
  require_once './Config.php';
  $con = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD,DB_DATABASE);
  $res = mysqli_query($con, 'SELECT * FROM click_log WHERE username = "' . $_POST["username"] . '" AND videoId = "' . $_POST["videoId"] . '"');
  if(mysqli_num_rows($res) == 0) {
    $res = mysqli_query($con, 'INSERT INTO click_log VALUES ("' . $_POST["videoId"] . '", "' . $_POST["username"] . '", "' . time() . '", 1, 1)');
  } else {
    $res = mysqli_query($con, 'UPDATE click_log SET click_log.time = (click_log.time*num_clicks + ' . time() . ')/(num_clicks + 1), num_clicks = num_clicks + 1 WHERE username = "' . $_POST["username"] . '" AND videoId = "' . $_POST["videoId"] . '"');
    $res = mysqli_query($con, 'UPDATE click_log SET score = (num_clicks/20)*score + 1/POWER(2, (' . time() . ' - click_log.time)/86400) WHERE username = "' . $_POST["username"] . '" AND videoId = "' . $_POST["videoId"] . '"');
  }
  $res = mysqli_query($con, 'UPDATE click_log SET score = score*0.98 WHERE username = "' . $_POST["username"] . '" AND videoId != "' . $_POST["videoId"] . '"');

  $m = new MongoClient("mongodb://127.0.0.1");
  $db = $m->test;
  $collection = $db->YoutubeVideos;
  $newdata = array('$inc' => array("videoInfo.statistics.viewCount" => 1));
  $collection->update(array("videoInfo.id" => $_POST["videoId"]), $newdata, array("multiple" => true));
?>
