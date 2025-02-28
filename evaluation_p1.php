<?php
    include('db.php');
    session_start();

    if(!isset($_SESSION["user"])){
        echo "<script>alert('You must be logged in to view this page!'); window.location.href='index.php';</script>";
        exit();
    }
    
    

?>


<!DOCTYPE html>
<head>
    <title></title>
</head>
<html>



</html>