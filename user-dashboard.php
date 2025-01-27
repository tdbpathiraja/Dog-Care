<?php
session_start();

include 'src/database/dbcon.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$current_page = basename($_SERVER['PHP_SELF']);
$userName = isset($_SESSION['username']) ? $_SESSION['username'] : null;

$query = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $userName);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    header("Location: login.php");
    exit();
}

$profilePhoto = $user['profile_photo'] ? $user['profile_photo'] : 'src/img/no_avatar.png';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dog Care | My Account</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="src/styles/user-account.css">
</head>
<body>

<header>
    <!-- Navigation Bar -->
    <nav id="navbar">
        <i class="fa-solid fa-dog" id="nav_logo">Dog Care</i>

        <ul id="nav_list">
            <li class="nav-item">
                <a href="index.php#home">Home</a>
            </li>
            <li class="nav-item">
                <a href="index.php#companyabout">About Us</a>
            </li>
            <li class="nav-item">
                <a href="index.php#testimonials">Testimonials</a>
            </li>
            <li class="nav-item">
                <a href="feedback.php">Feedback</a>
            </li>
        </ul>

        <?php if ($userName): ?>
            <?php if ($current_page === 'user-dashboard.php'): ?>
                <form action="src/scripts/user-functions/logout.php" method="post">
                    <button type="submit" class="btn-default">Logout</button>
                </form>
            <?php else: ?>
                <a href="user-dashboard.php">
                    <button class="btn-default">
                        <?php echo htmlspecialchars($userName); ?>
                    </button>
                </a>
            <?php endif; ?>
        <?php else: ?>
            <a href="login.php">
                <button class="btn-default">
                    Log In
                </button>
            </a>
        <?php endif; ?>
    </nav>
</header>

<div class="container">
    <!-- Profile Header -->
    <div class="profile-header">
        <img src="<?php echo htmlspecialchars($profilePhoto); ?>" alt="Profile Photo" class="profile-photo" id="profilePhoto">
        <div class="profile-info">
            <h1><?php echo htmlspecialchars($user['name']); ?></h1>
            <p><?php echo htmlspecialchars($user['email_address']); ?></p>
            <div class="profile-actions">
                <button class="btn" onclick="openPopup('uploadPhotoPopup')">
                    <i class="fas fa-upload"></i> Upload Photo
                </button>
                <button class="btn" onclick="openPopup('deletePhotoPopup')">
                    <i class="fas fa-trash-alt"></i> Delete Photo
                </button>
            </div>
        </div>
    </div>

    <!-- Account Settings Section -->
    <div class="section">
        <h2>Account Settings</h2>
        <div class="profile-actions">
            <button class="btn" onclick="openPopup('updateNamePopup')">
                <i class="fas fa-user-edit"></i> Update Name
            </button>
            <button class="btn" onclick="openPopup('updateEmailPopup')">
                <i class="fas fa-envelope"></i> Update Email
            </button>
            <button class="btn" onclick="openPopup('changePasswordPopup')">
                <i class="fas fa-lock"></i> Change Password
            </button>
        </div>
    </div>

    <!-- Popup for Upload Photo -->
    <div id="uploadPhotoPopup" class="popup">
        <div class="popup-content">
            <button class="popup-close" onclick="closePopup('uploadPhotoPopup')">&times;</button>
            <h2>Upload Profile Photo</h2>
            <form action="src/scripts/user-functions/upload_photo.php" method="post" enctype="multipart/form-data">
                <div class="file-upload-container">
                    <input type="file" id="fileUpload" name="profile_photo" accept="image/*" style="display:none;" required>
                    <label for="fileUpload" class="btn" style="width:100%; margin-top:20px;">
                        <i class="fas fa-cloud-upload-alt"></i> Choose File
                    </label>
                    <p>or drag and drop files here</p>
                </div>
                <input type="hidden" name="username" value="<?php echo htmlspecialchars($userName); ?>">
                <button type="submit" class="btn">Upload</button>
            </form>
        </div>
    </div>

    <!-- Popup for Delete Photo -->
    <div id="deletePhotoPopup" class="popup">
        <div class="popup-content">
            <button class="popup-close" onclick="closePopup('deletePhotoPopup')">&times;</button>
            <h2>Delete Profile Photo</h2>
            <p>Are you sure you want to delete your profile photo?</p>
            <form action="src/scripts/user-functions/delete_photo.php" method="post">
                <input type="hidden" name="username" value="<?php echo htmlspecialchars($userName); ?>">
                <button type="submit" class="btn" style="background-color: #ff4d4d;">
                    <i class="fas fa-trash-alt"></i> Confirm Delete
                </button>
                <button type="button" class="btn" onclick="closePopup('deletePhotoPopup')">Cancel</button>
            </form>
        </div>
    </div>

    <!-- Popup for Update Name -->
    <div id="updateNamePopup" class="popup">
        <div class="popup-content">
            <button class="popup-close" onclick="closePopup('updateNamePopup')">&times;</button>
            <h2>Update Name</h2>
            <form action="src/scripts/user-functions/update_name.php" method="post">
                <div class="popup-form">
                    <input type="text" name="new_name" placeholder="Enter New Name" required>
                    <input type="hidden" name="username" value="<?php echo htmlspecialchars($userName); ?>">
                    <button type="submit" class="btn">
                        <i class="fas fa-save"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Popup for Update Email -->
    <div id="updateEmailPopup" class="popup">
        <div class="popup-content">
            <button class="popup-close" onclick="closePopup('updateEmailPopup')">&times;</button>
            <h2>Update Email</h2>
            <div class="popup-form">
                <form action="src/scripts/user-functions/update_email.php" method="post">
                    <input type="email" name="new_email" placeholder="Enter New Email" required>
                    <input type="hidden" name="username" value="<?php echo htmlspecialchars($userName); ?>">
                    <button type="submit" class="btn">
                        <i class="fas fa-save"></i> Save Changes
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Popup for Change Password -->
    <div id="changePasswordPopup" class="popup">
        <div class="popup-content">
            <button class="popup-close" onclick="closePopup('changePasswordPopup')">&times;</button>
            <h2>Change Password</h2>
            <div class="popup-form">
                <form action="src/scripts/user-functions/change_password.php" method="post">
                    <input type="password" name="current_password" placeholder="Current Password" required>
                    <input type="password" name="new_password" placeholder="New Password" required>
                    <input type="password" name="confirm_password" placeholder="Confirm New Password" required>
                    <input type="hidden" name="username" value="<?php echo htmlspecialchars($userName); ?>">
                    <button type="submit" class="btn">
                        <i class="fas fa-lock"></i> Update Password
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Appointment Section -->
    <div class="section">
        <h2>Book an Appointment</h2>
        <div class="appointment-card">
            <i class="fas fa-calendar-plus appointment-card-icon"></i>
            <div class="appointment-card-content">
                <h3>Schedule a Veterinary Appointment</h3>
                <p>Book a consultation for your pet with our experienced veterinarians.</p>
                <button class="btn" onclick="bookAppointment()">Book Appointment</button>
            </div>
        </div>
    </div>

    <script>
        function bookAppointment() {
            window.open('create-appointment.php');
        }
    </script>

    <!-- Appointments Table -->
    <div class="section">
    <h2>Upcoming Appointments</h2>
    <table class="appointments-table">
        <thead>
            <tr>
                <th>Pet</th>
                <th>Date</th>
                <th>Time</th>
                <th>Phone Number</th>
                <th>Doctor</th>
                <th>Location</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            
            $query = "
                SELECT db.*, d.doctor_name 
                FROM doctor_bookings db 
                JOIN doctors d ON db.doctor = d.doctor_username 
                WHERE db.username = ?
            ";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("s", $userName);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while ($appointment = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($appointment['pet']) . "</td>";
                    echo "<td>" . htmlspecialchars($appointment['date']) . "</td>";
                    echo "<td>" . htmlspecialchars($appointment['time']) . "</td>";
                    echo "<td>" . htmlspecialchars($appointment['phone']) . "</td>";
                    echo "<td>" . htmlspecialchars($appointment['doctor_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($appointment['location']) . "</td>";
                    echo "<td><span class='status-badge status-" . strtolower($appointment['status']) . "'>" . htmlspecialchars($appointment['status']) . "</span></td>";
                    echo "<td class='action-icons'>";
                    echo "<i class='fas fa-edit' title='Edit' onclick=\"openEditPopup(" . htmlspecialchars(json_encode($appointment)) . ")\"></i>";
                    echo "<i class='fas fa-trash-alt' title='Cancel' onclick=\"openDeletePopup(" . htmlspecialchars($appointment['id']) . ")\"></i>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='8'>No upcoming appointments found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

    <!-- Popup for Edit Appointment -->
    <div id="editAppointmentPopup" class="popup">
        <div class="popup-content">
            <button class="popup-close" onclick="closePopup('editAppointmentPopup')">&times;</button>
            <h2>Edit Appointment</h2>
            <form id="editAppointmentForm" action="src/scripts/user-functions/edit_appointment.php" method="post">
                <input type="hidden" name="appointment_id" id="appointment_id">
                <input type="text" name="pet" id="edit_pet" placeholder="Pet Name" required>
                <input type="date" name="date" id="edit_date" required>
                <input type="time" name="time" id="edit_time" required>
                <input type="text" name="phone" id="edit_phone" placeholder="Phone Number" required>
                <input type="text" name="doctor" id="edit_doctor" placeholder="Doctor" required>
                <input type="text" name="location" id="edit_location" placeholder="Location" required>
                <button type="submit" class="btn">Save Changes</button>
            </form>
        </div>
    </div>

    <!-- Popup for Delete Appointment -->
    <div id="deleteAppointmentPopup" class="popup">
        <div class="popup-content">
            <button class="popup-close" onclick="closePopup('deleteAppointmentPopup')">&times;</button>
            <h2>Delete Appointment</h2>
            <p>Are you sure you want to delete this appointment?</p>
            <form id="deleteAppointmentForm" action="src/scripts/user-functions/delete_appointment.php" method="post">
                <input type="hidden" name="appointment_id" id="delete_appointment_id">
                <button type="submit" class="btn" style="background-color: #ff4d4d;">
                    <i class="fas fa-trash-alt"></i> Confirm Delete
                </button>
                <button type="button" class="btn" onclick="closePopup('deleteAppointmentPopup')">Cancel</button>
            </form>
        </div>
    </div>

    <!-- Javascript Functions -->
    <script src="src/javascript/user-appointments-update.js"></script>
    <script src="src/javascript/user-settings-popups.js"></script>

</body>
</html>