<?php
include('db.php');
session_start();

if (!isset($_SESSION["user"])) {
    echo "<script>alert('You must be logged in to view this page!'); window.location.href='login.php';</script>";
    exit();
}

    $user_id = $_SESSION["user"]["id"];
    $stmt = $conn->prepare("SELECT * FROM evaluation WHERE employeeID = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        echo "<script>alert('Finish Part 1 of the Evaluation First'); window.location.href='dashboard.php';</script>";
        exit();
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="evaluation_p2styles.css">
    <title>Cybersecurity Simulation Game</title>
</head>
<body>
    <div class="container">
        <div class="laptop">
            <h3>Email</h3>
            <p id="sender"></p>
            <p id="subject"></p>
            <p id="body"></p>
            <button id="accept-btn" onclick="handleAction('accept')">Accept</button>
            <button id="reject-btn" onclick="handleAction('reject')">Reject</button>
            <button id="report-btn" onclick="handleAction('report')">Report</button>
        </div>
        <div class="phone">
            <h3>Notes</h3>
            <p>- Check for urgent language in emails.</p>
            <p>- Verify sender addresses.</p>
            <p>- Be cautious of unexpected attachments or links.</p>
        </div>
    </div>
    <p> <span id="score">0</span></p>
    
    <script>
        const emails = [
            { sender: "bank@secure.com", subject: "Important: Update Your Password", body: "Dear user, please update your password immediately to secure your account.", type: "phishing" },
            { sender: "newsletter@shop.com", subject: "Big Sale!", body: "Check out our latest discounts!", type: "spam" },
            { sender: "boss@company.com", subject: "Meeting Reminder", body: "Don't forget our meeting at 3 PM.", type: "legitimate" }
        ];

        let currentEmailIndex = 0;
        let score = 0;

        function displayEmail() {
            if (currentEmailIndex < emails.length) {
                const email = emails[currentEmailIndex];
                document.getElementById("sender").textContent = `From: ${email.sender}`;
                document.getElementById("subject").textContent = `Subject: ${email.subject}`;
                document.getElementById("body").textContent = email.body;
            } else {
                document.querySelector(".laptop").innerHTML = "<h3>All emails processed!</h3>";
                submitScoreToDatabase(score); 
            }
        }

        function handleAction(action) {
            if (currentEmailIndex < emails.length) {
                const email = emails[currentEmailIndex];
                if ((email.type === "phishing" && action === "report") ||
                    (email.type === "spam" && action === "reject") ||
                    (email.type === "legitimate" && action === "accept")) {
                    score += 1;
                } 
                document.getElementById("score").textContent = score;
                currentEmailIndex++;
                displayEmail();
            }
        }

        function submitScoreToDatabase(score) {
            fetch('submitP2score.php', {  // Point to your PHP script
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({
                    score: score
                })
            })
            .then(response => response.text()) // Expect text response (for redirection)
            .then(data => {
                console.log("Server response:", data);
                window.location.href = "dashboard.php"; // Redirect after successful submission
            })
            .catch(error => console.error("Error submitting score:", error));
        }

        displayEmail();
    </script>
</body>
</html>
