<?php
session_start();
include '../database/dbcon.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    
    $stmt = $conn->prepare("SELECT * FROM admin WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();

    if ($admin && $admin['password'] === $password) {
       
        $_SESSION['admin_id'] = $admin['ID'];
        header("Location: ../../admin-dashboard.php"); 
        exit();
    } else {
        echo "<script>alert('Invalid user credentials.'); window.location.href='../../login.php';</script>";
    }

    $stmt->close();
}
$conn->close();
?>