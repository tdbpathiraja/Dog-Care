<?php
session_start();
include '../../database/dbcon.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $doctor = $_POST['doctor'];
    $date = $_POST['date'];
    $time = $_POST['time'];

    $query = "SELECT * FROM doctor_bookings WHERE doctor = ? AND date = ? AND time = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sss", $doctor, $date, $time);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo json_encode(['available' => false]);
    } else {
        echo json_encode(['available' => true]);
    }

    $stmt->close();
    $conn->close();
}
?>