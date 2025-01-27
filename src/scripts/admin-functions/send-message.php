<?php
require '../../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $email_address = $_POST['email'];
    $message = $_POST['message'];

    
    $mail = new PHPMailer(true);

    try {
       
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true; 
        $mail->Username = 'YOUR_EMAIL_ADDRESS'; //add your email address
        $mail->Password = 'YOUR_APP_PASSWORD'; // add your app password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
        $mail->Port = 587; 

        
        $mail->setFrom('system@dogcare.com', 'Dog Care'); 
        $mail->addAddress($email_address); 

        $mail->isHTML(true); 
        $mail->Subject = 'Message from Dog Care';
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
                                .message-text {
                                    font-size: 16px;
                                    color: #34495e;
                                    background-color: #f7f9fc;
                                    border-left: 4px solid #3498db;
                                    padding: 20px;
                                    margin: 25px 0;
                                    border-radius: 4px;
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
                                    <h1 class='email-title'>Message from Dog Care</h1>
                                </div>
                                <div class='email-content'>
                                    <div class='message-text'>
                                        $message
                                    </div>
                                </div>
                                <div class='email-footer'>
                                    &copy; 2025 Dog Care. All rights reserved.
                                </div>
                            </div>
                        </body>
                      </html>";

        $mail->AltBody = strip_tags($message); 

        $mail->send();
        echo "<script>alert('Email Send to the Client Successfully!!'); window.location.href='../../../admin-dashboard.php';</script>";
    } catch (Exception $e) {
        echo "<script>alert('Email Not Send Please contact developer team to get a help on this.'); window.location.href='../../../admin-dashboard.php';</script>";;
    }
}
?>