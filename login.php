<?php

	$title = "Log in";

	include('includes/library.php');
  include('header.php');

  // Variable for number of allowed login attempts.
	$numAttemptsAllowed = 5;

  // lockout flag variable.
	$lockout = false;

	// Flag variables for validation errors.
	$usernameValid = true;
	$passwordValid = true;

	// Get db connection
	$pdo = dbconnect();

	// Variable will only be unset on first load.
	if(!isset($_SESSION['attemptsRemaining'])) {

		// Flag for first load.
		$_SESSION['firstLoad'] = true;

		// Init attempts remaining.
		$_SESSION['attemptsRemaining'] = $numAttemptsAllowed;

	}


  // --- username field is set.
	if (isset($_POST['username'])) {

		// Get user from table based on their username (which is unique).
		$name = $_POST['username'];
		$query = "select * from user_accounts where username = ? Limit 1";
		$stmt = $pdo->prepare($query);
		$stmt->execute([$_POST['username']]);
		$result = $stmt->fetchAll();

	}


  // --- Do not do any validation or otherwise affect any variables on first load.
	if ($_SESSION['firstLoad']) {
		$_SESSION['firstLoad'] = false;
	}


	// --- No user with given username exists in table or no username given.
	else if ( !isset($_POST['username']) || empty($result) ) {

		$_SESSION['attemptsRemaining']--;						// Decrement login attempts.
		if ($_SESSION['attemptsRemaining'] <= 0) {  // Set to lockout if too many attempts.
			$lockout = true;
		}
		$usernameValid = false;											// Flag username as invalid.
	}


	// --- username exists in table but password given by user is incorrect or no password given.
	else if ( !isset($_POST['password']) || !password_verify($_POST['password'], $result[0]['password']) ) {

		$_SESSION['attemptsRemaining']--;						// Decrement login attemts.
		if ($_SESSION['attemptsRemaining'] <= 0) {	// Set to lockout if too many attempts.
			$lockout = true;
		}
		$passwordValid = false;											// Flag password as invalid.
	}


	// --- username was given and exists and password was given and matches username in the table.
	else {

		// Sets cookies when remember box is checked on login.
		if( isset($_POST["remember"]) ) {

			setcookie('username', $_POST['username']);
			setcookie('password', $_POST['password']);

		}

		// Unset session variables attemptsRemaining and firstLoad on successful login.
		unset($_SESSION['attemptsRemaining']);
		unset($_SESSION['firstLoad']);

    // Set the userid to session variable and redirect to index. (login user.)
		$_SESSION['userid'] = $result[0]['user_id'];
		header("location: ./index.php");
		die();
	}


	// When lockout flag is set.
	if ($lockout) {

		// Prompt the user that they are locked out (only thing on page).
		echo "<p>Too many login attempts. Please wait a moment before trying again.</p>";

    //////////////////////////// [ Temp. Put in some kind of timer later. ] ///////////////////////////////////
		unset($_SESSION['firstLoad']);/////////////////////////////////////////////////////////////////////////////
		unset($_SESSION['attemptsRemaining']); ////////////////////////////////////////////////////////////////////
		///////////////////////////////////////////////////////////////////////////////////////////////////////////

    // Prevent the rest of the page from loading.
		exit();
	}

?>

<!DOCTYPE HTML>
<html lang="en">
<head>
    <title>Login</title>
    <link rel="stylesheet" href="css/basestyle.css" />
</head>
<body>
<div class="container">
    <h1>Log In:</h1>
    <form method="post" action="#">
        <div class="form-element">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" <?php if ( isset($_COOKIE['username']) ) { echo "value=" . $_COOKIE['username']; } ?> />

						<!-- Inline php for error validation message -->
						<?php if (!$usernameValid) {
							echo "<span class='error'>username doesn't exist</span>";
						} ?>

        </div>
        <div class="form-element">
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" <?php if ( isset($_COOKIE['password']) ) { echo "value=" . $_COOKIE['password']; } ?> />

						<!-- Inline php for error validation message -->
						<?php if (!$passwordValid) {
							echo "<span class='error'>invalid password</span>";
						} ?>

        </div>
        <div id="remember-forgot">
            <div class="login-remember">
                <label for="remember">Remember Me</label>
                <input type="checkbox" name="remember" id="remember" />
            </div>
            <div class="login-forgot">
                <a href="#">Forgot Password?</a>
            </div>
        </div>
        <div class="form-buttons">
            <input type="submit" value="Login!" />
            <input type="reset" />
        </div>
    </form>
</div>

<!-- Print out number of login attempts remaining (if there are any) if not the first attempt. -->
<?php if ( $_SESSION['attemptsRemaining'] < $numAttemptsAllowed && $_SESSION['attemptsRemaining'] > 0 ) {
  echo "<span>You have {$_SESSION['attemptsRemaining']} login attempts remaining.</span>";
} ?>

</body>
</html>
