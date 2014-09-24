<?php
chdir('../../');
require_once 'core/init.php';

?>
<div class="upload">
  <p>
  Upload a CSV file for batch import here. The CSV file must be in the following
  format in order to be accepted and parsed properly. Make sure to choose the
  appropriate action for the file and specify the points of access to be added/removed.
  <br/>
  <br/>
  LASTNAME,FIRSTNAME,CARDNUMBER,PIN
  </p>
  <input type="file"></input>
</div>