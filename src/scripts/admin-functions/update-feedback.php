<?php
include '../../database/dbcon.php';

// Update feedback data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    $sql = "UPDATE feedback SET name=?, email=?, message=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $name, $email, $message, $id);

    if ($stmt->execute()) {
        echo "Feedback updated successfully.";
    } else {
        echo "Error updating feedback: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();


header("Location: ../../../admin-dashboard.php");
exit();
?>