<?php

include '../../database/dbcon.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];

    $sql = "DELETE FROM feedback WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<script>alert('Feedback deleted successfully'); window.location.href='../../admin-dashboard.php';</script>";
    } else {
        echo "<script>alert('Error: " . addslashes($stmt->error) . "'); window.location.href='../../admin-dashboard.php';</script>";
    }

    $stmt->close();
}

$conn->close();

header("Location: ../../../admin-dashboard.php");
exit();
?>