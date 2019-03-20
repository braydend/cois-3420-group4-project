<?php   
	$title = "Search for Movies";
	include('includes/library.php');
    include('header.php');

	// queries db for things matching a certain name 
	// ****** I can add more things to search by if we care to do that (not before check in)
	if(isset($_POST['search']))
	{
		$_SESSION['search'] = null;
		$_SESSION['search']	= $_POST['search'];
		
		$searchFor = $_SESSION['search'];
		$pdo = dbconnect();
		$sql = "select title, year, actors from movies where title = '$searchFor'";
		$results = $pdo->query($sql);
	
	}	
	
?>
<!DOCTYPE HTML>
<html lang='en'>
<head>
    <title>Search for Movies</title>
    <link rel="stylesheet" type='text/css' href="css/basestyle.css" />
</head>

<body>
	<div>
		<form method="post" class="container" name='search' >
			
			<h1>Movies</h1>
				<input type="text" name="search" id="search" placeholder="Search by Name" required />
				<input type='submit' value='Search' />
		</form >
				<?php
				// prints shit out in table
				if(isset($results))
				{
					echo "Your search results for " .$_SESSION['search'];
					echo '<table>';
					foreach($results as $row)
					{
						echo '<tr>';
						
						echo "<td> <img src='images/dummy_movie.jpg' /> </td>"; //movie image
						echo "<td> $row[title] </td>"; // name
						echo "<td> $row[year] </td>"; // release year
						echo "<td> $row[actors] </td>"; //starring
							
						echo '</tr>';
					}
				echo '</table>';		
			}	
		?>	
	</body>
</html>
