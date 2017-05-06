<?php
require_once './Config.php';
$con = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD,DB_DATABASE);
$res = mysqli_query($con,'SELECT * FROM user_details WHERE username = "' . $_POST["username"] . '" AND password = "' . md5($_POST["password"]) . '"');
if(mysqli_num_rows($res) == 0) {
  echo "0";
} else {
  echo "1";
}
?>
