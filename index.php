<?php
    include('db.php');
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Hanuka's Resort CyberSecurity Evaluation</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="indexstyles.css">
    </head>
    <body>
        <div class="wrapper">
            <div class="login-container">
                <h1>Sign In</h1>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                    <label>Email:</label>
                    <input type="text" name="email">
                    <label>Password:</label>
                    <input type="password" name="password">
                    <input type="submit" value="Login">
                </form>
                <h4>No Account Yet? <a href="registernow.php">Register Now</a></h4>
            </div>
            <div class="image-container"></div>
        </div>
    </body>
</html>
