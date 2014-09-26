/*
 * Engine for the file upload page. Error checking
 * and AJAX file upload.
*/

/* Search Bar */
$(document).on('click', '#upload', function(){
  var formData = new FormData( $('#upload_form')[0] );
  formData.append('points', $('#points').val());

  $.ajax({
    url: 'ajax/php/upload.php',
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