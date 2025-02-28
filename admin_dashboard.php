<?php

$api_url = 'http://127.0.0.1/CybersecurityEvaluationWebApp/api.php';

$ch = curl_init($api_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

$users = json_decode($response, true);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Users Table</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin_dashboardstyles.css">
</head>

<body>
    <a href="register.php" class="back-button">Back to Register</a>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Age</th>
                <th>Gender</th>
                <th>Phone</th>
                <th>E-mail</th>
                <th>Role</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($users)): ?>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= htmlspecialchars($user['id']) ?></td>
                        <td><?= htmlspecialchars($user['first_name']) ?></td>
                        <td><?= htmlspecialchars($user['last_name']) ?></td>
                        <td><?= htmlspecialchars($user['age']) ?></td>
                        <td><?= htmlspecialchars($user['gender']) ?></td>
                        <td><?= htmlspecialchars($user['phone']) ?></td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                        <td><?= htmlspecialchars($user['Role']) ?></td>
                        <td>
                            <a href="update.php?id=<?= $user['id'] ?>">
                                <button class="edit-btn">Edit</button>
                            </a>
                            <button class="delete-btn" onclick="deleteUser(<?= $user['id'] ?>)">Delete</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="9">No users found</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <script>
        function deleteUser(id) {
            if (confirm("Are you sure you want to delete this user?")) {
                fetch(`http://127.0.0.1/CybersecurityEvaluationWebApp/api.php?id=${id}`, {
                    method: 'DELETE'
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.message);
                    location.reload();
                })
                .catch(error => console.error('Error:', error));
            }
        }
    </script>
</body>
</html>