/*
 * Searches for existing user in student roster
 * when creating a new user. Also loads the inital
 * create user box.
 */


$(document).on('click', '#cr_user', function(){
  var sendData = {
    action: 'c'
  }

  $.ajax({
    url: 'ajax/php/create_user.php',
    data: sendData,
    success: function(data) {
      $('#contents').html(data);
    }
  });
});

$(document).on('click', '#save', function(){
  var formData = {
    fname: $('#fname').val(),
    lname: $('#lname').val(),
    cardnum: $('#cardnum').val(),
    pin: $('#pin').val(),
    type: $('#type').val(),
    points: $('#points').val(),
    action: $('#action').val(),
    index: $('#index').val()
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

$(document).on('click', '#ed_user', function(){
  var sendData = {
    i: $(this).attr('data-key'),
    type: 'u',
    action: 'u'
  }

  $.ajax({
    url: 'ajax/php/create_user.php',
    data: sendData,
    success: function(data) {
      $('#contents').html(data);
    }
  });
});

$(document).on('keyup', '#lname', function(){
  var q = $(this).val();

  $.ajax({
    url: 'ajax/php/cross_ref.php?q='+q,
    success: function(data) {
      $('#search_list').html(data);
    }
  });
});

$(document).on('click', 'div.line_item2', function(){
  var sendData = {
    i: $(this).attr('data-key'),
    type: 's',
    action: 'c'
  }

  $.ajax({
    url: 'ajax/php/create_user.php',
    data: sendData,
    success: function(data) {
      $('#contents').html(data);
    }
  });
});