<?php

  // If already logged in, redirect immediately back to index.
  if ( isset( $_SESSION['userid']) && !empty($_SESSION['userid'])) {
    header("location: editAccount.php");
    die();
  }

  // --- Database Object ---
  require_once("includes/library.php"); // Include library file
  $pdo = & dbconnect();                 // Construct database object


  // --- Create user_accounts table if it does not already exist (if first account on site)

  $pdo -> query("CREATE TABLE IF NOT EXISTS `user_accounts` (
      `user_id` int NOT NULL AUTO_INCREMENT,
      `username` varchar(255) NOT NULL,
      `name` varchar(255) NOT NULL,
      `email` varchar(255) NOT NULL,
      `password` varchar(255) NOT NULL,
      PRIMARY KEY(`user_id`)
  )");


  // --- Create movies table if it does not already exist. (if first account on site)

  $pdo -> query("CREATE TABLE IF NOT EXISTS `movies` (
 `id` int(5) NOT NULL AUTO_INCREMENT,
 `title` varchar(20) DEFAULT NULL,
 `stars` int(11) DEFAULT NULL,
 `genre` varchar(40) DEFAULT NULL,
 `m_rating` varchar(5) DEFAULT NULL,
 `year` varchar(4) DEFAULT NULL,
 `runtime` varchar(40) DEFAULT NULL,
 `theatre_release` varchar(10) DEFAULT NULL,
 `dvd_release` varchar(10) DEFAULT NULL,
 `actors` varchar(20) DEFAULT NULL,
 `studio` varchar(10) DEFAULT NULL,
 `summary` varchar(20) DEFAULT NULL,
 `format` varchar(10) DEFAULT NULL,
 `bluray` char(2) DEFAULT NULL,
 `4kdisk` char(2) DEFAULT NULL,
 `sd` char(2) DEFAULT NULL,
 `hd` char(2) DEFAULT NULL,
 `4kdig` char(2) DEFAULT NULL,
 `userid` int(11) NOT NULL,
 PRIMARY KEY (`id`),
 KEY `userid` (`userid`) USING BTREE,
 CONSTRAINT `userid_constraint` FOREIGN KEY (`userid`) REFERENCES `user_accounts` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
)");


  // --- PHP Validation ---

  // Validate on submit.
  if (isset($_POST['submit'])) {

    // Init validation boolean flags.
    $validUsername = true;
    $usernameFree = true;
    $validPassword = true;
    $validName = true;
    $passwordMatchesConfirm = true;
    $validEmail = true;
    $emailFree = true;

    // Enusre that username given does not already exist in the table ...
    $query = "SELECT 1 username FROM user_accounts WHERE username = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$_POST['username']]);
    $result = $stmt->fetchAll();

    // There already exists an account with given username.
    if (!empty($result)) {
      // Flag as invalid.
      $usernameFree = false;

    }

    // Ensure that email given does not already exist in the table ...
    $query = "SELECT 1 email FROM user_accounts WHERE email = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$_POST['email']]);
    $result = $stmt->fetchAll();

    // There already exists an account with given username.
    if (!empty($result)) {
      // Flag as invalid.
      $emailFree = false;

    }

    // Validate Username (between 3 and 20 characters inclusive) (only regular chars and numbers allowed)
    if (!( strlen($_POST['username']) >= 3 && strlen($_POST['username']) <= 25 && preg_match("/^[a-zA-Z0-9]*$/", $_POST['username']) )) {
      $validUsername = false;
    }

    // Validate Name (between 3 and 40 characters inclusive) (only chars and white space allowed)
    if (!( strlen($_POST['name']) >= 2 && strlen($_POST['name']) <= 40 && preg_match("/^[a-zA-Z ]*$/", $_POST['name']) )) {
      $validName = false;
    }

    // Validate Email
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
      $validEmail = false;
    }

    // Validate Password
    // Inspired by: https://stackoverflow.com/questions/22544250/php-password-validation
    if (strlen($_POST["password"]) < '8') {
      $validPassword = false;
      $passErr = "Your Password Must Contain At Least 8 Characters";
    }
    elseif(!preg_match("#[0-9]+#", $_POST["password"])) {
      $validPassword = false;
      $passErr = "Your Password Must Contain At Least 1 Number";
    }
    elseif(!preg_match("#[A-Z]+#", $_POST["password"])) {
      $validPassword = false;
      $passErr = "Your Password Must Contain At Least 1 Capital Letter";
    }
    elseif(!preg_match("#[a-z]+#", $_POST["password"])) {
      $validPassword = false;
      $passErr = "Your Password Must Contain At Least 1 Lowercase Letter";
    }

    // Validate Password Confirm (equals password)
    if (!( $_POST['password'] === $_POST['password_confirm'] )) {
      $passwordMatchesConfirm = false;
    }

    // All input is valid.
    if ($validUsername && $validPassword && $validName && $validEmail && $passwordMatchesConfirm && $emailFree && $usernameFree) {

      // Hash Password
      $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);

      // --- Create Account ---
      $query = "INSERT INTO user_accounts (username, name, email, password) VALUES (?,?,?,?)";
      $pdo->prepare($query)->execute([$_POST['username'], $_POST['name'], $_POST['email'], $hash]);

      // get the user_id (primary key) from the table for the new account and set it to the session ...
      $query = "SELECT user_id FROM user_accounts WHERE username = ? LIMIT 1";
      $stmt = $pdo->prepare($query);
      $stmt->execute([$_POST['username']]);
      $result = $stmt->fetchAll();

      // Get user_id value returned from table by query.
      $user_id = $result[0]['user_id'];

      // Set session variable to user's user_id
      $_SESSION['userid'] = $user_id;


      // Redirect to index.
      header("Location: ./index.php");
      die();

    }
  }
?>
