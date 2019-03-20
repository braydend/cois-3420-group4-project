<?php

	// Still needs the password verify thing (my db doesn't have encrypted passwords)
	$title = "Log in";
	include('includes/library.php');
    include('header.php');
	$pdo = dbconnect();

	// stops loading page if too many attempts made
	if(!isset($_SESSION['attempts']))
	{
		$_SESSION['username'] = null;
		$_SESSION['attempts'] = 5;
	}

	if(isset($_POST['username']))
	{

		// Get user from table based on their username.
		$name = $_POST['username'];
		$query = "select * from user_accounts where username = ? Limit 1";
		$stmt = $pdo->prepare($query);
		$stmt->execute([$_POST['username']]);
		$result = $stmt->fetchAll();



		// ---No user with given username exists in table.
		if(empty($result)) {

			$_SESSION['attempts']--;								// Decrement login attempts.
			echo "<p>username doesn't exist</p>";   // State validation error.
		}



		// ---username exists in table but password given by user is incorrect.
		// Verify password hash.
		else if ( !password_verify($_POST['password'], $result[0]['password']) ) {

			$_SESSION['attempts']--;								// Decrement login attemts.
			echo "<p>invalid password, you have {$_SESSION['attempts']} attempts left.</p>"; // State validation error.
		}



		// ---username exists and password matches username.
		else
		{
			// Welcome back message.
			echo "<P>Welcome back, {$name}</p>";

			// sets cookie which doesn't do anything
			if($_POST["remember"]=='1' || $_POST["remember"]=='true') {

				$hour = time() + 3600 * 24 * 30;
				setcookie('username', $login, $hour);
				setcookie('password', $password, $hour);

			}

      // Set the userid to session variable and redirect to index. (login user.)
			$_SESSION['userid'] = $result[0]['user_id'];
			header("location: ./search.php");

		}

	}

	// Locks form from loading if too many attempts made.
	if ($_SESSION['attempts'] <= 0)
	{
		echo "<p>Too many login attempts. Please wait a moment before trying again.</p>";
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
            <input type="text" name="username" id="username" />
        </div>
        <div class="form-element">
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" />
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
</body>
</html>
