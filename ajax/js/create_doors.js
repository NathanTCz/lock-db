/* Create lock files

 * This button is deprecate as of v1.1.3
 * see comments in ajax/php/create_doors.php
 * This function has been moved to ajax/js/general.js

$(document).on('click', '#sync', function(){
  var formData = new FormData( $('#pin_files_form')[0] );

  $.ajax({
    url: 'ajax/php/create_doors.php',
    type: 'POST',
    data: formData,
    cache: false,
    processData: false,
    contentType: false,
    success: function(data) {
      $('#contents').html(data);
    }
  });
});
*/

/* Check all
$(document).on('click', '#check_all', function(){
  $('input.checks').prop('checked', this.checked);
});
*/