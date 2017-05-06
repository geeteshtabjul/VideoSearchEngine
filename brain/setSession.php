<?php
  if(isset($_GET["username"])) {
    session_start();
    $_SESSION["usrname"] = $_GET["username"];
    header('Location: ../engine.php');
  }
?>
