<?PHP
    // Starts session
    session_start();
    // Unsets all the session variables
    session_unset();
    // Destroys session
    session_destroy();
    // Redirects user
    header('location: index.php');
?>