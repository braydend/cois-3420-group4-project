<?php

	$title = "Search for Movies";
	include('includes/library.php');
    include('header.php');

	// Queries db for things matching / containing a given search term.
	if(isset($_POST['search']) && !empty($_POST['search']))
	{

		$searchfor = $_POST['search'];

		// Connect to database.
		$pdo = dbconnect();

		// Query to search for any titles containing search term.
		$query = "SELECT title, year, actors FROM movies WHERE title LIKE ?";

		// Prepare search query.
		$stmt = $pdo->prepare($query);

		// Get Results with search term.
		$stmt->execute(["%" . $searchfor . "%"]);

		$results = $stmt->fetchAll();

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

				if(isset($results)) {

					echo "<h2>Your search results for " . $_POST['search'] . "</h2>";

					echo '<table>';																						// Table.
					foreach($results as $row) {

						echo '<tr>';																						// New Row.

						echo "<td> <img src='images/dummy_movie.jpg' /> </td>"; // Movie image.
						echo "<td> $row[title] </td>"; 													// Movie title.
						echo "<td> $row[year] </td>"; 													// Release year.
						echo "<td> $row[actors] </td>"; 												// Actors.

						echo '</tr>';																						// End Row.
					}

				echo '</table>';																						// End table.
			}
		?>
	</body>
</html>
