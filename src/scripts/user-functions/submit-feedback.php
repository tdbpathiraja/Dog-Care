<?php
session_start();
include '../../database/dbcon.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    if (!isset($_SESSION['username'])) {
        echo "<script>alert('User  not logged in.'); window.location.href='../../../login.php';</script>";
        exit();
    }

    $userName = $_SESSION['username'];

    $userQuery = "SELECT * FROM users WHERE username = ?";
    $userStmt = $conn->prepare($userQuery);
    $userStmt->bind_param("s", $userName);
    $userStmt->execute();
    $userResult = $userStmt->get_result();
    $user = $userResult->fetch_assoc();

    if (!$user) {
        echo "<script>alert('User  not found.'); window.location.href='../../../login.php';</script>";
        exit();
    }

    $profileImg = $user['profile_photo'];

    $name = $user['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];
    $starCount = (int)$_POST['star'];
    $consultDoctor = $_POST['doctor'];

    // Insert feedback into the feedback table
    $feedbackQuery = "INSERT INTO feedback (name, email, message, star_count, consult_doctor, profile_img) VALUES (?, ?, ?, ?, ?, ?)";
    $feedbackStmt = $conn->prepare($feedbackQuery);
    $feedbackStmt->bind_param("ssssss", $name, $email, $message, $starCount, $consultDoctor, $profileImg);

    if ($feedbackStmt->execute()) {
        // Fetch current points for the selected doctor
        $pointsQuery = "SELECT doc_points FROM doctors WHERE doctor_username = ?";
        $pointsStmt = $conn->prepare($pointsQuery);
        $pointsStmt->bind_param("s", $consultDoctor);
        $pointsStmt->execute();
        $pointsResult = $pointsStmt->get_result();
        $doctor = $pointsResult->fetch_assoc();

        if ($doctor) {
            $currentPoints = (int)$doctor['doc_points'];
            $newPoints = $currentPoints + $starCount;

            // Update the doctor's points in the doctors table
            $updatePointsQuery = "UPDATE doctors SET doc_points = ? WHERE doctor_username = ?";
            $updatePointsStmt = $conn->prepare($updatePointsQuery);
            $updatePointsStmt->bind_param("is", $newPoints, $consultDoctor);

            if (!$updatePointsStmt->execute()) {
                echo "<script>alert('Error updating doctor points: " . $updatePointsStmt->error . "');</script>";
            }

            $updatePointsStmt->close();
        } else {
            echo "<script>alert('Doctor not found.');</script>";
        }

        echo "<script>alert('Feedback submitted successfully!'); window.location.href='../../../user-dashboard.php';</script>";
        exit();
    } else {
        echo "<script>alert('Error: " . $feedbackStmt->error . "');</script>";
    }

    $feedbackStmt->close();
    $userStmt->close();
}

$conn->close();
?>