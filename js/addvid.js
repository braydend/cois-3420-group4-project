// Datepicker.
$( function() {
  $( ".datepicker" ).datepicker();
});

// Plot character counter.
$(document).ready(function(){
  var maxLength = 2500;
  var textlen;
  $('#summary').keyup( function(e) {
    textlen = maxLength - $(this).val().length;
    $('#rchars').text(textlen);
  });
});
