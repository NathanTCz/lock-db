/* Upload File Button */
$(document).on('click', '#check_all', function(){
  $('input.checks').prop('checked', this.checked);
});

/* Create lock files */
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