<?php
  if(isset($_POST['username']) && isset($_POST['password'])) {
    require_once './Config.php';
    $con = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD,DB_DATABASE);
    $res = mysqli_query($con,'SELECT * FROM user_details WHERE username = "' . $_POST['username'] . '"');
    if(mysqli_num_rows($res) > 0) {
      echo "0";
    } else {
      $res = mysqli_query($con,'INSERT INTO user_details (`username`, `password`) VALUES("' . $_POST['username'] . '", "' . md5($_POST["password"]) . '")');
      echo "1";
    }
  }
?>
