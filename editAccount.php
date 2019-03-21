<?php

	$title = "Account Details";

	include('includes/library.php');
  include('header.php');

	// Flag variables.
	$boxesChecked = true;
	$validUsername = true;
	$usernameFree = true;
	$validPassword = true;
	$validName = true;
	$passwordMatchesConfirm = true;
	$validEmail = true;
	$emailFree = true;

	// Get db connection.
	$pdo = dbconnect();


	// --- User is not logged in on page load. Send user to the login page.
	if ( !isset($_SESSION['userid']) ) {

    // Redirect to login.
		header("location:login.php");
		exit();

	}

	// --- If past this point user is logged in and has userid in session variable.

  // No checkboxes selected on submit.
	if( !isset($_POST['check']) && isset( $_POST['submit']) ) {

		// Set flag to tell the user to check atleast one box to modify the account.
		$boxesChecked = false;

	}

  // Atleast one checkbox was selected on submit.
  else if ( isset( $_POST['submit']) ) ){

		// checks each of the checkboxes on the main form and runs the queries if they are checked.
		foreach($_POST['check'] as $check) {

      // Validation is identical to add-account.php
			switch($check) {

				case 'username':

					if ()

					//$sql = "UPDATE user_accounts SET username = ? WHERE user_id = ?";
					//$pdo->prepare($sql)->execute([$_POST['username'], $_SESSION['userid']]);

					echo "You checked username!";

					break;

				case 'name':

					//$sql = "UPDATE user_accounts SET name = ? WHERE user_id = ?";
					//$pdo->prepare($sql)->execute([$_POST['name'], $_SESSION['userid']]);

					echo "You checked name!";

					break;

				case 'email':

					//$sql = "UPDATE user_accounts SET email = ? WHERE user_id = ?";
					//$pdo->prepare($sql)->execute([$_POST['email'], $_SESSION['userid']]);

					echo "You checked email!";

					break;

				case 'password':

					// Validate Password
					// Inspired by: https://stackoverflow.com/questions/22544250/php-password-validation
					if (strlen($_POST["password"]) < '8') {
						$validPassword = false;
						$passErr = "Your Password Must Contain At Least 8 Characters";
					}
					elseif( !preg_match("#[0-9]+#", $_POST["password"]) ) {
						$validPassword = false;
						$passErr = "Your Password Must Contain At Least 1 Number";
					}
					elseif( !preg_match("#[A-Z]+#", $_POST["password"]) ) {
						$validPassword = false;
						$passErr = "Your Password Must Contain At Least 1 Capital Letter";
					}
					elseif( !preg_match("#[a-z]+#", $_POST["password"]) ) {
						$validPassword = false;
						$passErr = "Your Password Must Contain At Least 1 Lowercase Letter";
					}

					// Validate Password Confirm (equals password)
					if ( !( $_POST['password'] === $_POST['password_confirm'] ) ) {
						$passwordMatchesConfirm = false;
					}

					break;

			}

			// header('location:index.php'); // This was after each query.
		}
	}

?>

<!DOCTYPE HTML>
<html lang="en">
<head>
    <title>Create an Account</title>
    <link rel="stylesheet" href="css/basestyle.css" />
</head>
<body>
    <div class="container">
        <h1>Modify an account:</h1>
				<h3>Check the boxes for the fields you wish to update</h3>
        <form method='post' class='container' name ='details'>
            <div class="form-element">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" />
				<input type="checkbox" name="check[]" value='username' />
            </div>
			<!-- four mana seven seven -->
            <div class="form-element">
                <label for="name">Name:</label>
                <input type="text" name="name" id="name" />
								<input type="checkbox" name="check[]" value='name'/>
           </div>
            <div class="form-element">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" />
								<input type="checkbox" name="check[]" value='email'/>
           </div>
            <div class="form-element">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" />
								<input type="checkbox" name="check[]" value='password'/>
           </div>
            <div class="form-element">
                <label for="password_confirm">Confirm Password:</label>
                <input type="password" name="password_confirm" id="password_confirm" />
            </div>

			<div class="form-buttons">
                <input type="submit" value="Update Account!" />
                <input type="reset" />
            </div>
        </form>
    </div>
</body>
</html>
