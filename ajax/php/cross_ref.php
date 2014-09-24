<?php
chdir('../../');
require_once 'core/init.php';

$results = $DATA->search_student_roster( $_GET['q'] );

if ( !empty($results) ) {
  echo '<span>' . count($results) . ' results</span><br/><br/>';

  foreach ( $results as $key => $user ) {
?>
  <div class="line_item2" data-key="<?php echo $key;?>">
    <span><?php echo $user->name;?></span>
  </div>
<?php
  }
}
else {
?>
  <span>No results</span>
<?php
}
?>