<html>
  <head>
    <script type="text/javascript">
      var b = <?php if (session_status() == PHP_SESSION_NONE) {echo "0";} else {echo "1";} ?> ;
      if(b == "1") {
        location.href = 'engine.php';
      }
    </script>
    <link rel="stylesheet" href="css/loginPage.css">
    <script src="js/jquery.min.js"></script>
    <script src="js/loginPage.js"></script>
  </head>
  <body>
    <hgroup>
      <h1>Login Page</h1>
    </hgroup>
    <form action="brain/loginPage.php" method="post" id="login_form">
      <div class="group">
        <input id="user_name" type="text"><span class="highlight"></span><span class="bar"></span>
        <label>Username</label>
      </div>
      <div class="group">
        <input id="pass_word" type="password"><span class="highlight"></span><span class="bar"></span>
        <label>Password</label>
      </div>
      <p id="wrongCre" style="visibility:hidden;">Wrong credentials!</p>
      <button type="submit" class="button buttonBlue">Login
        <div class="ripples buttonRipples"><span class="ripplesCircle"></span></div>
      </button>
      <button id="create_account" type="button" class="button buttonBlue">Create a new account
        <div class="ripples buttonRipples"><span class="ripplesCircle"></span></div>
      </button>
    </form>
  </body>
</html>
