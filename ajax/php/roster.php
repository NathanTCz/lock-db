<?php
chdir('../../');
require_once 'core/init.php';

$results = $DATA->search_roster( $_GET['q'] );

if ( !empty($results) ) {
  foreach ( $results as $name ) {
?>
    <span><?php echo $name->name;?></span>
    <span><?php echo $name->emplid;?></span>
    <span><?php echo $name->major;?></span>
    <br/>
<?php
  }
}
else echo 'No results';
?>