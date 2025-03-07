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
    <div style="display: flex; flex-direction: column;">
        <div class="container">
            <div class="content">
                <h1>CyberSecurity Evaluation</h1>
                <p>Welcome! You are about to undergo a CyberSecurity Evaluation. Ensure you are well-prepared. Good luck, and may fortune favor you.</p>
                <button id="eval1BTNStart">Start Evaluation Part 1</button>
            </div>
        </div>

        <div class="container2">
            <div class="content">
                <p>Undergo Testing in a Simulative Environment to test your Cybersecurity Skills</p>
                <button id="eval2BTNStart">Start Evaluation Part 2</button>
            </div>
        </div>
    </div>
    
    
    <script>
        document.getElementById("eval1BTNStart").addEventListener("click", function(){
            window.location.href = "evaluation_p1.php";
        });

        document.getElementById("eval2BTNStart").addEventListener("click", function(){
            window.location.href = "evaluation_p2.php";
        });
    </script>
</body>
</html>
