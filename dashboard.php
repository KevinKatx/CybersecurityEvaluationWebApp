<?php
    include('db.php');
    session_start();

    if(!isset($_SESSION["user"])){
        echo "<script>alert('You must be logged in to view this page!'); window.location.href='index.php';</script>";
        exit();
    }

?>  

<!DOCTYPE html>
<html>
    <head>
        <title>Hanuka's Resort CyberSecurity Evaluation</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="indexstyles.css">
    </head>



</html>