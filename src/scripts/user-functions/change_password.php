<?php
session_start();
include '../../database/dbcon.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($new_password) || empty($confirm_password)) {
        echo "<script>alert('New password fields cannot be empty.'); window.history.back();</script>";
        exit();
    }

    if ($new_password !== $confirm_password) {
        echo "<script>alert('New passwords do not match.'); window.history.back();</script>";
        exit();
    }

    $stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if (password_verify($current_password, $user['password'])) {
        
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE username = ?");
        $stmt->bind_param("ss", $hashed_password, $username);
        
        if ($stmt->execute()) {
            echo "<script>alert('Password updated successfully.'); window.location.href='../../../user-dashboard.php';</script>";
        } else {
            echo "<script>alert('Error updating password in database.'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Current password is incorrect.'); window.history.back();</script>";
    }
}
?>