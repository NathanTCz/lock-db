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
  $DATA->flush_lock_roster();
}
else {
?>
<div class="create_u">
  <div>
    <span>First Name</span>
    <input id="fname" type="text"></input>
  </div>
  <div>
    <span>Last Name</span>
    <input id="lname" type="text"></input>
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
      ?>
      <option value="<?php echo $fname;?>"><?php echo $type;?></option>
      <?php
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
<?php
}
?>

<script src="ajax/js/create_user.js"></script>