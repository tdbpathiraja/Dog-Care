<?php
session_start();

include 'src/database/dbcon.php';

if (!isset($_SESSION['username'])) {
    $isLoggedIn = false;
} else {
    $isLoggedIn = true;
    $userName = $_SESSION['username'];

    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $userName);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Form</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="src/styles/style.css">
    <style>
        body {
            background-color: var(--color-primary-1);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }  
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="doc-booking-container">
        
            <h2 class="doc-booking-title">Book Veterinary Appointment</h2>
            <form class="doc-booking-form" id="bookingForm" action="src/scripts/user-functions/save_appointments.php" method="POST">
                
                <div class="doc-booking-input-group">
                    <label for="name" class="doc-booking-label">Name</label>
                    <?php if ($isLoggedIn && isset($user['name'])): ?>
                        <input type="text" id="name" name="name" class="doc-booking-input" value="<?php echo htmlspecialchars($user['name']); ?>" readonly>
                    <?php else: ?>
                        <input type="text" id="name" name="name" class="doc-booking-input" placeholder="Enter your name" required>
                    <?php endif; ?>
                </div>


                <div class="doc-booking-input-group">
                    <label for="pet" class="doc-booking-label">Pet</label>
                    <input type="text" id="pet" name="pet" class="doc-booking-input" required>
                </div>

                <div class="doc-booking-input-group">
                    <label for="contact" class="doc-booking-label">Email Address</label>
                    <input type="email" id="email" name="email" class="doc-booking-input" required placeholder="Enter your email for contact you">
                </div>

                <div class="doc-booking-input-group">
                    <label for="location" class="doc-booking-label">Location</label>
                    <select id="location" name="location" class="doc-booking-select" required>
                        <option value="">Select Location</option>
                        <?php
                        // Fetch unique locations from the doctors table
                        $sql = "SELECT DISTINCT doctor_location FROM doctors";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo '<option value="' . htmlspecialchars($row['doctor_location']) . '">' . htmlspecialchars($row['doctor_location']) . '</option>';
                            }
                        } else {
                            echo '<option value="">No locations available</option>';
                        }

                        $conn->close();
                        ?>
                    </select>
                </div>

                <div class="doc-booking-input-group">
                    <label for="doctor" class="doc-booking-label">Doctor</label>
                    <select id="doctor" name="doctor" class="doc-booking-select" required disabled>
                        <option value="">Select Doctor</option>
                    </select>
                </div>

                <div class="doc-booking-input-group">
                    <label for="contact" class="doc-booking-label">Contact Number</label>
                    <input type="tel" id="number" name="number" class="doc-booking-input" required pattern="[0-9]{10}" placeholder="10-digit phone number">
                </div>

                <div class="doc-booking-input-group">
                    <label for="date" class="doc-booking-label">Appointment Date</label>
                    <div class="doc-booking-datetime-group">
                        <input type="date" id="date" name="date" class="doc-booking-input" required>
                        <input type="time" id="time" name="time" class="doc-booking-input" required>
                        <button type="button" class="doc-booking-availability-btn">Check Availability</button>
                    </div>
                </div>

                <button type="submit" class="doc-booking-submit-btn">Book Appointment</button>
            </form>
        
    </div>


    <!-- Realtime data validation and preview js function -->
    <script>
        $(document).ready(function() {
    $('#doctor').prop('disabled', true);
    let isTimeSlotAvailable = false;

    $('#location').change(function() {
        var location = $(this).val();
        if (location) {
            $('#doctor').prop('disabled', false);
            
            $.ajax({
                url : 'src/scripts/user-functions/fetch_doctors.php',
                type: 'POST',
                data: {location: location},
                dataType: 'json',
                success: function(data) {
                    $('#doctor').empty().append('<option value="">Select Doctor</option>');
                    $.each(data, function(index, doctor) {
                        $('#doctor').append('<option value="' + doctor.username + '">' + doctor.name + ' (' + doctor.points + ' Rating)</option>');
                    });
                }
            });
        } else {
            $('#doctor').empty().append('<option value="">Select Doctor</option>').prop('disabled', true);
        }
    });

    $('.doc-booking-availability-btn').click(function() {
        var doctor = $('#doctor').val();
        var date = $('#date').val();
        var time = $('#time').val();

        if (doctor && date && time) {
            $.ajax({
                url: 'src/scripts/user-functions/booking_availability_check.php',
                type: 'POST',
                data: {doctor: doctor, date: date, time: time},
                dataType: 'json',
                success: function(response) {
                    if (response.available) {
                        isTimeSlotAvailable = true;
                        alert('Time slot is available!');
                        $('.doc-booking-submit-btn').prop('disabled', false);
                    } else {
                        isTimeSlotAvailable = false;
                        alert('Time slot is not available. Please choose another time.');
                        $('#time').val('');
                        $('.doc-booking-submit-btn').prop('disabled', true);
                    }
                }
            });
        } else {
            alert('Please select a doctor, date, and time before checking availability.');
        }
    });

    $('.doc-booking-submit-btn').prop('disabled', true);
});
    </script>
</body>
</html>