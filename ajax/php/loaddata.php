<?php
chdir('../../');
require_once 'core/init.php';

$DATA->parse_pin_files();

$user = $DATA->lock_roster[ $_GET['i'] ];
?>
<div class="info_box">
  <div><span>Name:</span><span><?php echo $user->name;?></span></div>
  <div><span>Card #:</span><span><?php echo $user->cardnum;?></span></div>
  <div><span>PIN #:</span><span><?php echo $user->pin;?></span></div>
  <div><span>Groups:</span><span><?php echo $user->groups;?></span></div>
  <br />
  <span>Note: to deactivate a user, simply prepend an asterisk to the last name</span>
</div>
<br />
<button id="ed_user" data-key="<?php echo $_GET['i'];?>">Edit User</button>
<button class="confirm" id="del_user" data-key="<?php echo $_GET['i'];?>">Delete User</button>

<script>
/* Initialise the .confirm() plugin:
 * Due to the nature of this element in HTML, This
 * snippet must be run on every load. Therefore it should
 * be placed here insted of loaddata.js
*/
$('.confirm').confirm({
  text: "Are you sure you want to delete this user?",
  confirm: function(button) {
    var sendData = {
      index: button.attr('data-key'),
      action: 'd'
    };

    $.ajax({
      url: 'ajax/php/create_user.php',
      type: 'POST',
      data: sendData,
      success: function(data) {
        $('#contents').html(data);
      }
    });
  },
  cancel: function(button) {
    // do nothing.
  }
});
</script>