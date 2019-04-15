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

<div id="dialog-confirm">
  <p>Are you sure you want to delete this video?</p>
</div>

<script type="text/javascript">

  // Movie id to be deleted.
  var mov_id;

  // Dialog box.
  var dialog = $("#dialog-confirm").dialog({
    autoOpen: false,
    resizable: false,
    height: "auto",
    width: 400,
    modal: true,
    buttons: {
      'Delete': function() {
        $.ajax({
          url: "deletevid.php",
          data: { movieid: mov_id },
          async: false
        });
        location.reload();
      },
      Cancel: function() {
        $(this).dialog("close");
      }
    }
  });

</script>

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
                        echo("<a href='" . $movie['movie_id'] . "/displaydetails.php'><i class='fas fa-info-circle'></i></a>");
                    echo("</div>");
                echo("</div>");
            }

            foreach($movies as $movie){
                displayMovie($movie);
            }
        ?>

        <script type="text/javascript">

        // Delete button handler.
        $(".fa-trash-alt").click(function(){

          // Set the movie id.
          mov_id = this.getAttribute('id');

          // Open dialog box.
          dialog.dialog("open");

        });
        </script>
    </div>
</div>
</body>
</html>
