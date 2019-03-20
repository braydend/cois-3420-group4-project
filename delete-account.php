<?php

  // Delete user from users table based on their current session variable.
  $query = "DELETE * FROM user_accounts WHERE user_id = ?";
  $pdo->prepare($query)->execute([$_SESSION['userid']]);

  // Destroy session.
  session_unset();
  session_destroy();

  // http_redirect
  header("Location: ./index.php");
  die();

?>
