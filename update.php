<?php
if (!isset($_GET['id'])) {
    die("User ID is required.");
}

$id = $_GET['id'];
$api_url = "http://127.0.0.1/CybersecurityEvaluationWebApp/api.php?id=$id";

// Fetch existing user data
$ch = curl_init($api_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

$user = json_decode($response, true);

if (!$user) {
    die("User not found.");
}

// Handle form submission (Update user)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['_method']) && $_POST['_method'] == 'PUT') {
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $email = $_POST['email'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $phone = $_POST['phone'];
    $gender = $_POST['gender'];
    $age= $_POST['age'];
    $role = $_POST['Role'];
    

    $updated_data = [
        'id' => $id,
        'email' => $email,
        'first_name' => $first_name,
        'last_name' => $last_name,
        'phone' => $phone,
        'gender' => $gender,
        'age'=> $age,
        'Role' => $role
    ];
    if (!empty($password)) {
        $updated_data['password'] = $password;
    }
    // Initialize cURL for PUT request
    $ch = curl_init($api_url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($updated_data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);

    // Execute PUT request
    $response = curl_exec($ch);
    curl_close($ch);

    // Redirect after update
    header("Location: admin_dashboard.php");
    exit;                                                           
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="registerstyles.css">
</head>
<body>
    <div class="container">
        <h2>Update Entry</h2>
        <form method="POST" action="update.php?id=<?= $id ?>">
            <input type="hidden" name="_method" value="PUT">
            <div class="form-grid">
                <div>
                    <label for="first_name">First Name:</label><br>
                    <input type="text" id="first_name" name="first_name" value="<?= isset($user['first_name']) ? htmlspecialchars($user['first_name']) : '' ?>" required><br>
                </div>
                <div>
                    <label for="last_name">Last Name:</label><br>
                    <input type="text" id="last_name" name="last_name" value="<?= isset($user['last_name']) ? htmlspecialchars($user['last_name']) : '' ?>" required><br>
                </div>
                <div>
                    <label for="age">Age:</label><br>
                    <input type="number" id="age" name="age" value="<?= isset($user['age']) ? htmlspecialchars($user['age']) : '' ?>" required><br>
                </div>
                <div>
                    <label for="gender">Gender:</label><br>
                    <div style="display: inline-block; text-align: left;">
                        <input type="radio" id="male" name="gender" value="M" <?= (isset($user['gender']) && $user['gender'] == 'M') ? 'checked' : '' ?> required>
                        <label for="male">Male</label>
                        <br>
                        <input type="radio" id="female" name="gender" value="F" <?= (isset($user['gender']) && $user['gender'] == 'F') ? 'checked' : '' ?> required>
                        <label for="female">Female</label>
                    </div>
                </div>

                <div>
                    <label for="email">Email:</label><br>
                    <input type="email" id="email" name="email" value="<?= isset($user['email']) ? htmlspecialchars($user['email']) : '' ?>" required><br>
                </div>
                <div>
                    <label for="password">New Password (leave blank to keep current):</label><br>
                    <input type="password" id="password" name="password" value=""><br>
                </div>
                <div>
                    <label for="phone">Phone #:</label><br>
                    <input type="text" id="phone" name="phone" value="<?= isset($user['phone']) ? htmlspecialchars($user['phone']) : '' ?>" required><br>
                </div>
                <div>
                    <div style="display: inline-block; text-align: left;">
                        <input type="radio" id="Employee" name="Role" value="Employee" <?= (isset($user['Role']) && $user['Role'] == 'Employee') ? 'checked' : '' ?> required>
                        <label for="male">Employee</label>
                        <br>
                        <input type="radio" id="female" name="Role" value="Administrator" <?= (isset($user['Role']) && $user['Role'] == 'Administrator') ? 'checked' : '' ?> required>
                        <label for="female">Administrator</label>
                    </div>
                </div>
                
                <div class="full-width">
                    <input type="submit" value="Update">
                </div>
            </div>
        </form>
    </div>
</body>
<script>

</script>
</html>