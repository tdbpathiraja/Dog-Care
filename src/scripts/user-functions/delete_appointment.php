<?php
session_start();
include '../../database/dbcon.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $appointmentId = $_POST['appointment_id'];

    $query = "DELETE FROM doctor_bookings WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $appointmentId);
    $stmt->execute();

    header("Location: ../../../user-dashboard.php");
    exit();
}
?>