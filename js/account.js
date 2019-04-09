$(document).ready(function() {
    // Setup password
    $('#password').strength();


    // Form validation on submit
    $('#submit').on('click', function(event){
        let password = $('.strength_meter').children('div');
        let name = $("#name");
        let email = $("#email");
        let emailRegex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        // Name cannot be blank
        if(name.val() == ""){
            $("#nameError").html("Name cannot be blank");
            event.preventDefault();
        }else{
            $("#nameError").html("");
        }
        // Check if email is valid
        if(!emailRegex.test(email.val())){
            $("#emailError").html("invalid email!");
            event.preventDefault();
        }else{
            $("#emailError").html("");
        }
        // Password cannot be weak
        $('#passwordError').html('');
        if(password.hasClass('weak') || password.hasClass('veryweak')){
            $('#passwordError').html('Your email must be stronger!');
            event.preventDefault();
        }
    });

    // Username validation on lost focus
    $('#username').on('focusout', function(){
        let username = $('#username').val();
        // send ajax to see if username is taken
        $.get("ajax/usernameExists?username=" + username, function (data) {
            if(data == "1"){
                $("#usernameError").html("Username already in use");
            }else{
                $("#usernameError").empty();
            }
        });
    });
});