<?php
include '../../database/dbcon.php';

if (isset($_POST['location'])) {
    $location = $_POST['location'];
    $sql = "SELECT doctor_name AS name, doctor_username AS username, doc_points AS points FROM doctors WHERE doctor_location = ? ORDER BY doc_points DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $location);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $doctors = [];
    while ($row = $result->fetch_assoc()) {
        $doctors[] = $row;
    }
    
    echo json_encode($doctors);
}

$conn->close();
?>