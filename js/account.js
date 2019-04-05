$(document).ready(function() {
    $('#submit').on('click', function(event){
        let name = $("#name");
        let email = $("#email");
        let emailRegex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if(name.val() == ""){
            $("#nameError").html("Name cannot be blank");
            event.preventDefault();
        }else{
            $("#nameError").html("");
        }
        if(!emailRegex.test(email.val())){
            $("#emailError").html("invalid email!");
            event.preventDefault();
        }else{
            $("#emailError").html("");
        }
    });
});