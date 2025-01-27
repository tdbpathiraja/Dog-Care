<?php
include '../database/dbcon.php';


$stmt = $conn->prepare("INSERT INTO users (username, password, name, email_address, telephone_number, address) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssss", $username, $hashed_password, $name, $email, $telephone, $address);


$username = $_POST['username'];
$password = $_POST['password'];
$name = $_POST['name'];
$email = $_POST['email'];
$telephone = $_POST['telephone'];
$address = $_POST['address'];


$hashed_password = password_hash($password, PASSWORD_DEFAULT);


if ($stmt->execute()) {
    echo "<script>alert('User Added to the System!!.'); window.location.href='../../admin-dashboard.php';</script>";
} else {
    echo "<script>alert('Error: " . addslashes($stmt->error) . "'); window.location.href='../../admin-dashboard.php';</script>";
}


$stmt->close();
$conn->close();
?>