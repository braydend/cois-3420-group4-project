<?PHP
    $title = "Movie Database";
    include('header.php');
    // For testing the menu functionality
    // $_SESSION['userid'] = true;

    // --- User is not logged in on page load. Send user to the login page.
    if ( !isset($_SESSION['userid']) ) {

      // Redirect to login.
      header("location:login.php");
      exit();

    }

    // For accessing DB
    include('includes/library.php');
    $pdo = & dbconnect();
    $stmt = $pdo->prepare("SELECT * FROM movies WHERE user_id = ?");
    $stmt->execute([$_SESSION['userid']]);
    $movies = $stmt->fetchAll();
?>

<!-- Delete vid confirmation modal -->
<div id="dialog-confirm">
  <p>Are you sure you want to delete this video?</p>
</div>

<!-- Display-Details window/modal -->
<div></div>

<!-- include script to create modals -->
<script type="text/javascript" src="js/indexModals.js"></script>

<div class="container">
    <h1>Movies</h1>
    <div class="movie-grid">
        <?PHP
            function displayMovie($movie){
                echo("<div class='movie'>");
                    echo("<div class='movie-img'>");
                        echo("<img src='images/" . $movie['movie_id'] . "' alt='" . $movie['title'] . " image' />");
                    echo("</div>");
                    echo("<div class='movie-btns'>");
                        echo("<a href='" . $movie['movie_id'] . "/editvid.php'><i class='fas fa-pencil-alt'></i></a>");
                        echo("<button class='fabutton fas fa-trash-alt' id='{$movie['movie_id']}'></button>");
                        echo("<button class='fabutton fas fa-info-circle' id='{$movie['movie_id']}'></button>");
                    echo("</div>");
                echo("</div>");
            }

            foreach($movies as $movie){
                displayMovie($movie);
            }
        ?>

        <!-- include handlers for modals -->
        <script type="text/javascript" src="js/indexHandlers.js"></script>

    </div>

    <form action="addvid.php">
      <input type="submit" value="Add Video" />
    </form>

</div>
</body>
</html>
