<?php
ini_set('display_errors',1);
error_reporting(E_ALL);

session_start();

require_once 'core/config.php';

//force the browser to use ssl (STRONGLY RECOMMENDED!!!!!!!!)
if ($_SERVER["SERVER_PORT"] != 443){ 
    header("Location: https://" . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']); 
    exit(); 
}

if ( in_array($_SERVER['REMOTE_ADDR'], $AUTH_USERS) ) {
  if ( isset($_SESSION['user_groups']) && in_array($AUTH_GROUP, $_SESSION['user_groups']) ) {
    ;
  }
  else {
    include 'includes/login.php';
    exit;
  }
}
else {
  include 'includes/login.php';
  exit;
}

require_once 'classes/Init.class.php';
require_once 'classes/User.class.php';
require_once 'classes/Operator.class.php';

$DATA = new Init(
  $STUD_RSTR_FILE,
  $PIN_FILES
);

$OPERATOR = new Operator (
  $_SESSION['username'],
  $_SESSION['user_info'],
  $_SESSION['user_groups'],
  $_SERVER['REMOTE_ADDR']
);
?>