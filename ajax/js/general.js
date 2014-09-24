/*
 * This is the main engine for all static elements.
 * This is where all of the handlers are added to elements
 * that are not loaded dynamically with AJAX, but rather
 * always part of the page. eg. the search bar.
*/


/* Search Bar */
$(document).on('keyup', '#name_box', function(){
  var q = $(this).val();

  $.ajax({
    url: 'ajax/php/search.php?q='+q,
    success: function(data) {
      $('#contents').html(data);
    }
  });
});

/* Upload File Button */
$(document).on('click', '#up_csv', function(){
  $.ajax({
    url: 'ajax/php/upload.php',
    success: function(data) {
      $('#contents').html(data);
    }
  });
});