<?php
   include('db.php');
   session_start();
   
   if (!isset($_SESSION["user"])) {
       echo "<script>alert('You must be logged in to view this page!'); window.location.href='index.php';</script>";
       exit();
   }
   
   if ($_SERVER["REQUEST_METHOD"] == "POST") {
       // Debugging: Print form data
       echo "<pre>";
       var_dump($_POST);
       echo "</pre>";
   
       $correct_answers = [
           "q1" => "b", "q2" => "c", "q3" => "b", "q4" => "b", "q5" => "b",
           "q6" => "b", "q7" => "b", "q8" => "d", "q9" => "a", "q10" => "b",
           "q11" => "a", "q12" => "a", "q13" => "c", "q14" => "b", "q15" => "b",
           "q16" => "b", "q17" => "a", "q18" => "b", "q19" => "b", "q20" => "c",
           "q21" => "b", "q22" => "c", "q23" => "b", "q24" => "c", "q25" => "a",
           "q26" => "b", "q27" => "b", "q28" => "b", "q29" => "c", "q30" => "c",
           "q31" => "b", "q32" => "b", "q33" => "b", "q34" => "d", "q35" => "b",
           "q36" => "a", "q37" => "b", "q38" => "a", "q39" => "b", "q40" => "b"
       ];
   
       $score = 0;
   
       foreach ($correct_answers as $question_id => $answer) {
            if (isset($_POST[$question_id])) { // Now it matches the original question IDs
                $user_answer = trim($_POST[$question_id]);
                if ($user_answer == $answer) {
                    $score++;
                }
            }
        }
   
       echo "Calculated Score: $score";
    
        $user_id = $_SESSION["user"]["id"];
        $stmt = $conn->prepare("SELECT * FROM evaluation WHERE employeeID = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        $stmt = $conn->prepare("INSERT INTO evaluation (employeeID, scoreP1) VALUES (?, ?)");
        $stmt->bind_param("ii", $user_id, $score);
    
        if ($stmt->execute()) {
            echo "<script>window.location.href='dashboard.php';</script>";
        } else {
            echo "<script>alert('Failed to submit evaluation. Please try again.'); window.location.href='evaluation.php';</script>";
        }
        exit();
    } else {
        $stmt = $conn->prepare("UPDATE evaluation SET scoreP1 = ? WHERE employeeID = ?");
        $stmt->bind_param("ii", $score, $user_id);
    
        if ($stmt->execute()) {
            echo "<script>window.location.href='dashboard.php';</script>";
        } else {
            echo "<script>alert('Failed to submit evaluation. Please try again.'); window.location.href='evaluation.php';</script>";
        }
    }

    
        $stmt->close();
        $conn->close();
    }

    // Question Pool
    $questions = [
        1 => ["question" => "What is the best practice when creating a password?", "options" => ["a" => "Using birthdate", "b" => "Using letters, numbers, and symbols", "c" => "Same password everywhere", "d" => "Writing it down"]],
        2 => ["question" => "What should you do if you receive a suspicious email?", "options" => ["a" => "Reply immediately", "b" => "Click links to verify", "c" => "Report it", "d" => "Forward to co-workers"]],
        3 => ["question" => "What is phishing?", "options" => ["a" => "A type of virus", "b" => "A social engineering attack", "c" => "An encrypted message", "d" => "A type of firewall"]],
        4 => ["question" => "Which of the following is a strong password example?", "options" => ["a" => "password123", "b" => "Qw!89x@Pz", "c" => "mypassword", "d" => "abcde12345"]],
        5 => ["question" => "Why is two-factor authentication (2FA) important?", "options" => ["a" => "It makes logging in faster", "b" => "It provides an extra security layer", "c" => "It disables password requirements", "d" => "It replaces antivirus software"]],
        6 => ["question" => "What is the safest way to store your passwords?", "options" => ["a" => "Writing them down", "b" => "Using a password manager", "c" => "Saving in a text file", "d" => "Reusing the same password"]],
        7 => ["question" => "What should you do if your device gets infected with malware?", "options" => ["a" => "Ignore it", "b" => "Run an antivirus scan", "c" => "Continue using it", "d" => "Delete important files"]],
        8 => ["question" => "Which of these is a sign of a phishing email?", "options" => ["a" => "Unexpected sender", "b" => "Generic greetings", "c" => "Urgent action required", "d" => "All of the above"]],
        9 => ["question" => "What does HTTPS in a URL indicate?", "options" => ["a" => "A secure connection", "b" => "A website under construction", "c" => "A government site", "d" => "An internal network"]],
        10 => ["question" => "What is social engineering?", "options" => ["a" => "A form of encryption", "b" => "Manipulating people to gain information", "c" => "A type of firewall", "d" => "An antivirus update"]],
        11 => ["question" => "Why should you avoid using public Wi-Fi for sensitive transactions?", "options" => ["a" => "It is slow", "b" => "It is often unsecured", "c" => "It is expensive", "d" => "It drains battery faster"]],
        12 => ["question" => "What is a firewall?", "options" => ["a" => "A security system that blocks unauthorized access", "b" => "A type of virus", "c" => "An email filter", "d" => "A Wi-Fi signal booster"]],
        13 => ["question" => "Which of the following is NOT a type of malware?", "options" => ["a" => "Trojan horse", "b" => "Ransomware", "c" => "Firewall", "d" => "Spyware"]],
        14 => ["question" => "What should you do if you suspect a website is fake?", "options" => ["a" => "Enter your details to check", "b" => "Report it and avoid entering data", "c" => "Ignore the warning and continue", "d" => "Share it with friends"]],
        15 => ["question" => "Which of the following is the most secure authentication method?", "options" => ["a" => "Password only", "b" => "Biometrics + 2FA", "c" => "PIN number", "d" => "Security questions"]],
        16 => ["question" => "What does an antivirus program do?", "options" => ["a" => "Prevents all cyber attacks", "b" => "Detects and removes malware", "c" => "Stops spam emails", "d" => "Increases internet speed"]],
        17 => ["question" => "What is the main purpose of encryption?", "options" => ["a" => "Hiding data from hackers", "b" => "Increasing download speed", "c" => "Deleting unwanted files", "d" => "Making the internet faster"]],
        18 => ["question" => "Why should you lock your computer when leaving your desk?", "options" => ["a" => "To save battery", "b" => "To prevent unauthorized access", "c" => "To log out of accounts", "d" => "To clear browsing history"]],
        19 => ["question" => "Which of the following is a good practice for securing your email account?", "options" => ["a" => "Using the same password for all accounts", "b" => "Enabling two-factor authentication", "c" => "Clicking on all links to verify emails", "d" => "Disabling security alerts"]],
        20 => ["question" => "Which is the most common type of cyberattack?", "options" => ["a" => "DDoS attack", "b" => "Phishing", "c" => "Malware", "d" => "Man-in-the-middle attack"]],
        21 => ["question" => "What is the best way to handle software updates?", "options" => ["a" => "Ignore them", "b" => "Install as soon as possible", "c" => "Only install major updates", "d" => "Disable auto-updates"]],
        22 => ["question" => "What is the safest way to share sensitive information?", "options" => ["a" => "Email", "b" => "Text message", "c" => "Secure file-sharing service", "d" => "Social media"]],
        23 => ["question" => "Which of these is an example of a secure website?", "options" => ["a" => "http://example.com", "b" => "https://example.com", "c" => "example.net", "d" => "www.example.org"]],
        24 => ["question" => "What should you do if a website asks for unnecessary personal details?", "options" => ["a" => "Fill in fake details", "b" => "Provide accurate details", "c" => "Avoid using the site", "d" => "Use a weak password"]],
        25 => ["question" => "What does a VPN do?", "options" => ["a" => "Hides IP address and encrypts internet traffic", "b" => "Increases internet speed", "c" => "Eliminates need for passwords", "d" => "Automatically detects malware"]],
        26 => ["question" => "Which of these is a good practice for social media security?", "options" => ["a" => "Making all posts public", "b" => "Using a strong password", "c" => "Sharing login credentials with friends", "d" => "Clicking on all links in messages"]],
        27 => ["question" => "What should you do if your account gets hacked?", "options" => ["a" => "Ignore it", "b" => "Change password and enable 2FA", "c" => "Create a new account", "d" => "Continue using the account as usual"]],
        28 => ["question" => "What is ransomware?", "options" => ["a" => "A fake email", "b" => "Malware that encrypts files and demands payment", "c" => "A security software", "d" => "A social engineering attack"]],
        29 => ["question" => "What is the weakest link in cybersecurity?", "options" => ["a" => "Hardware", "b" => "Software", "c" => "People", "d" => "Firewalls"]],
        30 => ["question" => "How often should you change your passwords?", "options" => ["a" => "Only if hacked", "b" => "Every few months", "c" => "Never", "d" => "Every year"]],
        31 => ["question" => "What is the primary goal of a cyber attack?", "options" => ["a" => "To improve system performance", "b" => "To steal, damage, or disrupt data", "c" => "To update software", "d" => "To test antivirus software"]],
        32 => ["question" => "What is the term for software that records your keystrokes?", "options" => ["a" => "Trojan horse", "b" => "Keylogger", "c" => "Adware", "d" => "Ransomware"]],
        33 => ["question" => "What should you do if you receive a call from someone claiming to be IT support asking for your password?", "options" => ["a" => "Give it to them", "b" => "Verify their identity before sharing", "c" => "Hang up and report the call", "d" => "Change your password immediately"]],
        34 => ["question" => "Which of the following is a common method of spreading malware?", "options" => ["a" => "Downloading files from untrusted sources", "b" => "Opening email attachments from unknown senders", "c" => "Clicking on suspicious links", "d" => "All of the above"]],
        35 => ["question" => "What is the purpose of a CAPTCHA?", "options" => ["a" => "To increase website loading speed", "b" => "To prevent bots from accessing websites", "c" => "To store user passwords", "d" => "To scan for malware"]],
        36 => ["question" => "What is the most secure way to connect to a public Wi-Fi network?", "options" => ["a" => "Using a VPN", "b" => "Turning off Wi-Fi", "c" => "Using an open connection", "d" => "Sharing login credentials"]],
        37 => ["question" => "What should you do if a website asks for your personal information unexpectedly?", "options" => ["a" => "Enter your details", "b" => "Verify the site's authenticity", "c" => "Ignore the request", "d" => "Send an email asking for confirmation"]],
        38 => ["question" => "What is an insider threat in cybersecurity?", "options" => ["a" => "A threat from within an organization", "b" => "An external hacking attempt", "c" => "A phishing scam", "d" => "A type of firewall"]],
        39 => ["question" => "What should you do with an old hard drive before disposing of it?", "options" => ["a" => "Throw it away", "b" => "Physically destroy or wipe the data", "c" => "Give it to someone else", "d" => "Store it indefinitely"]],
        40 => ["question" => "What is a zero-day vulnerability?", "options" => ["a" => "A known security flaw with an available fix", "b" => "A security flaw that has no patch yet", "c" => "An antivirus software update", "d" => "A type of firewall attack"]],
    ];
    
    

    $random_keys = array_rand($questions, 20);
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
            <?php foreach ($random_keys as $key) { ?>
                <label id="q<?php echo $key; ?>"> <?php echo $questions[$key]["question"]; ?></label><br>
                <?php foreach ($questions[$key]["options"] as $optionKey => $optionValue) { ?>
                    <div class="option">
                        <input type="radio" name="q<?php echo $key; ?>" value="<?php echo $optionKey; ?>">
                        <span><?php echo $optionValue; ?></span>
                    </div>
                <?php } ?>
            <?php } ?>
            <input type="submit" value="Submit">
        </form>
    </body>
</html>
