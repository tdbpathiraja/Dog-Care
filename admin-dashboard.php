<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dog Care Admin</title>
    <link rel="stylesheet" href="src/styles/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="admin-dashboard">
        <!-- Sidebar -->
        <aside class="admin-sidebar">
            <div class="admin-sidebar-logo">Dog Care Admin</div>
            <ul class="admin-sidebar-menu">
                <li class="admin-sidebar-item">
                    <a href="#dashboard" class="admin-sidebar-link" onclick="showSection('dashboard')">Dashboard</a>
                </li>
                <li class="admin-sidebar-item">
                    <a href="#manage-feedbacks" class="admin-sidebar-link" onclick="showSection('manage-feedbacks')">Manage Feedbacks</a>
                </li>
                <li class="admin-sidebar-item">
                    <a href="#manage-doctors" class="admin-sidebar-link" onclick="showSection('manage-doctors')">Manage Doctors</a>
                </li>
                <li class="admin-sidebar-item">
                    <a href="#manage-users" class="admin-sidebar-link" onclick="showSection('manage-users')">Manage Users</a>
                </li>
                <li class="admin-sidebar-item">
                    <a href="#manage-appointments" class="admin-sidebar-link" onclick="showSection('manage-appointments')">Manage Appointments</a>
                </li>
                <li class="admin-sidebar-item">
                    <a href="#send-message" class="admin-sidebar-link" onclick="showSection('send-message')">Send Message</a>
                </li>
            </ul>
        </aside>

        <!-- Content Area -->
        <main class="admin-content">
            <!-- Dashboard Section -->
            <section id="dashboard" class="admin-section active">
                <div class="admin-content-header">
                    <h1>Dashboard</h1>
                </div>
                <div class="admin-cards">
                    <div class="admin-card total-appointments">
                        <div class="admin-card-icon">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div class="admin-card-content">
                            <h2>Total Appointments</h2>
                            <p id="total-appointments">0</p>
                        </div>
                    </div>
                    <div class="admin-card total-doctors">
                        <div class="admin-card-icon">
                            <i class="fas fa-user-md"></i>
                        </div>
                        <div class="admin-card-content">
                            <h2>Total Doctors</h2>
                            <p id="total-doctors">0</p>
                        </div>
                    </div>
                    <div class="admin-card total-users">
                        <div class="admin-card-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="admin-card-content">
                            <h2>Total Users</h2>
                            <p id="total-users">0</p>
                        </div>
                    </div>
                    <div class="admin-card total-feedbacks">
                        <div class="admin-card-icon">
                            <i class="fas fa-comments"></i>
                        </div>
                        <div class="admin-card-content">
                            <h2>Total Feedbacks</h2>
                            <p id="total-feedbacks">0</p>
                        </div>
                    </div>
                </div>

                <div class="admin-chart">
                    <h2>Bookings by Month</h2>
                    <label for="year-select">Select Year:</label>
                    <select id="year-select" onchange="fetchBookingsByYear()">
                        <option value="">Select Year</option>
                        <?php
                        $currentYear = date("Y");
                        for ($year = 2025; $year <= $currentYear; $year++) {
                            $selected = ($year == 2025) ? 'selected' : '';
                            echo "<option value='$year' $selected>$year</option>";
                        }
                        ?>
                    </select>
                    <canvas id="bookingsChart"></canvas>
                </div>

                <?php
                include 'src/database/dbcon.php';

                $totalAppointments = $conn->query("SELECT COUNT(*) as count FROM doctor_bookings")->fetch_assoc()['count'];
                $totalDoctors = $conn->query("SELECT COUNT(*) as count FROM doctors")->fetch_assoc()['count'];
                $totalUsers = $conn->query("SELECT COUNT(*) as count FROM users")->fetch_assoc()['count'];
                $totalFeedbacks = $conn->query("SELECT COUNT(*) as count FROM feedback")->fetch_assoc()['count'];

                $conn->close();
                ?>

                <script>
                    const ctx = document.getElementById('bookingsChart').getContext('2d');
                    let bookingsChart;

                    function fetchBookingsByYear() {
                        const year = document.getElementById('year-select').value;
                        if (year) {
                            fetch(`src/scripts/admin-functions/booking-chart.php?year=${year}`)
                                .then(response => response.json())
                                .then(data => {
                                    updateChart(data);
                                })
                                .catch(error => console.error('Error fetching data:', error));
                        }
                    }

                    function updateChart(data) {
                        const months = [
                            'January', 'February', 'March', 'April', 'May', 'June',
                            'July', 'August', 'September', 'October', 'November', 'December'
                        ];

                        const bookingsCount = months.map((_, index) => data[index] || 0);

                        if (bookingsChart) {
                            bookingsChart.destroy();
                        }

                        bookingsChart = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: months,
                                datasets: [{
                                    label: 'Bookings',
                                    data: bookingsCount,
                                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                    borderColor: 'rgba(75, 192, 192, 1)',
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        });
                    }

                    window.onload = function() {
                        document.getElementById('year-select').value = '2025'; 
                        fetchBookingsByYear(); 
                    };
                </script>

                <script>
                    document.getElementById('total-appointments').innerText = '<?php echo $totalAppointments; ?>';
                    document.getElementById('total-doctors').innerText = '<?php echo $totalDoctors; ?>';
                    document.getElementById('total-users').innerText = '<?php echo $totalUsers; ?>';
                    document.getElementById('total-feedbacks').innerText = '<?php echo $totalFeedbacks; ?>';
                </script>
            </section>

            <!-- Manage Feedbacks Section -->
            <section id="manage-feedbacks" class="admin-section" style="display:none;">
                <div class="admin-content-header">
                    <h1>Manage Feedbacks</h1>
                </div>
                <div class="admin-panel">
                    <table id="feedback-table" style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr>
                                <th style="border: 1px solid var(--color-primary-3); padding: 10px;">ID</th>
                                <th style="border: 1px solid var(--color-primary-3); padding: 10px;">Name</th>
                                <th style="border: 1px solid var(--color-primary-3); padding: 10px;">Email</th>
                                <th style="border: 1px solid var(--color-primary-3); padding: 10px;">Message</th>
                                <th style="border: 1px solid var(--color-primary-3); padding: 10px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="feedback-list" class="admin-feedback-list">
                            <?php
                            include 'src/database/dbcon.php';

                            // Fetch feedback data
                            $sql = "SELECT id, name, email, message FROM feedback";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                // Output data of each row
                                while($row = $result->fetch_assoc()) {
                                    echo "<tr>
                                            <td style='border: 1px solid var(--color-primary-3); padding: 10px;'>{$row['id']}</td>
                                            <td style='border: 1px solid var(--color-primary-3); padding: 10px;'>{$row['name']}</td>
                                            <td style='border: 1px solid var(--color-primary-3); padding: 10px;'>{$row['email']}</td>
                                            <td style='border: 1px solid var(--color-primary-3); padding: 10px;'>{$row['message']}</td>
                                            <td style='border: 1px solid var(--color-primary-3); padding: 10px;'>
                                                <button class='admin-btn' onclick='openUpdateModal({$row['id']}, \"{$row['name']}\", \"{$row['email']}\", \"{$row['message']}\")'>Update</button>
                                                <form action='src/scripts/admin-functions/delete-feedback.php' method='POST' style='display:inline;'>
                                                    <input type='hidden' name='id' value='{$row['id']}'>
                                                    <button type='submit' class='admin-delete-btn'>Delete</button>
                                                </form>
                                            </td>
                                          </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='5' style='border: 1px solid var(--color-primary-3); padding: 10px; text-align: center;'>No feedback found</td></tr>";
                            }

                            $conn->close();
                            ?>
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- Update Feedback Modal -->
            <div id="updateModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background-color:rgba(0,0,0,0.5); z-index:1000; justify-content:center; align-items:center;">
                <div style="background-color:white; padding:20px; border-radius:5px; width:300px; margin:auto;">
                    <h2>Update Feedback</h2>
                    <form id="update-form" action="src/scripts/admin-functions/update-feedback.php" method="POST">
                        <input type="hidden" id="update-id" name="id">
                        <div>
                            <label for="update-name">Name</label>
                            <input type="text" id="update-name" name="name" required>
                        </div>
                        <div>
                            <label for="update-email">Email</label>
                            <input type="email" id="update-email" name="email" required>
                        </div>
                        <div>
                            <label for="update-message">Message</label>
                            <textarea id="update-message" name="message" required></textarea>
                        </div>
                        <button type="submit" class="admin-btn">Update</button>
                        <button type="button" class="admin-btn" onclick="closeUpdateModal()">Cancel</button>
                    </form>
                </div>
            </div>

            <!-- Doctors Manage Section -->
            <section id="manage-doctors" class="admin-section" style="display:none;">
                <div class="admin-content-header">
                    <h1>Manage Doctors</h1>
                    <button class="admin-btn" onclick="openAddDoctorModal()">Add Doctor</button>
                </div>
                <div class="admin-panel">
                    <table id="doctors-table" style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr>
                                <th style="border: 1px solid var(--color-primary-3); padding: 10px;">ID</th>
                                <th style="border: 1px solid var(--color-primary-3); padding: 10px;">Name</th>
                                <th style="border: 1px solid var(--color-primary-3); padding: 10px;">Username</th>
                                <th style="border: 1px solid var(--color-primary-3); padding: 10px;">Email</th>
                                <th style="border: 1px solid var(--color-primary-3); padding: 10px;">Location</th>
                                <th style="border: 1px solid var(--color-primary-3); padding: 10px;">Contact Number</th>
                                <th style="border: 1px solid var(--color-primary-3); padding: 10px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="doctors-list" class="admin-doctors-list">
                            <?php
                            include 'src/database/dbcon.php';

                            // Fetch doctor data
                            $sql = "SELECT id, doctor_name, doctor_username, doctor_email, doctor_location, doctor_contact_number FROM doctors";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                // Output data of each row
                                while($row = $result->fetch_assoc()) {
                                    echo "<tr>
                                            <td style='border: 1px solid var(--color-primary-3); padding: 10px;'>{$row['id']}</td>
                                            <td style='border: 1px solid var(--color-primary-3); padding: 10px;'>{$row['doctor_name']}</td>
                                            <td style='border: 1px solid var(--color-primary-3); padding: 10px;'>{$row['doctor_username']}</td>
                                            <td style='border: 1px solid var(--color-primary-3); padding: 10px;'>{$row['doctor_email']}</td>
                                            <td style='border: 1px solid var(--color-primary-3); padding: 10px;'>{$row['doctor_location']}</td>
                                            <td style='border: 1px solid var(--color-primary-3); padding: 10px;'>{$row['doctor_contact_number']}</td>
                                            <td style='border: 1px solid var(--color-primary-3); padding: 10px;'>
                                                <button class='admin-btn' onclick='openUpdateDoctorModal({$row['id']}, \"{$row['doctor_name']}\", \"{$row['doctor_username']}\", \"{$row['doctor_email']}\", \"{$row['doctor_location']}\", \"{$row['doctor_contact_number']}\")'>Update</button>
                                                <form action='src/scripts/admin-functions/delete-doctor.php' method='POST' style='display:inline;'>
                                                    <input type='hidden' name='id' value='{$row['id']}'>
                                                    <button type='submit' class='admin-delete-btn'>Delete</button>
                                                </form>
                                            </td>
                                          </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='7' style='border: 1px solid var(--color-primary-3); padding: 10px; text-align: center;'>No doctors found</td></tr>";
                            }

                            $conn->close();
                            ?>
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- Add Doctor Modal -->
            <div id="addDoctorModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background-color:rgba(0,0,0,0.5); z-index:1000; justify-content:center; align-items:center;">
                <div style="background-color:white; padding:20px; border-radius:5px; width:300px; margin:auto;">
                    <h2>Add Doctor</h2>
                    <form id="add-doctor-form" action="src/scripts/admin-functions/add-doctor.php" method="POST">
                        <div>
                            <label for="add-doctor-name">Name</label>
                            <input type="text" id="add-doctor-name" name="doctor_name" required>
                        </div>
                        <div>
                            <label for="add-doctor-username">Username</label>
                            <input type="text" id="add-doctor-username" name="doctor_username" required>
                        </div>
                        <div>
                            <label for="add-doctor-email">Email</label>
                            <input type="email" id="add-doctor-email" name="doctor_email" required>
                        </div>
                        <div>
                            <label for="add-doctor-location">Location</label>
                            <select id="add-doctor-location" name="doctor_location" required>
                                <option value="">Select Location</option>
                                <option value="Colombo">Colombo</option>
                                <option value="Kandy">Kandy</option>
                                <option value="Galle">Galle</option>
                                <option value="Jaffna">Jaffna</option>
                                <option value="Negombo">Negombo</option>
                                <option value="Anuradhapura">Anuradhapura</option>
                                <option value="Polonnaruwa">Polonnaruwa</option>
                                <option value="Ratnapura">Ratnapura</option>
                                <option value="Trincomalee">Trincomalee</option>
                                <option value="Matara">Matara</option>
                                <option value="Batticaloa">Batticaloa</option>
                                <option value="Badulla">Badulla</option>
                                <option value="Kurunegala">Kurunegala</option>
                                <option value="Hambantota">Hambantota</option>
                                <option value="Nuwara Eliya">Nuwara Eliya</option>
                                <option value="Chilaw">Chilaw</option>
                                <option value="Kalutara">Kalutara</option>
                                <option value="Puttalam">Puttalam</option>
                                <option value="Vavuniya">Vavuniya</option>
                                <option value="Mannar">Mannar</option>
                            </select>
                        </div>
                        <div>
                            <label for="add-doctor-contact">Contact Number</label>
                            <input type="text" id="add-doctor-contact" name="doctor_contact_number" required>
                        </div>
                        <button type="submit" class="admin-btn">Add Doctor</button>
                        <button type="button" class="admin-btn" onclick="closeAddDoctorModal()">Cancel</button>
                    </form>
                </div>
            </div>

            <!-- Update Doctor Modal -->
            <div id="updateDoctorModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background-color:rgba(0,0,0,0.5); z-index:1000; justify-content:center; align-items:center;">
                <div style="background-color:white; padding:20px; border-radius:5px; width:300px; margin:auto;">
                    <h2>Update Doctor</h2>
                    <form id="update-doctor-form" action="src/scripts/admin-functions/update-doctor.php" method="POST">
                        <input type="hidden" id="update-doctor-id" name="id">
                        <div>
                            <label for="update-doctor-name">Name</label>
                            <input type="text" id="update-doctor-name" name="doctor_name" required>
                        </div>
                        <div>
                            <label for="update-doctor-username">Username</label>
                            <input type="text" id="update-doctor-username" name="doctor_username" required>
                        </div>
                        <div>
                            <label for="update-doctor-email">Email</label>
                            <input type="email" id="update-doctor-email" name="doctor_email" required>
                        </div>
                        <div>
                            <label for="update-doctor-location">Location</label>
                            <select id="update-doctor-location" name="doctor_location" required>
                                <option value="">Select Location</option>
                                <option value="Colombo">Colombo</option>
                                <option value="Kandy">Kandy</option>
                                <option value="Galle">Galle</option>
                                <option value="Jaffna">Jaffna</option>
                                <option value="Negombo">Negombo</option>
                                <option value="Anuradhapura">Anuradhapura</option>
                                <option value="Polonnaruwa">Polonnaruwa</option>
                                <option value="Ratnapura">Ratnapura</option>
                                <option value="Trincomalee">Trincomalee</option>
                                <option value="Matara">Matara</option>
                                <option value="Batticaloa">Batticaloa</option>
                                <option value="Badulla">Badulla</option>
                                <option value="Kurunegala">Kurunegala</option>
                                <option value="Hambantota">Hambantota</option>
                                <option value="Nuwara Eliya">Nuwara Eliya</option>
                                <option value="Chilaw">Chilaw</option>
                                <option value="Kalutara">Kalutara</option>
                                <option value="Puttalam">Puttalam</option>
                                <option value="Vavuniya">Vavuniya</option>
                                <option value="Mannar">Mannar</option>
                            </select>
                        </div>
                        <div>
                            <label for="update-doctor-contact">Contact Number</label>
                            <input type="text" id="update-doctor-contact" name="doctor_contact_number" required>
                        </div>
                        <button type="submit" class="admin-btn">Update Doctor</button>
                        <button type="button" class="admin-btn" onclick="closeUpdateDoctorModal()">Cancel</button>
                    </form>
                </div>
            </div>

            <!-- Manage Users Section -->
            <section id="manage-users" class="admin-section" style="display:none;">
                <div class="admin-content-header">
                    <h1>Manage Users</h1>
                    <button class="admin-btn" onclick="openAddUserModal()">Add User</button>
                </div>
                <div class="admin-panel">
                    <table id="users-table" style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr>
                                <th style="border: 1px solid var(--color-primary-3); padding: 10px;">ID</th>
                                <th style="border: 1px solid var(--color-primary-3); padding: 10px;">Username</th>
                                <th style="border: 1px solid var(--color-primary-3); padding: 10px;">Name</th>
                                <th style="border: 1px solid var(--color-primary-3); padding: 10px;">Email</th>
                                <th style="border: 1px solid var(--color-primary-3); padding: 10px;">Telephone Number</th>
                                <th style="border: 1px solid var(--color-primary-3); padding: 10px;">Address</th>
                                <th style="border: 1px solid var(--color-primary-3); padding: 10px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="users-list" class="admin-users-list">
                            <?php
                            include 'src/database/dbcon.php';

                            // Fetch user data
                            $sql = "SELECT ID, username, name, email_address, telephone_number, address FROM users";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                // Output data of each row
                                while($row = $result->fetch_assoc()) {
                                    echo "<tr>
                                            <td style='border: 1px solid var(--color-primary-3); padding: 10px;'>{$row['ID']}</td>
                                            <td style='border: 1px solid var(--color-primary-3); padding: 10px;'>{$row['username']}</td>
                                            <td style='border: 1px solid var(--color-primary-3); padding: 10px;'>{$row['name']}</td>
                                            <td style='border: 1px solid var(--color-primary-3); padding: 10px;'>{$row['email_address']}</td>
                                            <td style='border: 1px solid var(--color-primary-3); padding: 10px;'>{$row['telephone_number']}</td>
                                            <td style='border: 1px solid var(--color-primary-3); padding: 10px;'>{$row['address']}</td>
                                            <td style='border: 1px solid var(--color-primary-3); padding: 10px;'>
                                                <button class='admin-btn' onclick='openUpdateUserModal({$row['ID']}, \"{$row['username']}\", \"{$row['name']}\", \"{$row['email_address']}\", \"{$row['telephone_number']}\", \"{$row['address']}\")'>Update</button>
                                                <form action='src/scripts/admin-functions/delete-user.php' method='POST' style='display:inline;'>
                                                    <input type='hidden' name='id' value='{$row['ID']}'>
                                                    <button type='submit' class='admin-delete-btn'>Delete</button>
                                                </form>
                                            </td>
                                          </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='7' style='border: 1px solid var(--color-primary-3); padding: 10px; text-align: center;'>No users found</td></tr>";
                            }

                            $conn->close();
                            ?>
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- Add User Modal -->
            <div id="addUserModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background-color:rgba(0,0,0,0.5); z-index:1000; justify-content:center; align-items:center;">
                <div style="background-color:white; padding:20px; border-radius:5px; width:300px; margin:auto;">
                    <h2>Add User</h2>
                    <form id="add-user-form" action="src/scripts/admin-functions/add-user.php" method="POST">
                        <div>
                            <label for="add-username">Username</label>
                            <input type="text" id="add-username" name="username" required>
                        </div>
                        <div>
                            <label for="add-password">Password</label>
                            <input type="password" id="add-password" name="password" required>
                        </div>
                        <div>
                            <label for="add-name">Name</label>
                            <input type="text" id="add-name" name="name" required>
                        </div>
                        <div>
                            <label for="add-email">Email</label>
                            <input type="email" id="add-email" name="email_address" required>
                        </div>
                        <div>
                            <label for="add-telephone">Telephone Number</label>
                            <input type="text" id="add-telephone" name="telephone_number">
                        </div>
                        <div>
                            <label for="add-address">Address</label>
                            <input type="text" id="add-address" name="address">
                        </div>
                        <button type="submit" class="admin-btn">Add User</button>
                        <button type="button" class="admin-btn" onclick="closeAddUserModal()">Cancel</button>
                    </form>
                </div>
            </div>

            <!-- Update User Modal -->
            <div id="updateUserModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background-color:rgba(0,0,0,0.5); z-index:1000; justify-content:center; align-items:center;">
                <div style="background-color:white; padding:20px; border-radius:5px; width:300px; margin:auto;">
                    <h2>Update User</h2>
                    <form id="update-user-form" action="src/scripts/admin-functions/update-user.php" method="POST">
                        <input type="hidden" id="update-user-id" name="id">
                        <div>
                            <label for="update-username">Username</label>
                            <input type="text" id="update-username" name="username" required>
                        </div>
                        <div>
                            <label for="update-name">Name</label>
                            <input type="text" id="update-name" name="name" required>
                        </div>
                        <div>
                            <label for="update-email">Email</label>
                            <input type="email" id="update-email" name="email_address" required>
                        </div>
                        <div>
                            <label for="update-telephone">Telephone Number</label>
                            <input type="text" id="update-telephone" name="telephone_number">
                        </div>
                        <div>
                            <label for="update-address">Address</label>
                            <input type="text" id="update-address" name="address">
                        </div>
                        <button type="submit" class="admin-btn">Update User</button>
                        <button type="button" class="admin-btn" onclick="closeUpdateUserModal()">Cancel</button>
                    </form>
                </div>
            </div>

            <!-- Manage Appointments Section -->
            <section id="manage-appointments" class="admin-section" style="display:none;">
                <h1>Manage Appointments</h1>
                <div class="admin-panel">
                    <table id="appointments-table" style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr>
                                <th style="border: 1px solid var(--color-primary-3); padding: 10px;">ID</th>
                                <th style="border: 1px solid var(--color-primary-3); padding: 10px;">Name</th>
                                <th style="border: 1px solid var(--color-primary-3); padding: 10px;">Pet</th>
                                <th style="border: 1px solid var(--color-primary-3); padding: 10px;">Date</th>
                                <th style="border: 1px solid var(--color-primary-3); padding: 10px;">Time</th>
                                <th style="border: 1px solid var(--color-primary-3); padding: 10px;">Phone</th>
                                <th style="border: 1px solid var(--color-primary-3); padding: 10px;">Doctor</th>
                                <th style="border: 1px solid var(--color-primary-3); padding: 10px;">Location</th>
                                <th style="border: 1px solid var(--color-primary-3); padding: 10px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="appointments-list" class="admin-feedback-list">
                            <?php
                            include 'src/database/dbcon.php';

                            // Fetch appointment data
                            $sql = "SELECT id, name, pet, date, time, phone, doctor, location FROM doctor_bookings";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                // Output data of each row
                                while($row = $result->fetch_assoc()) {
                                    echo "<tr>
                                            <td style='border: 1px solid var(--color-primary-3); padding: 10px;'>{$row['id']}</td>
                                            <td style='border: 1px solid var(--color-primary-3); padding: 10px;'>{$row['name']}</td>
                                            <td style='border: 1px solid var(--color-primary-3); padding: 10px;'>{$row['pet']}</td>
                                            <td style='border: 1px solid var(--color-primary-3); padding: 10px;'>{$row['date']}</td>
                                            <td style='border: 1px solid var(--color-primary-3); padding: 10px;'>{$row['time']}</td>
                                            <td style='border: 1px solid var(--color-primary-3); padding: 10px;'>{$row['phone']}</td>
                                            <td style='border: 1px solid var(--color-primary-3); padding: 10px;'>{$row['doctor']}</td>
                                            <td style='border: 1px solid var(--color-primary-3); padding: 10px;'>{$row['location']}
                                            <td style='border: 1px solid var(--color-primary-3); padding: 10px;'>
                                                <button class='admin-btn' onclick='openUpdateAppointmentModal({$row['id']}, \"{$row['name']}\", \"{$row['pet']}\", \"{$row['date']}\", \"{$row['time']}\", \"{$row['phone']}\", \"{$row['doctor']}\", \"{$row['location']}\")'>Update</button>
                                                <form action='src/scripts/admin-functions/delete-appointment.php' method='POST' style='display:inline;'>
                                                    <input type='hidden' name='id' value='{$row['id']}'>
                                                    <button type='submit' class='admin-delete-btn'>Delete</button>
                                                </form>
                                            </td>
                                          </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='9' style='border: 1px solid var(--color-primary-3); padding: 10px; text-align: center;'>No appointments found</td></tr>";
                            }

                            $conn->close();
                            ?>
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- Update Appointment Modal -->
            <div id="updateAppointmentModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background-color:rgba(0,0,0,0.5); z-index:1000; justify-content:center; align-items:center;">
                <div style="background-color:white; padding:20px; border-radius:5px; width:300px; margin:auto;">
                    <h2>Update Appointment</h2>
                    <form id="update-appointment-form" action="src/scripts/admin-functions/update-appointment.php" method="POST">
                        <input type="hidden" id="update-appointment-id" name="id">
                        <div>
                            <label for="update-appointment-name">Name</label>
                            <input type="text" id="update-appointment-name" name="name" required>
                        </div>
                        <div>
                            <label for="update-appointment-pet">Pet</label>
                            <input type="text" id="update-appointment-pet" name="pet" required>
                        </div>
                        <div>
                            <label for="update-appointment-date">Date</label>
                            <input type="date" id="update-appointment-date" name="date" required>
                        </div>
                        <div>
                            <label for="update-appointment-time">Time</label>
                            <input type="time" id="update-appointment-time" name="time" required>
                        </div>
                        <div>
                            <label for="update-appointment-phone">Phone</label>
                            <input type="text" id="update-appointment-phone" name="phone" required>
                        </div>
                        <div>
                            <label for="update-appointment-doctor">Doctor</label>
                            <input type="text" id="update-appointment-doctor" name="doctor" required>
                        </div>
                        <div>
                            <label for="update-appointment-location">Location</label>
                            <input type="text" id="update-appointment-location" name="location" required>
                        </div>
                        <button type="submit" class="admin-btn">Update Appointment</button>
                        <button type="button" class="admin-btn" onclick="closeUpdateAppointmentModal()">Cancel</button>
                    </form>
                </div>
            </div>
            
            <!-- Send Message Section -->
            <section id="send-message" class="admin-section" style="display:none;">
                <div class="admin-content-header">
                    <h1>Send Message</h1>
                </div>
                <div class="admin-panel">
                    <form id="send-message-form" action="src/scripts/admin-functions/send-message.php" method="POST">
                        <div>
                            <label for="booking-select">Select Booking</label>
                            <select id="booking-select" name="booking_id" required onchange="updateEmailField()">
                                <option value="">Select Booking</option>
                                <?php
                                include 'src/database/dbcon.php';

                                // Fetch booking data
                                $sql = "SELECT id, name, email FROM doctor_bookings";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    // Output data of each row
                                    while($row = $result->fetch_assoc()) {
                                        echo "<option value='{$row['id']}' data-email='{$row['email']}'>{$row['name']} (Booking ID: {$row['id']})</option>";
                                    }
                                } else {
                                    echo "<option value=''>No bookings found</option>";
                                }

                                $conn->close();
                                ?>
                            </select>
                        </div>
                        <input type="hidden" id="booking-email" name="email" value="">
                        <div>
                            <label for="message">Message</label>
                            <textarea id="message" name="message" required></textarea>
                        </div>
                        <button type="submit" class="admin-btn">Send Message</button>
                    </form>
                </div>
            </section>

            <script>
                function updateEmailField() {
                    const select = document.getElementById('booking-select');
                    const selectedOption = select.options[select.selectedIndex];
                    const emailField = document.getElementById('booking-email');
                    
                    emailField.value = selectedOption.getAttribute('data-email');
                }
            </script>

        </main>
    </div>

    <!-- Javascript Functions -->
    <script src="src/javascript/admin-menu.js"></script>
    <script src="src/javascript/admin-feedback-update.js"></script>
    <script src="src/javascript/admin-appointments-update.js"></script>
    <script src="src/javascript/admin-doctors-update.js"></script>
    <script src="src/javascript/admin-users-update.js"></script>
    <script src="src/javascript/admin-sendmessage.js"></script>

</body>
</html>