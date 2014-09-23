<?php
ini_set('display_errors',1);
error_reporting(E_ALL);

require_once 'classes/Init.class.php';
require_once 'classes/User.class.php';

$DATA = new Init(
  'lock-db/flatdb/roster.txt',
  array(
    'lock-db/flatdb/faculty.pins',
    'lock-db/flatdb/staff.pins',
    'lock-db/flatdb/student.pins',
    'lock-db/flatdb/guest.pins',
    'lock-db/flatdb/university.pins'
  )
);
?>