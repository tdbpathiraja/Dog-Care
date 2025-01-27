<?php
include '../../database/dbcon.php';

if (isset($_GET['year'])) {
    $year = intval($_GET['year']);
    $bookingsCount = array_fill(0, 12, 0);

    // Fetch bookings count by month
    $sql = "SELECT MONTH(date) as month, COUNT(*) as count FROM doctor_bookings WHERE YEAR(date) = ? GROUP BY MONTH(date)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $year);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $bookingsCount[$row['month'] - 1] = $row['count'];
    }

    echo json_encode($bookingsCount);
}

$conn->close();
?>