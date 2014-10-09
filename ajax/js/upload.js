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
    xhr: function()
    {
      var xhr = new window.XMLHttpRequest();
      //Upload progress
      xhr.upload.addEventListener("progress", function(e){
        if (e.lengthComputable) {
          var percent = (e.loaded / e.total) * 100;
          $('#p_bar').attr('style', 'width:'+percent+'%;visibility:visible;');
          console.log(percent);
        }
      }, false);
      return xhr;
    },
    success: function(data) {
      $('#contents').html(data);
      $('#p_bar').removeAttr('style');
    }
  });
});