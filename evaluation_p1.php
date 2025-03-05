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
        <link rel="stylesheet" href="evaluation_p1styles.css">
    </head>

    <body>
        <form method="post" action="evaluation_p1.php">
            <label id="q1">1. What is the best practice when creating a password for your company account?</label><br>
            <div class="option"><input type="radio" name="q1" value="a"><span>Using your birthdate or pet's name</span></div>
            <div class="option"><input type="radio" name="q1" value="b"><span>Using a combination of letters, numbers, and symbols</span></div>
            <div class="option"><input type="radio" name="q1" value="c"><span>Using the same password across all accounts</span></div>
            <div class="option"><input type="radio" name="q1" value="d"><span>Writing your password down on a sticky note</span></div>

            <label id="q2">2. What should you do if you receive an email from an unknown sender asking for confidential company information?</label><br>
            <div class="option"><input type="radio" name="q2" value="a"><span>Reply immediately to avoid conflict</span></div>
            <div class="option"><input type="radio" name="q2" value="b"><span>Click on the links to verify the sender</span></div>
            <div class="option"><input type="radio" name="q2" value="c"><span>Report the email to your supervisor or IT department</span></div>
            <div class="option"><input type="radio" name="q2" value="d"><span>Forward the email to your co-workers</span></div>

            <label id="q3">3. Which of the following is an example of phishing?</label><br>
            <div class="option"><input type="radio" name="q3" value="a"><span>A customer calling to ask about room availability</span></div>
            <div class="option"><input type="radio" name="q3" value="b"><span>Receiving an email that appears to be from your bank asking for login</span></div>
            <div class="option"><input type="radio" name="q3" value="c"><span>A system update notification from your company’s software</span></div>
            <div class="option"><input type="radio" name="q3" value="d"><span>Getting a text from your manager about a meeting</span></div>

            <label id="q4">4. If you accidentally download a suspicious file on your work computer, what should you do first?</label><br>
            <div class="option"><input type="radio" name="q4" value="a"><span>Delete the file and continue working</span></div>
            <div class="option"><input type="radio" name="q4" value="b"><span>Inform your supervisor or IT department immediately</span></div>
            <div class="option"><input type="radio" name="q4" value="c"><span>Restart the computer</span></div>
            <div class="option"><input type="radio" name="q4" value="d"><span>Ignore it if nothing seems wrong</span></div>

            <label id="q5">5. What is the safest way to share sensitive customer data?</label><br>
            <div class="option"><input type="radio" name="q5" value="a"><span>Through social media direct messages</span></div>
            <div class="option"><input type="radio" name="q5" value="b"><span>Via personal email</span></div>
            <div class="option"><input type="radio" name="q5" value="c"><span>Using encrypted email or secured company systems</span></div>
            <div class="option"><input type="radio" name="q5" value="d"><span>On a shared USB drive</span></div>

            <label id="q6">6. Why should you always lock your workstation when stepping away?</label><br>
            <div class="option"><input type="radio" name="q6" value="a"><span>To save battery</span></div>
            <div class="option"><input type="radio" name="q6" value="b"><span>To prevent unauthorized access to company data</span></div>
            <div class="option"><input type="radio" name="q6" value="c"><span>To make your workstation look organized</span></div>
            <div class="option"><input type="radio" name="q6" value="d"><span>It’s just a company policy without real impact</span></div>

            <label id="q7">7. What is considered a strong password?</label><br>
            <div class="option"><input type="radio" name="q7" value="a"><span>Password123</span></div>
            <div class="option"><input type="radio" name="q7" value="b"><span>M4n!l4R3sort2024</span></div>
            <div class="option"><input type="radio" name="q7" value="c"><span>yourname123</span></div>
            <div class="option"><input type="radio" name="q7" value="d"><span>Resort2024</span></div>

            <label id="q8">8. If you receive a suspicious attachment from a known sender, what is the best action?</label><br>
            <div class="option"><input type="radio" name="q8" value="a"><span>Open it since you know the sender</span></div>
            <div class="option"><input type="radio" name="q8" value="b"><span>Download it and scan later</span></div>
            <div class="option"><input type="radio" name="q8" value="c"><span>Contact the sender directly to verify before opening</span></div>
            <div class="option"><input type="radio" name="q8" value="d"><span>Forward it to your co-workers</span></div>

            <label id="q9">9. Which action could potentially compromise the resort’s cybersecurity?</label><br>
            <div class="option"><input type="radio" name="q9" value="a"><span>Using a secure Wi-Fi network</span></div>
            <div class="option"><input type="radio" name="q9" value="b"><span>Writing down your password on a notebook near the workstation</span></div>
            <div class="option"><input type="radio" name="q9" value="c"><span>Enabling two-factor authentication</span></div>
            <div class="option"><input type="radio" name="q9" value="d"><span>Updating antivirus software regularly</span></div>

            <label id="q10">10. What is the best way to identify a secure website?</label><br>
            <div class="option"><input type="radio" name="q10" value="a"><span>The website ends with ".com"</span></div>
            <div class="option"><input type="radio" name="q10" value="b"><span>It asks for your password immediately</span></div>
            <div class="option"><input type="radio" name="q10" value="c"><span>It uses https:// and displays a padlock icon in the URL bar</span></div>
            <div class="option"><input type="radio" name="q10" value="d"><span>The website loads quickly</span></div>

            <input type="submit" value="Submit">
        </form>
    </body>

</html>