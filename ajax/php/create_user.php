<?php
chdir('../../');
require_once 'core/init.php';

$DATA->parse_pin_files();

if ( isset($_POST) && !empty($_POST) ) {
  if ($_POST['action'] === 'c') {
    $new_user = new User (
      $_POST['lname'] . ', ' . $_POST['fname'],
      $_POST['cardnum'],
      $_POST['pin'],
      trim( $_POST['points'] ),
      $_POST['type']
    );

    $DATA->lock_roster[] = $new_user;

    // save new user/flush rosters
    $DATA->flush_lock_roster($new_user->type);

    echo 'User: ' . $new_user->name . ' has been saved to the database.';
  }
  elseif ($_POST['action'] === 'u') {
    $new_user = new User (
      $_POST['lname'] . ', ' . $_POST['fname'],
      $_POST['cardnum'],
      $_POST['pin'],
      trim( $_POST['points'] ),
      $_POST['type']
    );

    $DATA->lock_roster[ $_POST['index'] ] = $new_user;

    // update all pin files just in case the user chaged type.
    $DATA->flush_all_lock_roster($new_user->type);

    echo 'User: ' . $new_user->name . ' has been updated.';
  }
}
else {
  if ( !empty($_GET) && isset( $_GET['type'] ) ) {
    if ($_GET['type'] == 'u') {
      $DATA->parse_pin_files();
      $user = $DATA->lock_roster[ $_GET['i'] ];
    }
    if ($_GET['type'] == 's') {
      $DATA->parse_students();
      $user = $DATA->student_roster[ $_GET['i'] ];
    }

  }
  else $user = null;

?>
<div class="create_u">
  <input id="action" type="hidden"
    value="<?php if(isset($_GET)) echo $_GET['action'];?>">
  </input>
  <input id="index" type="hidden"
    value="<?php if(isset($_GET['i'])) echo $_GET['i'];?>">
  </input>
  <input id="valid" type="hidden" value="1"></input>
  <div>
    <span>Last Name</span>
    <input id="lname" type="text"
      value="<?php if(isset($user)) echo $user->last_name;?>">
    </input>
  </div>
  <div>
    <span>First Name</span>
    <input id="fname" type="text"
      value="<?php if(isset($user)) echo $user->first_name;?>">
    </input>
  </div>
  <div>
    <span>Card #</span>
    <input id="cardnum" type="text"
      value="<?php if(isset($user)) echo $user->cardnum;?>">
    </input>
    <span id="card_errors"></span>
  </div>
  <div>
    <span>PIN #</span>
    <input id="pin" type="text"
      value="<?php if(isset($user)) echo $user->pin;?>">
    </input>
    <span id="pin_errors"></span>
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
    <textarea id="points" placeholder="groups and/or access points separated by a comma."><?php if(isset($user)) echo $user->groups;?></textarea>
    <span id="point_errors"></span>
  </div>
  <div>
    <button id="save">Save User</button>
  </div>
</div>

<div id="search_list" class="search_list"></div>
<?php
}
?>