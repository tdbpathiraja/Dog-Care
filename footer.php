<footer>
    <div class="footer-container">
        <div class="footer-logo-section">
            <div class="footer-logo">
                <i class="fa-solid fa-dog" id="nav_logo">Dog Care</i>
            </div>
            <p class="footer-description">
                Providing comprehensive veterinary care with compassion and expertise. 
                Our dedicated team ensures the health and well-being of your beloved pets 
                through advanced medical treatments and personalized care.
            </p>
        </div>

        <div class="footer-nav">
            <div class="footer-nav-column">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Services</a></li>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </div>

            <div class="footer-nav-column">
                <h4>Our Services</h4>
                <ul>
                    <li><a href="#">Wellness Exams</a></li>
                    <li><a href="#">Vaccinations</a></li>
                    <li><a href="#">Surgery</a></li>
                    <li><a href="#">Emergency Care</a></li>
                </ul>
            </div>

            <div class="footer-nav-column">
                <h4>Connect With Us</h4>
                <ul>
                    <li><a href="#">Book Appointment</a></li>
                    <li><a href="#">FAQs</a></li>
                    <li><a href="#">Blog</a></li>
                    <li><a href="#">Pet Resources</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="container">
            <div class="footer-bottom-content">
                <span id="copyright">
                    &copy; <span id="current-year"></span> Dog Care. All Rights Reserved.
                </span>
            </div>
        </div>

        <div class="social-media-buttons">
            <div class="social-media-icon whatsapp">
                <a href="#" aria-label="WhatsApp">
                    <i class="fab fa-whatsapp"></i>
                </a>
            </div>
            <div class="social-media-icon instagram">
                <a href="#" aria-label="Instagram">
                    <i class="fab fa-instagram"></i>
                </a>
            </div>
            <div class="social-media-icon facebook">
                <a href="#" aria-label="Facebook">
                    <i class="fab fa-facebook"></i>
                </a>
            </div>
        </div>
    </div>
</footer>


<!-- Footer Copyright Year Calculating Function -->
<script>
    const currentYear = new Date().getFullYear();
    document.getElementById('current-year').textContent = currentYear;
</script>