<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            position: relative;
        }

        /* Blurred background image */
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('assets/placeholderResort.jpg') no-repeat center center;
            background-size: cover;
            filter: blur(8px);
            z-index: -1;
        }

        .welcome-container {
            background: rgba(255, 229, 180, 0.9); /* Semi-transparent background */
            padding: 40px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
            max-width: 600px;
            width: 90%;
        }

        h1 {
            color: #453a17;
            margin-bottom: 20px;
        }

        p {
            color: #453a17;
            font-size: 18px;
        }

        /* Button styling */
        .redirect-button {
            margin-top: 20px;
            background-color: #e4a70e;
            color: #453a17;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
            font-size: 24px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .redirect-button:hover {
            background-color: #b47800;
        }
    </style>
</head>
<body>
    <div class="welcome-container">
        <h1>Welcome to Hanuka's Resort CyberSecurity Evaluation</h1>
        <p>Assess your capability in handling the security of Hanuka's Resort Website</p>
        <!-- Button to redirect to login.php -->
        <button class="redirect-button" onclick="redirectToLogin()">Login</button>
    </div>

    <script>
        // JavaScript function to redirect to login.php
        function redirectToLogin() {
            window.location.href = "login.php";
        }
    </script>
</body>
</html>
