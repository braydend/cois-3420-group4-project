// Movie id to be deleted.
var mov_id;

// Dialog box.
var dialogConfirm = $("#dialog-confirm").dialog({
  autoOpen: false,
  resizable: false,
  height: "auto",
  width: 400,
  modal: true,
  buttons: {
    'Delete': function() {
      $.ajax({
        url: "deletevid.php",
        data: { movieid: mov_id },
        async: false
      });
      location.reload();
    },
    Cancel: function() {
      $(this).dialog("close");
    }
  }
});

// Display details window.
var dialogDetails = $("<div></div>")
  .html('<iframe style="border: 0px; " src="displaydetails.php" width="100%" height="100%"></iframe>')
  .dialog({
     autoOpen: false,
     modal: true,
     height: 625,
     width: 500,
   });
