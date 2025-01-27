<?php
session_start();
include '../../database/dbcon.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $appointmentId = $_POST['appointment_id'];
    $pet = $_POST['pet'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $phone = $_POST['phone'];
    $doctor = $_POST['doctor'];
    $location = $_POST['location'];

    $query = "UPDATE doctor_bookings SET pet = ?, date = ?, time = ?, phone = ?, doctor = ?, location = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssssi", $pet, $date, $time, $phone, $doctor, $location, $appointmentId);
    $stmt->execute();

    header("Location: ../../../user-dashboard.php");
    exit();
}
?>