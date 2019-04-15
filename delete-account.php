<?php

  if (isset($_POST['delete'])) {
    // Delete user from users table based on their current session variable.
    $query = "DELETE FROM user_accounts WHERE user_id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$_SESSION['userid']]);

    // Destroy session.
    session_unset();
    session_destroy();

    // http_redirect
    header("Location: ./index.php");
    die();
  }

?>
