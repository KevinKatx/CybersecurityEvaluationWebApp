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

    <div id="instructionModal" class="modal">
        <div class="modal-content">
            <h2>Instructions</h2>
            <p>Analyze each email carefully and determine the best course of action:</p>
            <ul>
                <li><strong>Accept</strong> if the email is legitimate.</li>
                <li><strong>Reject</strong> if it is spam.</li>
                <li><strong>Report</strong> if it is phishing.</li>
                <li>Check for urgent language, sender details, and unexpected attachments or links.</li>
            </ul>
            <button class="close-btn" onclick="closeModal()">Got It!</button>
        </div>
    </div>


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
            <p>- Accept if the email is legitimate.</p>
            <p>- Reject if it is spam.</p>
            <p>- Report if it is phishing.</p>
            <p>- Check for urgent language in emails.</p>
            <p>- Verify sender addresses.</p>
            <p>- Be cautious of unexpected attachments or links.</p>
            <p>- Look closely at the names of the sender</p>
            <p>- Legitimate Emails: </p>
            <p>Evelyn@yahoo.com.ph</p>
            <p>kennethVice@gmail.com</p>
            <p>hr@company.com</p>
            <p>it-department@company.com</p>
        </div>
    </div>
    <p> <span id="score">0</span></p>
    
    <script>
       
        const emails = [
            { sender: "bank@secure.com", subject: "Important: Update Your Password", body: "Dear user, please update your password immediately to secure your account.", type: "phishing" },
            { sender: "newsletter@shop.com", subject: "Big Sale!", body: "Check out our latest discounts!", type: "spam" },
            { sender: "Evelyn@company.com", subject: "Meeting Reminder", body: "Don't forget our meeting at 3 PM.", type: "legitimate" },
            { sender: "security@paypal-support.com", subject: "Your Account Has Been Compromised!", body: "Please click this link to secure your account immediately.", type: "phishing" },
            { sender: "hr@company.com", subject: "Employee Benefits Update", body: "Please review the new company benefits policy attached.", type: "legitimate" },
            { sender: "lottery@bigwin.com", subject: "Congratulations, You Won!", body: "Claim your $1,000,000 prize now by providing your details!", type: "phishing" },
            { sender: "friend@social.com", subject: "Check out this funny video!", body: "Click this link to see the hilarious video!", type: "spam" },
            { sender: "ceo@company.com", subject: "Urgent: Send me the financial reports", body: "I need the latest financial documents ASAP. Reply now.", type: "phishing" },
            { sender: "support@amazown.com", subject: "Order Confirmation", body: "Your recent order has been shipped. Enter your details and track it here.", type: "phishing" },
            { sender: "it-department@company.com", subject: "Scheduled Maintenance Notice", body: "System maintenance will occur this Saturday at midnight.", type: "legitimate" },
            { sender: "noreply@randomsurvey.com", subject: "Win a Free Gift Card!", body: "Take this short survey and win a $500 gift card!", type: "spam" },
            { sender: "helpdesk@company.com", subject: "Password Expiration Notice", body: "Your company password will expire in 3 days. Change it here.", type: "phishing" },
            { sender: "Evelny@company.com", subject: "Credential Request", body: "Can you give me your password, its an emergency", type: "phishing" },
            { sender: "deals@bigsavings.com", subject: "Exclusive Offer Just for You!", body: "Hurry! Limited-time discounts on all products. Click here to claim.", type: "spam" },
            { sender: "newsletter@dailynews.com", subject: "Shocking News You Can't Miss!", body: "Read the latest viral story now!", type: "spam" },
            { sender: "kennethVice@gmail.com", subject: "Reports on reservation status", body: "Can you send me the files on regarding the reservation of Mrs. Doe? Thank you", type: "legitimate" }
        ];


        let listindex = [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15];
        let shuffledList = shuffleArray(listindex);
        let currentEmailIndex = 0;
        let score = 0;

        function shuffleArray(array) {
            let shuffled = [...array]; // Create a copy to avoid modifying the original array
            for (let i = shuffled.length - 1; i > 0; i--) {
                let j = Math.floor(Math.random() * (i + 1)); // Pick a random index
                [shuffled[i], shuffled[j]] = [shuffled[j], shuffled[i]]; // Swap elements
            }
            return shuffled;
        }

        function displayEmail() {
            if (currentEmailIndex < emails.length) {
                const email = emails[shuffledList[currentEmailIndex]];
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

        window.onload = function() {
            document.getElementById("instructionModal").style.display = "flex";
        };

        // Close the modal
        function closeModal() {
            document.getElementById("instructionModal").style.display = "none";
        }

        displayEmail();
    </script>
</body>
</html>
