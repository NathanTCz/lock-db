<?php
require_once 'core/init.php';
?>

<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="ajax/js/general.js"></script>
    <script src="ajax/js/loaddata.js"></script>
    <script src="ajax/js/create_user.js"></script>
  </head>

  <body>
    <div class="wrapper">
      <span id="title">Lock Utility</span>

      <div class="tools">
        <div class="formbox">
          <span>
            <span>Search </span>
            <input id="name_box" type="text" name="name" placeholder=" Last Name.."></input>
          </span>
        </div>

        <button id="up_csv">Upload File</button>
      </div>



      <div id="contents" class="contents"></div>
    </div>
  </body>
</html>