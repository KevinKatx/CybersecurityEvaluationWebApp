<?php
    include('db.php');
    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Check if all fields are filled
        if (!isset($_POST["first_name"], $_POST["last_name"], $_POST["age"], $_POST["gender"], $_POST["phone"], $_POST["email"], $_POST["password"], $_POST["confirmpassword"])) {
            echo "<p>All fields are required!</p>";
            exit();
        }
    
        // Get form data
        $first_name = $_POST["first_name"];
        $last_name = $_POST["last_name"];
        $age = $_POST["age"];
        $gender = $_POST["gender"];
        $phone = $_POST["phone"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $confirm_password = $_POST["confirmpassword"];
    
        // Check if passwords match
        if ($password !== $confirm_password) {
            echo "<p style='color: red;'>Passwords do not match!</p>";
            exit();
        }
    
        // Hash password before sending it to API
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    
        // Convert data to JSON
        $data = [
            "first_name" => $first_name,
            "last_name" => $last_name,
            "age" => $age,
            "gender" => $gender,
            "phone" => $phone,
            "email" => $email,
            "password" => $hashed_password
        ];
        
        $json_data = json_encode($data);
    
        // Send data to API using cURL
        $ch = curl_init("http://127.0.0.1/CybersecurityEvaluationWebApp/api.php");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
    
        $response = curl_exec($ch);
        if ($response === false) {
            die("cURL Error: " . curl_error($ch));
        }
        curl_close($ch);
        var_dump($response);
        exit();
    
        // Decode JSON response
        $result = json_decode($response, true);

        if ($result === null) {
            die("API response is invalid: " . $response);
        }

    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Hanuka's Resort CyberSecurity Evaluation</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="registerstyles.css">
</head>

<body>
    <div class="wrapper">
        <div class="image-container"></div>
        <div class="form-container">
            <div class="register-container">
                <h1>Register</h1>
                <form action="register.php" method="post" onsubmit="return validateForm()">
                    <div class="row-container">
                        <div>
                            <label>First Name:</label>
                            <input type="text" name="first_name" required>
                        </div>
                        <div>
                            <label>Last Name:</label>
                            <input type="text" name="last_name" required>
                        </div>
                    </div>

                    <div class="age-gender-container">
                        <div class="age-container">
                            <label>Age:</label>
                            <input type="number" name="age" id="age" required min="1">
                        </div>
                        <label>Gender:</label>
                        <div class="gender-container">
                            <label><input type="radio" name="gender" value="M" required> Male</label>
                            <label><input type="radio" name="gender" value="F" required> Female</label>
                        </div>
                    </div>

                    <div class="row-container">
                        <div>
                            <label>Phone Number:</label>
                            <input type="text" name="phone" id="phone" required oninput="validatePhone()">
                            <small id="phoneError" style="color: red; display: none;">Invalid phone format (09XXXXXXXXX)</small>
                        </div>
                        <div>
                            <label>Email:</label>
                            <input type="email" name="email" id="email" required oninput="validateEmail()">
                            <small id="emailError" style="color: red; display: none;">Invalid email format</small>
                        </div>
                    </div>

                    <div class="row-container">
                        <div>
                            <label>Password:</label>
                            <input type="password" name="password" id="password" required>
                        </div>
                        <div>
                            <label>Repeat Password:</label>
                            <input type="password" name="confirmpassword" id="confirmpassword" required>
                        </div>
                    </div>

                    <input type="submit" value="Sign Up">
                </form>
                <h4>Already have an account? <a href="login.php">Go to Login</a></h4>
            </div>
        </div>
    </div>

    <script>
        function validatePhone() {
            const phoneInput = document.getElementById("phone");
            const phoneError = document.getElementById("phoneError");
            const phonePattern = /^09\d{9}$/; // Philippine mobile format (09XXXXXXXXX)

            if (!phonePattern.test(phoneInput.value)) {
                phoneError.style.display = "block";
            } else {
                phoneError.style.display = "none";
            }
        }

        function validateEmail() {
            const emailInput = document.getElementById("email");
            const emailError = document.getElementById("emailError");
            const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

            if (!emailPattern.test(emailInput.value)) {
                emailError.style.display = "block";
            } else {
                emailError.style.display = "none";
            }
        }

        function validateForm() {
            const password = document.getElementById("password").value;
            const confirmPassword = document.getElementById("confirmpassword").value;
            const phone = document.getElementById("phone").value;
            const email = document.getElementById("email").value;
            
            const phonePattern = /^09\d{9}$/;
            const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

            if (password !== confirmPassword) {
                alert("❌ Passwords do not match! Please try again.");
                return false;
            }

            if (!phonePattern.test(phone)) {
                alert("❌ Invalid phone number! Use format: 09XXXXXXXXX.");
                return false;
            }

            if (!emailPattern.test(email)) {
                alert("❌ Invalid email format!");
                return false;
            }

            return true;
        }
    </script>
</body>
</html>
