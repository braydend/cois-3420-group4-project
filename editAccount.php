<?php
	$title = "Account Details";
	include('includes/library.php');
    include('header.php');
	$pdo = dbconnect();
	
	// sends back to home if not logged in, 
	if (isset($_SESSION['userid']))
	{
		echo "what would you like to update";
	}
	else
	{
		header("location:search.php");
		exit();
	}
	
	if(!empty($_POST['check']))
	{
		// checks each of the checkboxes on the main form and runs the queries if they are checked (0 validation done, stuff is super easy to break)
		foreach($_POST['check'] as $check)
		{
			if($check == 'username')
			{
				$sql = "update user_accounts set username = value '{$_POST['username']}' where user_id = '{$_SESSION['userid']}'";
				$pdo->query($sql);

				header('location:login.php');
			}	
			else if($check == 'name')
			{
				$sql = "update user_user_accounts set name = value '{$_POST['name']}' where user_id = '{$_SESSION['userid']}'";
				$pdo->query($sql);
				
				header('location:index.php');
			}
			else if($check == 'email')
			{
				$sql = "update user_accounts set email = '{$_POST['email']}' where user_id = '{$_SESSION['userid']}'";
				$pdo->query($sql);

				header('location:login.php');
			}
			else if($check =='password')
			{	
				
			}
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
                <input type="submit" value="Create Account!" />
                <input type="reset" />
            </div>
        </form>
    </div>
</body>
</html>