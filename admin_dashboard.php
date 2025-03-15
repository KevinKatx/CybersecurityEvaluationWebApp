<?php

include('db.php');
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'Admin') {
    echo "<script>
            alert('You are unauthorized to view this page');
            window.location.href='login.php';
          </script>";
    exit();
}

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
    <div class="modal" id="userModal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal()">&times;</span>
            <h2>User Details</h2>
            <p id="modalContent"></p> 
        </div>
    </div>
    <a href="logout.php" class="back-button">Back to Login</a>
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
                    <tr onclick="handleRowClick(event, <?=$user['id']?>, '<?=$user['role']?>')">
                        <td><?= htmlspecialchars($user['id']) ?></td>
                        <td><?= htmlspecialchars($user['first_name']) ?></td>
                        <td><?= htmlspecialchars($user['last_name']) ?></td>
                        <td><?= htmlspecialchars($user['age']) ?></td>
                        <td><?= htmlspecialchars($user['gender']) ?></td>
                        <td><?= htmlspecialchars($user['phone']) ?></td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                        <td><?= htmlspecialchars($user['role']) ?></td>
                        <td>
                            <a href="update.php?id=<?= $user['id'] ?>">
                                <button class="edit-btn">Edit</button>
                            </a>
                            <button class="delete-btn" onclick="deleteUser(<?= $user['id'] ?>);">Delete</button>
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
                    
                    // ✅ Force refresh the page after deletion
                    document.location.href = 'admin_dashboard.php';
                   
                })
                .catch(error => console.error('Error:', error));
            }
        }

        function handleRowClick(event, id, role) {
            // Prevent the modal if the click happened inside a button
            if (event.target.classList.contains("edit-btn") || event.target.classList.contains("delete-btn")) {
                return;
            }
            // Show modal only if not clicking edit/delete
            viewUser(id, role);
        }

        function viewUser(id, role) {
            console.log(`Viewing user with ID: ${id} and Role: ${role}`);
            fetch(`http://127.0.0.1/CybersecurityEvaluationWebApp/api.php?id=${id}`)
                .then(response => response.json())
                .then(data => {
                    let modalContent = document.getElementById("modalContent");
                    if (role === 'Employee') {
                        if (data.scoreP1 !== undefined && data.scoreP1 !== null && data.scoreP2 !== undefined && data.scoreP2 !== null) {
                            modalContent.innerHTML = `
                                <p><strong>Name:</strong> ${data.first_name} ${data.last_name}</p>
                                <p><strong>Email:</strong> ${data.email}</p>
                                <p><strong>P1 Score:</strong> ${data.scoreP1}</p>
                                 <p><strong>P2 Score:</strong> ${data.scoreP2}</p>
                            `;
                            document.getElementById("userModal").style.display = "flex";
                        } else {
                            
                            modalContent.innerHTML = `
                                <p><strong>Name:</strong> ${data.first_name} ${data.last_name}</p>
                                <p><strong>Email:</strong> ${data.email}</p>
                                <p>Employee has no score yet.</p>
                            `;
                            document.getElementById("userModal").style.display = "flex";
                        }
                    } else {
                        alert("Only Employees have scores!");
                    }
                })
                .catch(error => console.error("Error:", error));
        }

        function closeModal() {
            // Hide Modal
            document.getElementById("userModal").style.display = "none";
         }

    // Optional: Close Modal When Clicking Outside
    window.onclick = function (event) {
        const modal = document.getElementById("userModal");
        if (event.target == modal) {
            modal.style.display = "none";
        }
    };
    </script>
</body>
</html>