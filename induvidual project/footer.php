<!-- Newsletter Section -->
<section class="newsletter-section" id="news">
    <div class="container text-center">
        <div class="newsletter-card">
            <h3 class="mb-2">Subscribe to PowerZone.lk</h3>
            <p class="text-muted mb-4">Stay updated with our latest products, exclusive offers, and technological updates.</p>
            <form class="newsletter-form d-flex flex-column flex-sm-row justify-content-center gap-2" onsubmit="event.preventDefault(); alert('Thank you for subscribing to our newsletter!'); this.reset();">
                <input type="email" placeholder="Enter Your Email Address" required class="form-control">
                <button type="submit" id="Subscribe" class="btn btn-subscribe">Subscribe</button>
            </form>
        </div>
    </div>
</section>

<!-- Footer -->   
<footer id="footer">
    <div class="footer-top">
        <div class="container">
            <div class="row g-4">
                <!-- Contact Info Column -->
                <div class="col-lg-3 col-md-6 footer-contact">
                    <h3><span class="logo-power">Power</span><span class="logo-zone-footer">Zone.lk</span></h3>
                    <p class="footer-address mt-3">
                        D19/1B Hatton Road,<br>
                        Kithulgala,<br>
                        Sri Lanka.
                    </p>
                    <p class="footer-contact-details mt-3">
                        <strong><i class="fa-solid fa-phone me-2"></i>Phone:</strong> +94 77 361 0194<br>
                        <strong><i class="fa-solid fa-envelope me-2"></i>Email:</strong> <a href="mailto:powerzonelk@gmail.com">powerzonelk@gmail.com</a>
                    </p>
                </div>

                <!-- Useful Links Column -->
                <div class="col-lg-3 col-md-6 footer-links">
                    <h4>Useful Links</h4>
                    <ul>
                        <li><a href="index.php"><i class="fa-solid fa-chevron-right me-2"></i>Home</a></li>
                        <li><a href="about.php"><i class="fa-solid fa-chevron-right me-2"></i>About Us</a></li>
                        <li><a href="#"><i class="fa-solid fa-chevron-right me-2"></i>Services</a></li>
                        <li><a href="#"><i class="fa-solid fa-chevron-right me-2"></i>Terms of Service</a></li>
                        <li><a href="#"><i class="fa-solid fa-chevron-right me-2"></i>Privacy Policy</a></li>
                        <li><a href="contact.php"><i class="fa-solid fa-chevron-right me-2"></i>Contact Us</a></li>
                    </ul>
                </div>

                <!-- Services/Categories Column -->
                <div class="col-lg-3 col-md-6 footer-links">
                    <h4>Our Categories</h4>
                    <ul>
                        <li><a href="consumer.php"><i class="fa-solid fa-chevron-right me-2"></i>Consumer Electronics</a></li>
                        <li><a href="household.php"><i class="fa-solid fa-chevron-right me-2"></i>Household Appliances</a></li>
                    </ul>
                </div>

                <!-- Social Media Column -->
                <div class="col-lg-3 col-md-6 footer-social-column">
                    <h4>Connect With Us</h4>
                    <p>Stay connected and share your experiences on our vibrant social channels.</p>
                    <div class="social-links d-flex gap-3 mt-3">
                        <a href="#" class="facebook-link" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="#" class="instagram-link" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
                        <a href="#" class="twitter-link" aria-label="Twitter"><i class="fa-brands fa-x-twitter"></i></a>
                        <a href="mailto:powerzonelk@gmail.com" class="email-link" aria-label="Email"><i class="fa-solid fa-envelope"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <hr class="footer-divider">
    
    <div class="footer-bottom text-center">
        <div class="container d-flex flex-column flex-sm-row justify-content-between align-items-center gap-2">
            <div class="copyright">
                &copy; Copyright <strong>PowerZone.lk</strong>. All Rights Reserved.
            </div>
            <div class="credit">
                Designed by <a href="#" class="designer-link fw-semibold">DEH/IT/0057</a>
            </div>
        </div>
    </div>
</footer>  

<!-- Bootstrap 5 Bundle JS (includes Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<!-- Custom JS Script -->
<script src="index.js"></script>
</body>
</html>
