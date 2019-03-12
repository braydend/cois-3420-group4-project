<?PHP
    $title = "Movie Database";
    include('header.php');
    // For testing the menu functionality
    $_SESSION['userid'] = true;
?>
    <div class="container">
        <h1>Movies</h1>
        <div class="movie-grid">
            <div class="movie">
                <div class="movie-img">
                    <img src="images/dummy_movie.jpg" alt="Movie Image" />
                </div>
                <div class="movie-btns">
                    <a href="#"><i class="fas fa-pencil-alt"></i></a>
                    <a href="#"><i class="fas fa-trash-alt"></i></a>
                    <a href="#"><i class="fas fa-info-circle"></i></a>
                </div>
            </div>

            <div class="movie">
                <div class="movie-img">
                    <img src="images/dummy_movie.jpg" alt="Movie Image" />
                </div>
                <div class="movie-btns">
                    <a href="#"><i class="fas fa-pencil-alt"></i></a>
                    <a href="#"><i class="fas fa-trash-alt"></i></a>
                    <a href="#"><i class="fas fa-info-circle"></i></a>
                </div>
            </div>

            <div class="movie">
                <div class="movie-img">
                    <img src="images/dummy_movie.jpg" alt="Movie Image" />
                </div>
                <div class="movie-btns">
                    <a href="#"><i class="fas fa-pencil-alt"></i></a>
                    <a href="#"><i class="fas fa-trash-alt"></i></a>
                    <a href="#"><i class="fas fa-info-circle"></i></a>
                </div>
            </div>

            <div class="movie">
                <div class="movie-img">
                    <img src="images/dummy_movie.jpg" alt="Movie Image" />
                </div>
                <div class="movie-btns">
                    <a href="#"><i class="fas fa-pencil-alt"></i></a>
                    <a href="#"><i class="fas fa-trash-alt"></i></a>
                    <a href="#"><i class="fas fa-info-circle"></i></a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>