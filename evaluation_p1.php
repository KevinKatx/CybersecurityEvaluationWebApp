<?php
    include('db.php');
    session_start();

    if(!isset($_SESSION["user"])){
        echo "<script>alert('You must be logged in to view this page!'); window.location.href='index.php';</script>";
        exit();
    }
    
    if (!isset($_SESSION["user"])) {
        echo "<script>alert('You must be logged in to view this page!'); window.location.href='index.php';</script>";
        exit();
    }
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $correct_answers = [
            "q1" => "b",
            "q2" => "c",
            "q3" => "b",
            "q4" => "b",
            "q5" => "c",
            "q6" => "b",
            "q7" => "b",
            "q8" => "c",
            "q9" => "b",
            "q10" => "c"
        ];
    
        $score = 0;
    
        foreach ($correct_answers as $question => $answer) {
            if (isset($_POST[$question]) && $_POST[$question] == $answer) {
                $score++;
            }
        }
    
        $user_id = $_SESSION["user"]["id"]; // Assuming user id is stored in the session
    
        // Insert score into the evaluations table
        $stmt = $conn->prepare("INSERT INTO evaluation (employeeID, score) VALUES (?, ?)");
        $stmt->bind_param("ii", $user_id, $score);
    
        if ($stmt->execute()) {
            echo "<script>alert('Evaluation submitted successfully! Your score: $score'); window.location.href='dashboard.php';</script>";
        } else {
            echo "<script>alert('Failed to submit evaluation. Please try again.'); window.location.href='evaluation.php';</script>";
        }
    
        $stmt->close();
        $conn->close();

    
    }

?>


<!DOCTYPE html>
<html>
    <head>  
        <title>Hanuka's Resort CyberSecurity Evaluation</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="evaluationstyle.css">
    </head>

    <body>
        <form method="post" action="evaluation_p1.php">
            <label id = "q1">1. What is the best practice when creating a password for your company account?</label><br>
            <input type="radio" name="q1" value="a"> Using your birthdate or pet's name<br>
            <input type="radio" name="q1" value="b"> Using a combination of letters, numbers, and symbols <br>
            <input type="radio" name="q1" value="c"> Using the same password across all accounts<br>
            <input type="radio" name="q1" value="d"> Writing your password down on a sticky note<br>

            <label id = "q2">2. What should you do if you receive an email from an unknown sender asking for confidential company information?</label><br>
            <input type="radio" name="q2" value="a"> Reply immediately to avoid conflict<br>
            <input type="radio" name="q2" value="b"> Click on the links to verify the sender<br>
            <input type="radio" name="q2" value="c"> Report the email to your supervisor or IT department<br>
            <input type="radio" name="q2" value="d"> Forward the email to your co-workers<br>

            <label id = "q3">3. Which of the following is an example of phishing?</label><br>
            <input type="radio" name="q3" value="a"> A customer calling to ask about room availability<br>
            <input type="radio" name="q3" value="b"> Receiving an email that appears to be from your bank asking for login<br>
            <input type="radio" name="q3" value="c"> A system update notification from your company’s software<br>
            <input type="radio" name="q3" value="d"> Getting a text from your manager about a meeting<br>

            <label id = "q4">4. If you accidentally download a suspicious file on your work computer, what should you do first?</label><br>
            <input type="radio" name="q4" value="a"> Delete the file and continue working<br>
            <input type="radio" name="q4" value="b"> Inform your supervisor or IT department immediately <br>
            <input type="radio" name="q4" value="c"> Restart the computer<br>
            <input type="radio" name="q4" value="d"> Ignore it if nothing seems wrong<br>

            <label id = "q5">5. What is the safest way to share sensitive customer data?</label><br>
            <input type="radio" name="q5" value="a"> Through social media direct messages<br>
            <input type="radio" name="q5" value="b"> Via personal email <br>
            <input type="radio" name="q5" value="c"> Using encrypted email or secured company systems<br>
            <input type="radio" name="q5" value="d">  On a shared USB drive<br>

            <label id = "q6">6. Why should you always lock your workstation when stepping away?</label><br>
            <input type="radio" name="q6" value="a"> To save battery<br>
            <input type="radio" name="q6" value="b"> To prevent unauthorized access to company data <br>
            <input type="radio" name="q6" value="c"> To make your workstation look organized<br>
            <input type="radio" name="q6" value="d"> It’s just a company policy without real impact<br>

            <label id = "q7">7. What is considered a strong password?</label><br>
            <input type="radio" name="q7" value="a"> Password123<br>
            <input type="radio" name="q7" value="b"> M4n!l4R3sort2024 <br>
            <input type="radio" name="q7" value="c"> yourname123<br>
            <input type="radio" name="q7" value="d">  Resort2024<br>

            <label id = "q8">8. If you receive a suspicious attachment from a known sender, what is the best action?</label><br>
            <input type="radio" name="q8" value="a"> Open it since you know the sender<br>
            <input type="radio" name="q8" value="b"> Download it and scan later <br>
            <input type="radio" name="q8" value="c"> Contact the sender directly to verify before opening<br>
            <input type="radio" name="q8" value="d"> Forward it to your co-workers<br>

            <label id = "q9">9. Which action could potentially compromise the resort’s cybersecurity?</label><br>
            <input type="radio" name="q9" value="a"> Using a secure Wi-Fi network<br>
            <input type="radio" name="q9" value="b"> Writing down your password on a notebook near the workstation <br>
            <input type="radio" name="q9" value="c"> Enabling two-factor authentication<br>
            <input type="radio" name="q9" value="d">  Updating antivirus software regularly<br>

            <label id = "q10">10. What is the best way to identify a secure website?</label><br>
            <input type="radio" name="q10" value="a"> The website ends with ".com"<br>
            <input type="radio" name="q10" value="b"> It asks for your password immediately <br>
            <input type="radio" name="q10" value="c"> It uses https:// and displays a padlock icon in the URL bar <br>
            <input type="radio" name="q10" value="d">  The website loads quickly<br>

            <input type="submit" value="Submit">
        </form>
    </body>

</html>