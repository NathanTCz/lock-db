<?php
ini_set('display_errors',1);
error_reporting(E_ALL);

require_once 'core/config.php';

if (! in_array($_SERVER['REMOTE_ADDR'], $authorized_users) ) {
  //header('Location: no_access.php');
  include 'includes/no_access.php';
  //echo $_SERVER['REMOTE_ADDR'];
  exit;
}

require_once 'classes/Init.class.php';
require_once 'classes/User.class.php';

$DATA = new Init(
  $stud_roster_file,
  $pin_files
);
?>