<?php
include '../../database/dbcon.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];

    $sql = "DELETE FROM doctor_bookings WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Appointment deleted successfully'); window.location.href='../../admin-dashboard.php';</script>";
    } else {
        echo "<script>alert('Error: " . addslashes($stmt->error) . "'); window.location.href='../../admin-dashboard.php';</script>";
    }

    $conn->close();
    header("Location: ../../../admin-dashboard.php");
}
?>