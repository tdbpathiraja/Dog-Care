<?php
session_start();
include '../../database/dbcon.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $new_email = trim($_POST['new_email']);

    if (!filter_var($new_email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email format.'); window.history.back();</script>";
        exit();
    }

    $stmt = $conn->prepare("UPDATE users SET email_address = ? WHERE username = ?");
    $stmt->bind_param("ss", $new_email, $username);
    
    if ($stmt->execute()) {
        echo "<script>alert('Email updated successfully.'); window.location.href='../../../user-dashboard.php';</script>";
    } else {
        echo "<script>alert('Error updating email in database.'); window.history.back();</script>";
    }
}
?>