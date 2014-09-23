<?php
chdir('../../');
require_once 'core/init.php';

$results = $DATA->search_lock_roster( $_GET['q'] );

if ( !empty($results) ) {
  echo '<span>' . count($results) . ' results</span><br/><br/>';

  foreach ( $results as $key => $user ) {
?>
  <div class="line_item" data-key="<?php echo $key;?>">
    <span><?php echo $user->name;?></span>
    <span><?php echo $user->cardnum;?></span>
    <span><?php echo $user->groups;?></span>
  </div>
<?php
  }
}
else {
?>
  <span>No results</span>
  <br/>
  <br/>
  <button>Create new user</button>
<?php
}
?>

<script src="ajax/js/loaddata.js"></script>