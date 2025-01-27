<?php
session_start();
include '../../database/dbcon.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $new_name = trim($_POST['new_name']);

    if (empty($new_name)) {
        echo "<script>alert('Name cannot be empty.'); window.history.back();</script>";
        exit();
    }

    $stmt = $conn->prepare("UPDATE users SET name = ? WHERE username = ?");
    $stmt->bind_param("ss", $new_name, $username);
    
    if ($stmt->execute()) {
        echo "<script>alert('Name updated successfully.'); window.location.href='../../../user-dashboard.php';</script>";
    } else {
        echo "<script>alert('Error updating name in database.'); window.history.back();</script>";
    }
}
?>