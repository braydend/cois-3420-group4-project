<?php
    include("../includes/library.php");
    $pdo = & dbconnect();
    // if username is empty, return 0 (false)
    if(!isset($_GET['username']) || empty($_GET['username'])){
        echo("0");
        die;
    }
    // username from GET
    $username = $_GET['username'];
    // Set up PDO statement
    $stmt = $pdo->prepare("SELECT * FROM user_accounts WHERE username = ?");
    $stmt->execute([$username]);
    $accounts = $stmt->fetchAll();
    // If any results exist return 0, else 1
    if(empty($accounts)){
        echo("0");
    }else{
        echo("1");
    }
?>