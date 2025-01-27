<?php
include '../../database/dbcon.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $doctor_name = $_POST['doctor_name'];
    $doctor_username = $_POST['doctor_username'];
    $doctor_email = $_POST['doctor_email'];
    $doctor_location = $_POST['doctor_location'];
    $doctor_contact_number = $_POST['doctor_contact_number'];

    $sql = "INSERT INTO doctors (doctor_name, doctor_username, doctor_email, doctor_location, doctor_contact_number) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $doctor_name, $doctor_username, $doctor_email, $doctor_location, $doctor_contact_number);
    
    if ($stmt->execute()) {
        echo "New doctor added successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
    header("Location: ../../../admin-dashboard.php");
}
?>