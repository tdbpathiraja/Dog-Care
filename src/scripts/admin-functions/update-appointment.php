<?php
include '../../database/dbcon.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $pet = $_POST['pet'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $phone = $_POST['phone'];
    $doctor = $_POST['doctor'];
    $location = $_POST['location'];

    $sql = "UPDATE doctor_bookings SET name='$name', pet='$pet', date='$date', time='$time', phone='$phone', doctor='$doctor', location='$location' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Appointment updated successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
    header("Location: ../../../admin-dashboard.php");
}
?>