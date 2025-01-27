<?php
include '../../database/dbcon.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $name = $_POST['name'];
    $email_address = $_POST['email_address'];
    $telephone_number = $_POST['telephone_number'];
    $address = $_POST['address'];

    $sql = "UPDATE users SET username=?, name=?, email_address=?, telephone_number=?, address=? WHERE ID=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $username, $name, $email_address, $telephone_number, $address, $id);
    
    if ($stmt->execute()) {
        echo "User  updated successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
    header("Location: ../../../admin-dashboard.php");
}
?>