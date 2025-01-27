<?php
include '../database/dbcon.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $username = $_POST['username'];
    $password = $_POST['password']; 
    $name = $_POST['name'];
    $email = $_POST['email'];
    $telephone = $_POST['telephone'];
    $address = $_POST['address'];

   
    $stmt = $conn->prepare("INSERT INTO admin (username, password, name, email_address, telephone_number, address) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $username, $password, $name, $email, $telephone, $address);

    
    if ($stmt->execute()) {
        echo "<script>alert('New Admin Added!!.'); window.location.href='../../index.php';</script>";
    } else {
        echo "<script>alert('Error: " . addslashes($stmt->error) . "'); window.location.href='../../admin-register.php';</script>";
    }


    $stmt->close();
}


$conn->close();
?>