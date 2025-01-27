<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="src/styles/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://unpkg.com/scrollreveal"></script>
    <title>Dog Care</title>
</head>
<body>

<header>
    <!-- Navigation Bar -->
    <?php include 'navbar.php'; ?>
</header>

<main id="content">
    <section id="home">
        <div class="shape"></div>
        <div id="cta">
            <h1 class="title">
                We give your pets the best 
                <span>care</span>
            </h1>

            <p class="description">
                At our clinic, we understand that pets are family. Our dedicated team of professionals is committed to providing the highest quality of care for your furry friends. From routine check-ups to emergency services, we are here for you and your pets.
            </p>

            <div id="cta_buttons">
                <a href="create-appointment.php" class="btn-default" style="color: white;">
                    Book Now
                </a>

                <a href="tel:+55555555555" id="phone_button">
                    <button class="btn-default">
                        <i class="fa-solid fa-phone"></i>
                    </button>
                    071 4568812
                </a>
            </div>

            <div class="social-media-buttons">
                <a href="">
                    <i class="fa-brands fa-whatsapp"></i>
                </a>

                <a href="">
                    <i class="fa-brands fa-instagram"></i>
                </a>

                <a href="">
                    <i class="fa-brands fa-facebook"></i>
                </a>
            </div>
        </div>

        <div id="banner">
            <img src="src/img/img1.jpeg" alt="Landing Page Banner">
        </div>
    </section> 

    <section id="companyabout">
        <img src="src/img/img2.jpeg" id="testimonial_chef" alt="About Banner">

        <div id="testimonials_content">
            <h1 class="section-title">
                About Us
            </h1>

            <div id="aboutus">
                <div class="about">
                    <div class="about-content">
                        <p>
                            Welcome to our animal clinic, where your pets' health and happiness are our top priorities. Our experienced veterinarians and staff are passionate about providing compassionate care tailored to the unique needs of each pet. We offer a wide range of services, including vaccinations, dental care, surgery, and wellness exams. Trust us to keep your beloved companions healthy and thriving.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="testimonials">
        <div id="testimonials_content">
            <h2 class="section-title">What Clients Say</h2>
            <div id="feedbacks">
                <?php
                include 'src/database/dbcon.php';

                $sql = "
                    SELECT f.name, f.message, f.star_count, f.consult_doctor, f.profile_img, d.doctor_name 
                    FROM feedback f 
                    JOIN doctors d ON f.consult_doctor = d.doctor_username 
                    ORDER BY f.id DESC 
                    LIMIT 6
                ";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    echo '<div class="feedback-grid">';
                    // Output each feedback as a block
                    while ($row = $result->fetch_assoc()) {
                        $name = htmlspecialchars($row['name']);
                        $feedback = htmlspecialchars($row['message']);
                        $starCount = intval($row['star_count']);
                        $consultDoctor = htmlspecialchars($row['doctor_name']);
                        $profileImg = !empty($row['profile_img']) ? htmlspecialchars($row['profile_img']) : 'src/img/no_avatar.png';
                        
                        $starRating = '';
                        for ($i = 1; $i <= 5; $i++) {
                            $starRating .= $i <= $starCount 
                                ? '<span class="star filled">&#9733;</span>' 
                                : '<span class="star">&#9733;</span>';
                        }

                        echo <<<HTML
                        <div class="feedback">
                            <img src="$profileImg" alt="$name" class="feedback-avatar">
                            <div class="feedback-content">
                                <div class="feedback-header">
                                    <div class="feedback-name">
                                        <strong>$name</strong>
                                        <span class="consult-doctor">Consulted Dr. $consultDoctor</span>
                                    </div>
                                    <div class="feedback-rating">
                                        $starRating
                                    </div>
                                </div>
                                <p class="feedback-message">"$feedback"</p>
                            </div>
                        </div>
                        HTML;
                    }
                    echo '</div>';
                } else {
                    echo "<p>No feedback available at the moment.</p>";
                }

                $conn->close();
                ?>
            </div>
        </div>
    </section>

    <section id="contact">
        <div id="contact_container">
            <div id="contact_left">
                <img src="src/img/img3.jpeg" id="contact_image" alt="Contact Us Banner">
            </div>

            <div id="contact_right">
                <h2 class="section-title">Contact Us</h2>
                <p class="section-description">
                    We’d love to hear from you! Whether you have questions, feedback, or just want to say hello, feel free to reach out. Our team is here to assist you and ensure your pets receive the best care possible.
                </p>
                <form id="contact_form" action="src/scripts/submit-feedback.php" method="POST">
                    <div class="form-group">
                        <input type="text" name="name" placeholder="Your Name" required>
                    </div>
                    <div class="form-group">
                        <input type="email" name="email" placeholder="Your Email" required>
                    </div>
                    <div class="form-group">
                        <textarea name="message" rows="5" placeholder="Your Message" required></textarea>
                    </div>
                    <button type="submit" class="btn-submit">Send Message</button>
                </form>
            </div>
        </div>
    </section>

</main>

<!-- Footer -->
<?php include 'footer.php'; ?>

<!-- Javascript Functions -->
<script src="src/javascript/script.js"></script>

</body>
</html>