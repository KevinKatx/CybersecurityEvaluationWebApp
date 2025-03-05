<?php

if (!isset($_GET['id'])) {
    die("User ID is required.");
}

$id = $_GET['id'];
$api_url = "http://127.0.0.1/CybersecurityEvaluationWebApp/api.php?id=$id";

$ch = curl_init($api_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

$user = json_decode($response, true);

if (!$user) {
    die("User not found.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['_method']) && $_POST['_method'] == 'PUT') {
    $password = $_POST['password'] ?? '';
    $email = $_POST['email'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $phone = $_POST['phone'];
    $gender = $_POST['gender'];
    $age = $_POST['age'];
    $role = $_POST['role'];

    $updated_data = [
        'id' => $id,
        'email' => $email,
        'first_name' => $first_name,
        'last_name' => $last_name,
        'phone' => $phone,
        'gender' => $gender,
        'age' => $age,
        'role' => $role
    ];
    if (!empty($password)) {
        $updated_data['password'] = $password;
    }

    $ch = curl_init($api_url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($updated_data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);

    $response = curl_exec($ch);
    curl_close($ch);

    header("Location: admin_dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User Entry</title>
    <link rel="stylesheet" href="updatestyles.css">
</head>
<body>
    <a href="admin_dashboard.php" class="back-button">&#8592; Back</a>
    <div class="container">
        <h2>Update User Entry</h2>
        <form method="POST" action="update.php?id=<?= $id ?>">
            <input type="hidden" name="_method" value="PUT">
            <div class="form-grid">
                <div>
                    <label>First Name:</label>
                    <input type="text" name="first_name" value="<?= htmlspecialchars($user['first_name']) ?>" required>
                </div>
                <div>
                    <label>Last Name:</label>
                    <input type="text" name="last_name" value="<?= htmlspecialchars($user['last_name']) ?>" required>
                </div>
                <div>
                    <label>Age:</label>
                    <input type="number" name="age" value="<?= htmlspecialchars($user['age']) ?>" required>
                </div>
                <div>
                    <label>Gender:</label>
                    <div class="radio-group">
                        <label>
                            <input type="radio" name="gender" value="M" <?= ($user['gender'] == 'M') ? 'checked' : '' ?>> Male
                        </label>
                        <label>
                            <input type="radio" name="gender" value="F" <?= ($user['gender'] == 'F') ? 'checked' : '' ?>> Female
                        </label>
                    </div>
                </div>
                <div>
                    <label>Email:</label>
                    <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
                </div>
                <div>
                    <label>New Password (leave blank to keep current):</label>
                    <input type="password" name="password">
                </div>
                <div>
                    <label>Phone #:</label>
                    <input type="text" name="phone" value="<?= htmlspecialchars($user['phone']) ?>" required>
                </div>
                <div>
                    <label>Role:</label>
                    <div class="radio-group">
                        <label>
                            <input type="radio" name="role" value="Employee" <?= ($user['role'] == 'Employee') ? 'checked' : '' ?>> Employee
                        </label>
                        <label>
                            <input type="radio" name="role" value="Admin" <?= ($user['role'] == 'Admin') ? 'checked' : '' ?>> Administrator
                        </label>
                    </div>
                </div>
                <div class="full-width">
                    <input type="submit" value="Update">
                </div>
            </div>
        </form>
    </div>
</body>
</html>
