<?php
require_once 'core/init.php';
?>

<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  </head>

  <body>
    <div class="wrapper">
      <span id="title">Lock Utility</span>

      <div class="formbox">
        <form method="POST" action="#">
          <span>
            <span>Last Name</span>
            <input id="name_box" type="text" name="name"></input>
          </span>
          <span>
        </form>
      </div>

      <div id="contents" class="contents"></div>
    </div>
  </body>


  <script src="ajax/js/search.js"></script>
</html>