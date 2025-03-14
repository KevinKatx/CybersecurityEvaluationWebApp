<?php
    include('db.php');
    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST["email"];
        $password = $_POST["password"];
    
        // Fetch user from the database
        $stmt = $conn->prepare("SELECT * FROM employee WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
    
        // Debug: Print user data
        if (!$user) {
            echo "<script>alert('User not found!');</script>";
            exit();
        }

        // Verify the hashed password (remove re-hashing)
        if (password_verify($password, $user["password"])) {
            if($user["role"] == "Admin"){
                $_SESSION["admin"] = $user["email"];
                echo "<script>alert('Login successful!'); window.location.href='admin_dashboard.php';</script>";
            }
            $_SESSION["user"] = $user;
            echo "<script>alert('Login successful!'); window.location.href='dashboard.php';</script>";
        } else {
            echo "<script>alert('Invalid email or password');</script>";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Hanuka's Resort CyberSecurity Evaluation</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="loginstyles.css">
    </head>
    <body>
        <div class="wrapper">
            <div class="login-container">
                <h1>Sign In</h1>
                <form method="post" action="login.php">
                    <label>Email:</label>
                    <input type="text" name="email">
                    <label>Password:</label>
                    <input type="password" name="password">
                    <input type="submit" value="Login">
                </form>
                <h4>No Account Yet? <a href="register.php">Register Now</a></h4>
            </div>
            <div class="image-container"></div>
        </div>
    </body>
</html>
