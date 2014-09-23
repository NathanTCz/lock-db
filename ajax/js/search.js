/*
Main AJAX engine for loading roster.
This script works in conjunction with ajax/php/search.php
*/

$("#name_box").keyup(function(){
  var q = $('#name_box').val();

  $.ajax({
    url: 'ajax/php/search.php?q='+q,
    success: function(data) {
      $('#contents').html(data);
    }
  });
});