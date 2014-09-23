/*
 * Searches for existing user in student roster
 * when creating a new user. Also loads the inital
 * create user box.
 */


$('#cr_user').click(function(){
  $.ajax({
    url: 'ajax/php/create_user.php',
    success: function(data) {
      $('#contents').html(data);
    }
  });
});

$('#save').click(function(){
  var formData = {
    fname: $('#fname').val(),
    lname: $('#lname').val(),
    cardnum: $('#cardnum').val(),
    pin: $('#pin').val(),
    type: $('#type').val(),
    points: $('#points').val()
  };

  $.ajax({
    url: 'ajax/php/create_user.php',
    type: 'POST',
    data: formData,
    success: function(data) {
      $('#contents').html(data);
    }
  });
});