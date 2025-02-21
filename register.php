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
        <link rel="stylesheet" href="indexstyles.css">
    </head>
    <style>
        label {
            margin-top: 10px;
            color: #453a17;
            font-weight: bold;
            min-width: 10.5cm;
            width: 36%;
            text-align: left;
        }

        input[type="text"], input[type="password"] , input[type="number"] {
            min-width: 10cm;
            width: 33%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="submit"] {
            margin-top: 17px;
            background-color: #e4a70e;
            color: #453a17;
            border: none;
            min-width: 10cm;
            width: 30%;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
            font-size: 16px;
        }

        
    </style>
    
    <body>
        <div class="wrapper">
            <div class="login-container" style="width: 100%">
                <h1>Register</h1>
                <form action="register.php "method="post" onsubmit="return validatePassword()">
                    <label>First Name:</label>
                    <input type="text" name="first_name" required>
                    <label>Last Name:</label>
                    <input type="text" name="last_name" required>
                    <label>Age:</label>
                    <input type="number" name="age" id="age" required>
                    <label>Gender:</label>
                    <div style="display: inline-block; text-align: left; ">
                        <input type="radio" id="male" name="gender" value="M" required>
                        <label for="male">Male</label>
                        <br>
                        <input type="radio" id="female" name="gender" value="F" required>
                        <label for="female">Female</label>
                    </div>
                    <label>Phone Number:</label>
                    <input type="text" name="phone" required>
                    <label>Email:</label>
                    <input type="text" name="email" required>
                    <label>Password:</label>
                    <input type="password" name="password" id="password" required>
                    <label>Repeat Password:</label>
                    <input type="password" name="confirmpassword" id="confirmpassword" required>
                    <input type="submit" value="Sign Up">
                </form>
                <h4>Already have an account? <a href="index.php">Go to Login</a></h4>
            </div>
        </div>
    </body>
    <script>
        function validatePassword() {
            let password = document.getElementById("password").value;
            let confirmPassword = document.getElementById("confirmpassword").value;

            if (password !== confirmPassword) {
                alert("❌ Passwords do not match! Please try again.");
                return false;
            }
            return true;
        }
    </script>

</html>