<?php
    include('includes/library.php');

    //start session
    session_start();
    //get user id if logged in, else redirect to login page
    if(!isset($_SESSION['userid'])){
        header('location: login.php');
    }else{
        $userid = $_SESSION['userid'];
    }

    //get movie id from $_GET
    if(isset($_GET['movieid'])){
        //delete movie from db
        $movieid = $_GET['movieid'];
        $pdo = & dbconnect();
        $query = "DELETE FROM movies WHERE id = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute(array($movieid));
    }

    //redirect to index.php
    header('location: index.php');
?>