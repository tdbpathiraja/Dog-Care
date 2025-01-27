<?php
session_start();
include '../../database/dbcon.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $targetDir = "../../img/user-photos/";
    $imageName = basename($_FILES["profile_photo"]["name"]);
    $targetFile = $targetDir . $imageName;
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    $check = getimagesize($_FILES["profile_photo"]["tmp_name"]);
    if ($check === false) {
        echo "<script>alert('File is not an image.'); window.history.back();</script>";
        exit();
    }

    if ($_FILES["profile_photo"]["size"] > 5000000) {
        echo "<script>alert('Sorry, your file is too large.'); window.history.back();</script>";
        exit();
    }

    if (!in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])) {
        echo "<script>alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.'); window.history.back();</script>";
        exit();
    }

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
    }

    if (move_uploaded_file($_FILES["profile_photo"]["tmp_name"], $targetFile)) {

        $dbFilePath = "src/img/user-photos/" . $imageName;
        $stmt = $conn->prepare("UPDATE users SET profile_photo = ? WHERE username = ?");
        $stmt->bind_param("ss", $dbFilePath, $username);
        if ($stmt->execute()) {
            echo "<script>alert('Profile photo updated successfully.'); window.location.href='../../../user-dashboard.php';</script>";
        } else {
            echo "<script>alert('Error updating profile photo in database.'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Sorry, there was an error uploading your file.'); window.history.back();</script>";
    }
}
?>