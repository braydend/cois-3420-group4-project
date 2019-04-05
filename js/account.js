$(document).ready(function() {
    $('#submit').on('click', function(event){
        let name = $("#name");
        if(name.val() == ""){
            $("#nameError").html("Name cannot be blank");
            event.preventDefault();
        }
    });
});