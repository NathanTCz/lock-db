<?php
chdir('../../');
require_once 'core/init.php';

$DATA->parse_pin_files();
$results = $DATA->search_lock_roster( $_GET['q'] );
//$results = $DATA->fuzzy_search_lockdb( $_GET['q'] );
if ( !empty($results) ) {
  echo '<span>' . count($results) . ' results</span><br/><br/>';

  foreach ( $results as $key => $user ) {
?>
  <div class="line_item1" data-key="<?php echo $key;?>">
    <span><?php echo $user->name;?></span>
    <span><?php echo $user->cardnum;?></span>
    <span><?php echo $user->groups;?></span>
  </div>
<?php
  }
}
else {
  $DATA->parse_students();
  $results = $DATA->fuzzy_search_lockdb( $_GET['q'] );
?>
  <span>No results</span>
  <br/>
  <br/>
  <button id="cr_user">Create New User</button>
<?php
  if ( !empty($results) ) {
?>
    <br/>
    <br/>
    <br/>
    <span>Did you mean?</span>
    <br/>
    <br/>
<?php
    foreach ( $results as $key => $user ) {
?>
      <div class="line_item1" data-key="<?php echo $key;?>">
        <span><?php echo $user->name;?></span>
        <span><?php echo $user->cardnum;?></span>
        <span><?php echo $user->groups;?></span>
      </div>
<?php
    }
  }
}
?>