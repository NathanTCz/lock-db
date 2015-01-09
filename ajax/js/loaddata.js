/*
Used to load individual user data
*/


$(document).on('click', 'div.line_item1', function(){
  var i = $(this).attr('data-key');

  $.ajax({
    url: 'ajax/php/loaddata.php?i='+i,
    success: function(data) {
      $('#contents').html(data);
      ajax_callstack.push(this);
    }
  });
});