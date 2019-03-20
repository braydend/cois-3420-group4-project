<?php
	// still needs the password verify thing (my db doesn't have encrypted passwords)

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
		// queries database for stuff
		$name = $_POST['username'];
		$query = "select * from user_accounts where username = ? Limit 1";
		$stmt = $pdo->prepare($query);
		$stmt->execute([$_POST['username']]);
		$result = $stmt->fetchAll();
		$user_id = $result[0]['user_id'];

		// no user with given username exists
		if(empty($result))
		{
			$_SESSION['attempts']--;
			echo "username doesn't exist";
		}
		// username exists but password is incorrect
		else if ($result[0]['password'] != $_POST['password'])
		{
			$_SESSION['attempts']--;
			echo "invalid password, you have {$_SESSION['attempts']} attempts left";
		}
		
		// Username exists and password matches username
		else
		{
			echo "welcome back {$name}";
			// sets cookie which doesn't do anything
			if($_POST["remember"]=='1' || $_POST["remember"]=='true')
            {
				$hour = time() + 3600 * 24 * 30;
				setcookie('username', $login, $hour);
				setcookie('password', $password, $hour);
             }
			
			$_SESSION['userid'] = $user_id;
			header("location: ./search.php");
		}
	}
	// locks form from loading if too many attempts made
	if ($_SESSION['attempts'] <= 0)
	{
		echo " too many attempts were made, please wait a moment before trying again";
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