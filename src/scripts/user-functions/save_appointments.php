<?php
session_start();
require '../../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include '../../database/dbcon.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $username = isset($_SESSION['username']) ? $_SESSION['username'] : 'not registered user';
    $name = $_POST['name'];
    $pet = $_POST['pet'];
    $email = $_POST['email'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $phone = $_POST['number'];
    $doctor = $_POST['doctor'];
    $location = $_POST['location'];

    $query = "INSERT INTO doctor_bookings (username, name, pet, email, date, time, phone, doctor, location) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssssssss", $username, $name, $pet, $email, $date, $time, $phone, $doctor, $location);

    if ($stmt->execute()) {

        $mail = new PHPMailer(true);

        try {
            
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'YOUR_EMAIL_ADDRESS'; //add your email address
            $mail->Password = 'YOUR_APP_PASSWORD'; // add your app password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('appointments@dogcare.com', 'Dog Care Appointments');
            $mail->addAddress($email, $name);

            $mail->isHTML(true);
            $mail->Subject = 'Appointment Confirmation';

            $mail->Body = "<html>
                            <head>
                                <style>
                                    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');
                                    
                                    body {
                                        font-family: 'Poppins', Arial, sans-serif;
                                        margin: 0;
                                        padding: 0;
                                        background-color: #f0f4f8;
                                        line-height: 1.6;
                                        color: #2c3e50;
                                    }
                                    .email-container {
                                        max-width: 600px;
                                        margin: 40px auto;
                                        background-color: #ffffff;
                                        border-radius: 12px;
                                        box-shadow: 0 15px 35px rgba(50, 50, 93, 0.1), 0 5px 15px rgba(0, 0, 0, 0.07);
                                        overflow: hidden;
                                    }
                                    .email-header {
                                        background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
                                        color: white;
                                        text-align: center;
                                        padding: 30px 20px;
                                        position: relative;
                                    }
                                    .email-header::before {
                                        content: '';
                                        position: absolute;
                                        bottom: -20px;
                                        left: 0;
                                        width: 100%;
                                        height: 40px;
                                        background: linear-gradient(to right, transparent, rgba(255,255,255,0.3), transparent);
                                    }
                                    .email-title {
                                        font-size: 28px;
                                        font-weight: 600;
                                        margin: 0;
                                        letter-spacing: -0.5px;
                                    }
                                    .email-content {
                                        padding: 40px 30px;
                                        background-color: #ffffff;
                                    }
                                    .welcome-text {
                                        font-size: 18px;
                                        color: #34495e;
                                        margin-bottom: 25px;
                                    }
                                    .appointment-details {
                                        background-color: #f7f9fc;
                                        border-left: 4px solid #3498db;
                                        padding: 20px;
                                        margin: 25px 0;
                                        border-radius: 4px;
                                    }
                                    .appointment-details p {
                                        margin: 10px 0;
                                        color: #2c3e50;
                                    }
                                    .highlight {
                                        color: #e74c3c;
                                        font-weight: 600;
                                        display: block;
                                        margin-top: 20px;
                                        text-align: center;
                                        background-color: #fff3f0;
                                        padding: 15px;
                                        border-radius: 6px;
                                    }
                                    .email-footer {
                                        background-color: #f1f4f8;
                                        text-align: center;
                                        padding: 20px;
                                        font-size: 14px;
                                        color: #7f8c8d;
                                    }
                                    @media only screen and (max-width: 600px) {
                                        .email-container {
                                            margin: 20px 10px;
                                        }
                                        .email-header {
                                            padding: 20px 10px;
                                        }
                                        .email-content {
                                            padding: 30px 15px;
                                        }
                                    }
                                </style>
                            </head>
                            <body>
                                <div class='email-container'>
                                    <div class='email-header'>
                                        <h1 class='email-title'>Appointment Confirmation</h1>
                                    </div>
                                    <div class='email-content'>
                                        <p class='welcome-text'>Dear $name,</p>
                                        <p class='welcome-text'>Your appointment has been successfully created.</p>
                                        
                                        <div class='appointment-details'>
                                            <p><strong>Pet Name:</strong> $pet</p>
                                            <p><strong>Appointment Date:</strong> $date</p>
                                            <p><strong>Appointment Time:</strong> $time</p>
                                            <p><strong>Phone Number:</strong> $phone</p>
                                            <p><strong>Doctor:</strong> $doctor</p>
                                            <p><strong>Location:</strong> $location</p>
                                        </div>
                                        
                                        <p class='highlight'>IMPORTANT: Please arrive on time. Cancel or reschedule at least 24 hours before your appointment.</p>
                                        
                                        <p class='welcome-text'>Thank you for choosing Dog Care!</p>
                                    </div>
                                    <div class='email-footer'>
                                        &copy; 2025 Dog Care. All rights reserved.
                                    </div>
                                </div>
                            </body>
                          </html>";

            $mail->AltBody = "Dear $name,\n\nYour appointment has been successfully created.\n\nAppointment Summary:\n- Pet Name: $pet\n- Date: $date\n- Time: $time\n- Phone: $phone\n- Doctor: $doctor\n- Location: $location\n\nPlease make sure to arrive on time. If you need to cancel or reschedule, contact us at least 24 hours before your appointment.\n\nThank you for choosing Dog Care!";

            $mail->send();
            echo "<script>alert('Booking successfully created! Confirmation email sent.'); window.location.href='../../../user-dashboard.php';</script>";
        } catch (Exception $e) {
            echo "<script>alert('Booking successfully created, but email could not be sent.'); window.location.href='../../../user-dashboard.php';</script>";
        }
    } else {
        echo "<script>alert('Error creating booking.');</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
