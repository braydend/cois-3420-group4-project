// Delete button handler.
$(".fa-trash-alt").click(function(){

  // Set the movie id.
  mov_id = this.getAttribute('id');

  // Open dialog box.
  dialogConfirm.dialog("open");

});

// Display Details button handler.
$(".fa-info-circle").click(function(){

  // Set the movie id.
  mov_id = this.getAttribute('id');

  // Send display-details the movie id.
  $.ajax({
    url: "displaydetails.php",
    data: { movieid: mov_id },
    async: false
  });

  // Open dialog box.
  dialogDetails.dialog("open");

});
