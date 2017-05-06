<html>
  <head>
  <script type="text/javascript">
    var username =  <?php session_start(); if (!isset($_SESSION['usrname'])) {echo "-1";} else {echo '"' . $_SESSION['usrname'] . '"';} ?>;
    if(username == "-1") {
      location.href = 'index.php';
    }
  </script>
  <script src="js/jquery.min.js"></script>
  <script src="js/searchScript.js"></script>
  <link rel="stylesheet" type="text/css" href="css/general.css" />
  <link rel="stylesheet" type="text/css" href="css/searchBar.css" />
  <link rel="stylesheet" type="text/css" href="css/mayLikeList.css" />
  <link rel="stylesheet" type="text/css" href="css/videoList.css" />
  <link rel="stylesheet" type="text/css" href="css/videoDisplay.css" />
  </head>
  <body>
    <form action="brain/search.php" method="post" id="search_form">
      <input type="search" id="search_query" name="search_query" placeholder="Click here to search..."/>
      <input type="submit" id="submit_btn" class="material-icons" value="send" name="button"/>
      <span id="line"></span>
    </form>
    <div id="video_may_like"></div>
    <div id="video_display"></div>
    <div id="video_result"></div>
  </body>
</html>
