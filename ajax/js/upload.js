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
    xhrFields: {
      onprogress: function(e) {
        if (e.lengthComputable) {
          $('#p_bar').attr('style', 'width:0;height:2px;');

          var percent = (e.loaded / e.total) * 100;
          $('#p_bar').attr('style', 'width:'+percent+'%');
        }
        else {
          $('#p_bar').attr('style', 'width:0;height:2px;');
          $('#p_bar').attr('style', 'width:100%');
        }
      }
    },
    success: function(data) {
      $('#contents').html(data);
      $('#p_bar').attr('style', 'width:0;height:0;');
    }
  });
});