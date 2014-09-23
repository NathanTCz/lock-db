/*
Used to load individual user data
*/


$('div.line_item').click(function(){
  var i = $(this).attr('data-key');

  $.ajax({
    url: 'ajax/php/loaddata.php?i='+i,
    success: function(data) {
      $('#contents').html(data);
    }
  });
});