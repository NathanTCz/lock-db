<?php
ini_set('display_errors',1);
error_reporting(E_ALL);

require_once 'core/config.php';

if (! in_array($_SERVER['REMOTE_ADDR'], $AUTH_USERS) ) {
  include 'includes/no_access.php';
  exit;
}

require_once 'classes/Init.class.php';
require_once 'classes/User.class.php';

$DATA = new Init(
  $STUD_RSTR_FILE,
  $PIN_FILES
);
?>