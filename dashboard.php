<?php
    include('db.php');
    session_start();

    if(!isset($_SESSION["user"])){
        echo "<script>alert('You must be logged in to view this page!'); window.location.href='index.php';</script>";
        exit();
    }
?>  

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CyberSecurity Evaluation | Hanuka's Resort</title>
    <link rel="stylesheet" href="dashboardstyle.css">
</head>
<body>
    <!-- Back Button -->
    <a href="index.php" class="log-out">Logout</a>

    <div class="container">
        <div class="content">
            <h1>CyberSecurity Evaluation</h1>
            <p>Welcome! You are about to undergo a CyberSecurity Evaluation. Ensure you are well-prepared. Good luck, and may fortune favor you.</p>
            <button id="evalBTNStart">Start Evaluation</button>
        </div>
    </div>
    
    <script>
        document.getElementById("evalBTNStart").addEventListener("click", function(){
            window.location.href = "evaluation_p1.php";
        });
    </script>
</body>
</html>
