<?php
session_start();
include '../database/dbcon.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        // Save the username in the session
        $_SESSION['username'] = $user['username'];
        header("Location: ../../user-dashboard.php");
        exit();
    } else {
        echo "<script>alert('Invalid user credentials.'); window.location.href='../../login.php';</script>";
        exit();
    }

    $stmt->close();
}
$conn->close();
?>