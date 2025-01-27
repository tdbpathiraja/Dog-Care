<?php
session_start();
include '../../database/dbcon.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];

    $stmt = $conn->prepare("SELECT profile_photo FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && $user['profile_photo']) {
        $existingPhotoPath = $user['profile_photo'];
        if (file_exists($existingPhotoPath)) {
            unlink($existingPhotoPath);
        }

        $stmt = $conn->prepare("UPDATE users SET profile_photo = NULL WHERE username = ?");
        $stmt->bind_param("s", $username);
        if ($stmt->execute()) {
            echo "<script>alert('Profile photo deleted successfully.'); window.location.href='../../../user-dashboard.php';</script>";
        } else {
            echo "<script>alert('Error clearing profile photo in database.'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('No profile photo found to delete.'); window.history.back();</script>";
    }
}
?>