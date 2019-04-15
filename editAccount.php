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

  include 'delete-account.php';

	// --- User is not logged in on page load. Send user to the login page.
	if ( !isset($_SESSION['userid']) ) {

    // Redirect to login.
		header("location:login.php");
		exit();

	}



	// --- If past this point user is logged in and has userid in session variable.



	// Get the users data from the table for populating the text fields on page load.
	$query = "SELECT * FROM user_accounts WHERE user_id = ?";
	$stmt = $pdo->prepare($query);
	$stmt->execute([$_SESSION['userid']]);
	$userdata = $stmt->fetchAll();



  // --- No checkboxes selected on submit.
	if( !isset($_POST['check']) && isset($_POST['submit']) ) {

		// Set flag to tell the user to check atleast one box to modify the account.
		$boxesChecked = false;

	}



  // --- Atleast one checkbox was selected on submit.
  if( isset($_POST['check']) && isset($_POST['submit']) ) {


		// --- VALIDATE each selected field in the form.
		foreach( $_POST['check'] as $check ) {

      // Validation is identical to add-account.php
			switch( $check ) {

        // username validation.
				case 'username':

					// Enusre that username given does not already exist in the table ...
			    $query = "SELECT * FROM user_accounts WHERE username = ?";
			    $stmt = $pdo->prepare($query);
			    $stmt->execute([$_POST['username']]);
			    $result = $stmt->fetchAll();

			    // There already exists an account with given username (that is not the current user).
			    if ( !empty($result) && $result[0]['user_id'] !=  $_SESSION['userid'] ) {

			      // Flag as invalid.
			      $usernameFree = false;
			    }

					// Validate Username (between 3 and 20 characters inclusive) (only regular chars and numbers allowed)
					if (!( strlen($_POST['username']) >= 3 && strlen($_POST['username']) <= 25 && preg_match("/^[a-zA-Z0-9]*$/", $_POST['username']) )) {
						$validUsername = false;
					}

					break;

        // name validation.
				case 'name':

					// Validate Name (between 3 and 40 characters inclusive) (only chars and white space allowed)
			    if (!( strlen($_POST['name']) >= 2 && strlen($_POST['name']) <= 40 && preg_match("/^[a-zA-Z ]*$/", $_POST['name']) )) {
			      $validName = false;
			    }

					break;

        // email validation.
				case 'email':

					// Ensure that email given does not already exist in the table ...
			    $query = "SELECT * FROM user_accounts WHERE email = ?";
			    $stmt = $pdo->prepare($query);
			    $stmt->execute([$_POST['email']]);
			    $result = $stmt->fetchAll();

			    // There already exists an account with given email (that is not the current user).
			    if ( !empty($result) && $result[0]['user_id'] !=  $_SESSION['userid'] ) {

			      // Flag as invalid.
			      $emailFree = false;
			    }

					// Validate Email
					if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
						$validEmail = false;
					}

					break;

        // password validation.
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

					break; // End password validation.

			} // End switch for validation.

		} // End foreach



		// --- All input is valid. UPDATE all selected fields.
		if ($validUsername && $validPassword && $validName && $validEmail && $passwordMatchesConfirm && $emailFree && $usernameFree) {

			// --- UPDATE each selected field in the form.
			foreach( $_POST['check'] as $check ) {

				// Validation is identical to add-account.php
				switch( $check ) {

					// username UPDATE.
					case 'username':

						// UPDATE username in the users table.
						$sql = "UPDATE user_accounts SET username = ? WHERE user_id = ?";
						$pdo->prepare($sql)->execute([$_POST['username'], $_SESSION['userid']]);

						break;	// End UPDATE username query.

					// name UPDATE.
					case 'name':

						// UPDATE name in the users table.
						$sql = "UPDATE user_accounts SET name = ? WHERE user_id = ?";
						$pdo->prepare($sql)->execute([$_POST['name'], $_SESSION['userid']]);

						break;	// End UPDATE name query.

					// email UPDATE.
					case 'email':

						// UPDATE email in the users table.
						$sql = "UPDATE user_accounts SET email = ? WHERE user_id = ?";
						$pdo->prepare($sql)->execute([$_POST['email'], $_SESSION['userid']]);

						break;	// End UPDATE email query.

					// password UPDATE.
					case 'password':

						// Hash Password
						$hash = password_hash($_POST['password'], PASSWORD_DEFAULT);

						// UPDATE password in the users table.
						$sql = "UPDATE user_accounts SET password = ? WHERE user_id = ?";
						$pdo->prepare($sql)->execute([$hash, $_SESSION['userid']]);

						break;  // End UPDATE password query.

				} // End switch for slected checkbox to query.

			} // End foreach selected checkbox.



			// --- Redirect to index after updating account.
			header("location:index.php");
			exit();



		} // End if (all input is valid) (and atleast one checkbox was selected).

	} // End submit with atleast one checkbox checked.


  /*
	// debug watch variables
	echo "<p>isset(_POST['submit']): " . isset($_POST['submit']) . "</p>";
	echo "<p>isset(_POST['check']): " . isset($_POST['check']) . "</p>";
	echo "<p>boxesChecked: " . $boxesChecked . "</p>";
	echo "<p>validUsername: " . $validUsername . "</p>";
	echo "<p>usernameFree: " . $usernameFree . "</p>";
	echo "<p>validPassword: " . $validPassword . "</p>";
	echo "<p>validName: " . $validName . "</p>";
	echo "<p>passwordMatchesConfirm: " . $passwordMatchesConfirm . "</p>";
	echo "<p>validEmail: " . $validEmail . "</p>";
	echo "<p>emailFree: " . $emailFree . "</p>";
  */
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
  <title>Create an Account</title>
  <link rel="stylesheet" href="css/basestyle.css" />
</head>
<body>
  <div class="container">
    <h1>Edit your Account:</h1>
		<h3>Check the boxes for the fields you wish to update</h3>
		<?php if (isset($boxesChecked) && !$boxesChecked) {
			echo "<span class='error'>Must select a field below to modify account.</span>";
		} ?>
    <form method='post' class='container' name ='details'>
      <div class="form-element">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" value=<?php echo $userdata[0]['username']; ?> />
				<input type="checkbox" name="check[]" value='username' />
				<?php if (isset($validUsername) && !$validUsername) {
					echo "<span class='error'>username is not valid</span>";
				} elseif (isset($usernameFree) && !$usernameFree) {
					echo "<span class='error'>username already in use</span>";
				} ?>
      </div>
      <div class="form-element">
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" value=<?php echo "'" . $userdata[0]['name'] . "'"; ?> />
				<input type="checkbox" name="check[]" value='name'/>
				<?php if (isset($validName) && !$validName) {
					echo "<span class='error'>name is not valid</span>";
				} ?>
     	</div>
      <div class="form-element">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value=<?php echo $userdata[0]['email']; ?> />
				<input type="checkbox" name="check[]" value='email'/>
				<?php if (isset($validEmail) && !$validEmail) {
					echo "<span class='error'>email is not valid</span>";
				} elseif (isset($emailFree) && !$emailFree) {
					echo "<span class='error'>email already in use</span>";
				} ?>
     	</div>
      <div class="form-element">
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" />
				<input type="checkbox" name="check[]" value='password'/>
				<?php if (isset($validPassword) && !$validPassword) {
					echo "<span class='error'>" . $passErr . "</span>";
				} ?>
     	</div>
      <div class="form-element">
        <label for="password_confirm">Confirm Password:</label>
        <input type="password" name="password_confirm" id="password_confirm" />
				<?php if (isset($passwordMatchesConfirm) && !$passwordMatchesConfirm) {
					echo "<span class='error'>Could not confirm password</span>";
				} ?>
      </div>
			<div class="form-buttons">
        <input type="submit" value="Update Account!" name="submit"/>
        <input type="reset" />
				<input type="submit" name="delete" value="Delete Account" />
      </div>
    </form>
  </div>
</body>
</html>
