<?php
chdir('../../');
require_once 'core/init.php';

if ( !empty($_POST) ) {
  $points = preg_replace("/\s/", '', $_POST['q'] );
  $points = explode( ',', $points );

  foreach ($points as $point) {
    trim( $point );
    if ( in_array($point, $GROUPS) || in_array($point, $DOORS) ) {
      continue;
    }
    else echo '* \'' . $point . '\' is not a valid group or access point<br />';
  }
}
?>