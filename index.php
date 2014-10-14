<?php
require_once 'core/init.php';
?>

<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/modal.css">

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.confirm.min.js"></script>
    <script src="ajax/js/general.js"></script>
    <script src="ajax/js/loaddata.js"></script>
    <script src="ajax/js/create_user.js"></script>
    <script src="ajax/js/upload.js"></script>
    <script src="ajax/js/create_doors.js"></script>
  </head>

  <body>
    <div id="p_bar"></div>

    <div class="wrapper">
      <span id="title">warLock</span>

      <div class="tools">
        <div class="formbox">
          <span>
            <span>Search </span>
            <input id="name_box" type="text" name="name" autocomplete="off" placeholder=" Last Name.."></input>
          </span>
        </div>

        <button id="logout">Logout</button>
        <button id="cr_doors">Create Lock Files</button>
        <button id="up_csv">Import File</button>
      </div>



      <div id="contents" class="contents"></div>
      <div class="version">
        <?php echo 'rev ' . $CURR_VERSION;?>
      </div>
    </div>
  </body>
</html>