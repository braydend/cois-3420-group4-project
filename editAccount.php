<?php
	$title = "Account Details";
	include('includes/library.php');
    include('header.php');
	$pdo = dbconnect();
	
	// sends back to home if not logged in, 
	if (isset($_SESSION['userid']))
	{
		echo "<h3>Check the boxes for the fields you wish to update</h3>";
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
				$sql = "UPDATE user_accounts SET username = ? WHERE user_id = ?";
				$pdo->prepare($sql)->execute([$_POST['username'], $_SESSION['userid']]);

				header('location:index.php');
			}	
			else if($check == 'name')
			{
				$sql = "UPDATE user_accounts SET name = ? WHERE user_id = ?";
				$pdo->prepare($sql)->execute([$_POST['name'], $_SESSION['userid']]);
				
				header('location:index.php');
			}
			else if($check == 'email')
			{
				$sql = "UPDATE user_accounts SET email = ? WHERE user_id = ?";
                $pdo->prepare($sql)->execute([$_POST['email'], $_SESSION['userid']]);

                header('location:index.php');
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
                <input type="submit" value="Update Account!" />
                <input type="reset" />
            </div>
        </form>
    </div>
</body>
</html>