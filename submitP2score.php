<?php
session_start();
include 'db.php'; // Ensure this connects to your database

if (!isset($_SESSION["user"]["id"])) {
    echo "<script>alert('User not logged in.'); window.location.href='login.php';</script>";
    exit();
}


if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["score"])) {
    $user_id = $_SESSION["user"]["id"];
    $score = intval($_POST["score"]); // Convert to integer for security

    $stmt = $conn->prepare("SELECT * FROM evaluation WHERE employeeID = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        echo "<script>alert('Finish Part 1 of the Evaluation First'); window.location.href='dashboard.php';</script>";
        exit();
    }


    $stmt = $conn->prepare("UPDATE evaluation SET scoreP2 = ? WHERE employeeID = ?;");
    $stmt->bind_param("ii", $score, $user_id);

    if ($stmt->execute()) {
        echo "<script>alert('Score Submitted');";
        echo "<script>window.location.href='dashboard.php';</script>";
    } else {
        echo "<script>alert('Failed to submit score. Try again.'); window.location.href='evaluation.php';</script>";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "<script>alert('Invalid request.'); window.location.href='dashboard.php';</script>";
}
?>
