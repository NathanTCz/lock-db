<?php
ini_set('display_errors',1);
error_reporting(E_ALL);

session_start();

require_once 'core/config.php';

if ( in_array($_SERVER['REMOTE_ADDR'], $AUTH_USERS) ) {
  if ( isset($_SESSION['user_groups']) && in_array($AUTH_GROUP, $_SESSION['user_groups']) ) {
    ;
  }
  else {
    header('Location: login.php');
    exit;
  }
}
else {
  //include 'includes/no_access.php';
  header('Location: login.php');
  exit;
}

require_once 'classes/Init.class.php';
require_once 'classes/User.class.php';

$DATA = new Init(
  $STUD_RSTR_FILE,
  $PIN_FILES
);
?>