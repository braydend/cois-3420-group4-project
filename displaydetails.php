<?php
	
	$title = "~~~~~";
	include('header.php');
	include('includes/library.php');
	$pdo = & dbconnect();


//if
	//$stmt = $pdo->prepare('SELECT * FROM movies WHERE title = ?');
	//$stmt->execute([$movie_title]);
	//$data = $stmt->fetch(); 

	$query = "SELECT * FROM movies";
    $data = $pdo->query($query);

?>

<body>
	<div class="container">
		<div class="detailgeneral">
			<h1>
			<?php foreach ($data as $row): ?>
                   <?php echo $row['title']?>
          	</h1>
          	<p id="year"><?php echo $row['year']?></p>
			<p id="rating"><?php echo $row['stars'] ?> <img src="images/star.png" alt="stars"></p>
		</div>
		
		<div class="detaildata">
			<p><?php echo $row['run_time'] ?></p>
			<p>&#x7c;</p>
			<p><?php echo $row['genre'] ?></p>
			<p>&#x7c;</p>
			<p><?php echo $row['theatre_release'] ?></p>
			<p>&#x7c;</p>
			<p><?php echo $row['m_rating'] ?></p>
		</div>

		<hr/>

		<div id="summary">
			<img src='images/<?php echo $row['image']?>'>
			<p><?php echo $row ['summary'] ?></p>
		</div>

		<div class="detailother">
			<ul>
				<li>Cast: <?php echo $row['actors'] ?></li>
				<li>Studio: <?php echo $row ['studio'] ?></li>
				<li>Video type: <?php echo $row ['format'] ?></li>
				<?php endforeach ?>
			</ul>
		</div>
	</div>
</body>
</html>