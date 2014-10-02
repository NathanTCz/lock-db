<?php
chdir('../../');
require_once 'core/init.php';
$DATA->parse_pin_files();
$DATA->parse_students();

if ( isset($_FILES) && !empty($_FILES) ) {
  $conflicts = $DATA->parse_csv( $_FILES['lfile']['tmp_name'], $_POST['type'], $_POST['points'], $_POST['action'] );

  if ( !empty($conflicts) ) {
?>
    <span><?php echo count($conflicts['new']);?> issues need to be resolved.</span>
    <br/><br/>
<?php
    foreach ( $conflicts['new'] as $new_stud ) {
?>
      <span><b><?php echo $new_stud->name?></b> is not on the student roster.</span>
      <span>Did you mean?</span>
      <br/>
  <?php
      $results = $DATA->fuzzy_search_students($new_stud->last_name);
      foreach ( $results as $key => $user ) {
  ?>
        <div class="line_item3" data-orig="<?php echo $new_stud->name;?>" data-key="<?php echo $key;?>">
          <span><?php echo $user->name;?></span>
          <span><?php echo $user->cardnum;?></span>
          <span><?php echo $user->groups;?></span>
        </div>
  <?php
      }
      echo '<br/><br/>';
    }
  }
  else {
    echo 'File import complete';
  }
}
else {
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
  <form id="upload_form" enctype="multipart/form-data">
  <div>
    <input id="lfile" type="file" name="lfile" accept="text/csv"></input>
  </div>
  <div>
    <span>Type</span>
    <select id="type" name="type">
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
    <textarea id="points" placeholder="groups and/or access points separated by a comma."><?php if(isset($user)) echo $user->groups;?></textarea>
    <span id="point_errors"></span>
  </div>
  <div>
    <input type="radio" name="action" value="add"></input>
      <label>Add</label>

    <input type="radio" name="action" value="remove"></input>
      <label>Remove</label>
  </div>
  </form>
  <div>
    <button id="upload">Upload</button>
  </div>
</div>
<?php
}
?>