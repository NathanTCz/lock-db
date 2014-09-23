<?php
chdir('../../');
require_once 'core/init.php';

$DATA->parse_pin_files();

if (! empty($_POST) ) {
  $new_user = new User (
    $_POST['lname'] . ', ' . $_POST['fname'],
    $_POST['cardnum'],
    $_POST['pin'],
    $_POST['points'],
    $_POST['type']
  );

  //var_dump($new_user);

  $DATA->lock_roster[$new_user->last_name] = $new_user;

  // save new user/flush rosters
  $DATA->flush_lock_roster($new_user->type);

  echo 'User: ' . $new_user->name . ' has been saved to the database';
}
else {
  if (! empty($_GET) ) {
    $DATA->parse_students();
    $user = $DATA->student_roster[ $_GET['i'] ];
  }
  else $user = null;

?>
<div class="create_u">
  <div>
    <span>Last Name</span>
    <input id="lname" type="text"
      value="<?php if(isset($user)) echo $user->last_name;?>">
    </input>
  </div>
  <div>
    <span>First Name</span>
    <input id="fname" type="text"
      value="<?php if(isset($user)) echo $user->fname;?>">
    </input>
  </div>
  <div>
    <span>Card #</span>
    <input id="cardnum" type="text"></input>
  </div>
  <div>
    <span>PIN #</span>
    <input id="pin" type="text"></input>
  </div>
  <div>
    <span>Type</span>
    <select id="type">
      <?php
      foreach ($DATA->types as $fname => $type) {
        if ( isset($user) && $fname === $user->type) {
      ?>
      <option selected value="<?php echo $fname;?>"><?php echo $type;?></option>
      <?php
       }
        else {
      ?>
      <option value="<?php echo $fname;?>"><?php echo $type;?></option>
      <?php
        }
      }
      ?>
    </select>
  </div>
  <div>
    <span>Groups or Access Points</span>
    <br />
    <textarea id="points" placeholder="groups and/or access points separated by a comma. no spaces"></textarea>
  </div>
  <div>
    <button id="save">Save User</button>
  </div>
</div>

<div id="search_list" class="search_list">

</div>
<?php
}
?>

<script src="ajax/js/create_user.js"></script>