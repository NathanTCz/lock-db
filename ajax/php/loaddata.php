<?php
chdir('../../');
require_once 'core/init.php';

$DATA->parse_pin_files();

$user = $DATA->roster[ $_GET['i'] ];
?>
<div class="info_box">
  <div><span>Name:</span><span><?php echo $user->name;?></span></div>
  <div><span>Card #:</span><span><?php echo $user->cardnum;?></span></div>
  <div><span>PIN #:</span><span><?php echo $user->pin;?></span></div>
  <div><span>Groups:</span><span><?php echo $user->groups;?></span></div>
</div>