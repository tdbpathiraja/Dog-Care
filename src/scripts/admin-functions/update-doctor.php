<?php
include '../../database/dbcon.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $doctor_name = $_POST['doctor_name'];
    $doctor_username = $_POST['doctor_username'];
    $doctor_email = $_POST['doctor_email'];
    $doctor_location = $_POST['doctor_location'];
    $doctor_contact_number = $_POST['doctor_contact_number'];

    $sql = "UPDATE doctors SET doctor_name=?, doctor_username=?, doctor_email=?, doctor_location=?, doctor_contact_number=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $doctor_name, $doctor_username, $doctor_email, $doctor_location, $doctor_contact_number, $id);
    
    if ($stmt->execute()) {
        echo "Doctor updated successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
    header("Location: ../../../admin-dashboard.php");
}
?>