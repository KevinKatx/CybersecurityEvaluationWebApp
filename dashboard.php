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
        <link rel="stylesheet" href="dashboardstyle.css">
    </head>

    <body>
        <div class="evalContainer">
            <div class="evalConText">
                <h1>CyberSecurity Evaluation</h1>
                <p>Welcome, you will now undergo a CyberSecurity Evaluation, make sure you have thoroughly prepared for the coming evaluation goodluck and may fortune favor you.</p>
            </div>
            <div class="evalBTN" id = "evalBTNStart">Start Evaluation</div>
        </div>
    </body>
    <script>
        evalBTN = document.getElementById("evalBTNStart")
        evalBTN.addEventListener("click", function(){
            window.location.href = "evaluation_p1.php"
        })
    </script>



</html>