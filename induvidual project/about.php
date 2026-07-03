<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include('header.php');
?>

<div class="about-page-wrapper container py-5">
    <div class="text-center mb-5">
        <h1 class="section-title">About PowerZone.lk</h1>
        <p class="section-subtitle text-muted">Your trusted electrical partner since 2021</p>
    </div>

    <!-- Layout Grid -->
    <div class="row g-4 mb-5">
        <!-- About Us Card -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 glass-card">
                <div class="card-body p-4">
                    <h3 class="card-title text-accent mb-3"><i class="fa-solid fa-store me-2"></i>About Us</h3>
                    <hr class="title-divider">
                    <p class="card-text text-muted leading-relaxed">
                        Powerzone.lk is your one-stop shop for all your electrical needs. Located in the heart of Kithulgala, we are passionate about providing high-quality, innovative electrical products that enhance your lifestyle. We have been serving tech consumers and local contractors for over five years with high-reliability guarantees.
                    </p>
                </div>
            </div>
        </div>

        <!-- Our Mission Card -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 glass-card">
                <div class="card-body p-4">
                    <h3 class="card-title text-accent mb-3"><i class="fa-solid fa-bullseye me-2"></i>Our Mission</h3>
                    <hr class="title-divider">
                    <p class="card-text text-muted leading-relaxed">
                        To simplify and power the lives of our clients through modern solutions.
                    </p>
                    <ul class="mission-list text-muted p-0 mt-3" style="list-style: none;">
                        <li class="mb-2"><i class="fa-solid fa-circle-check text-accent me-2"></i>To deliver exceptional, expert customer service.</li>
                        <li class="mb-2"><i class="fa-solid fa-circle-check text-accent me-2"></i>To provide top-notch electrical solutions.</li>
                        <li class="mb-2"><i class="fa-solid fa-circle-check text-accent me-2"></i>To foster long-lasting relationships with our clients.</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- What Sets Us Apart Card -->
        <div class="col-lg-4 col-md-12">
            <div class="card h-100 glass-card">
                <div class="card-body p-4">
                    <h3 class="card-title text-accent mb-3"><i class="fa-solid fa-award me-2"></i>Why Choose Us</h3>
                    <hr class="title-divider">
                    <ul class="apart-list text-muted p-0" style="list-style: none;">
                        <li class="mb-3">
                            <strong>Extensive Product Range:</strong> We offer a wide array of electrical products, from the latest gadgets to essential home appliances.
                        </li>
                        <li class="mb-3">
                            <strong>Expert Advice:</strong> Our knowledgeable team is always ready to assist you in selecting the perfect products for your needs.
                        </li>
                        <li class="mb-3">
                            <strong>Competitive Pricing:</strong> We believe in offering the best value for your money.
                        </li>
                        <li class="mb-3">
                            <strong>Hassle-Free Returns:</strong> We have a straightforward return policy to guarantee your satisfaction.
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Our Values Card -->
        <div class="col-md-6">
            <div class="card h-100 glass-card">
                <div class="card-body p-4">
                    <h3 class="card-title text-accent mb-3"><i class="fa-solid fa-handshake me-2"></i>Our Values</h3>
                    <hr class="title-divider">
                    <div class="row g-3 text-muted">
                        <div class="col-12">
                            <strong><i class="fa-solid fa-scale-balanced text-accent me-2"></i>Integrity:</strong>
                            We believe in honest, transparent, and ethical business practices.
                        </div>
                        <div class="col-12">
                            <strong><i class="fa-solid fa-lightbulb text-accent me-2"></i>Innovation:</strong>
                            We strive to bring the latest and most energy-efficient technology to our customers.
                        </div>
                        <div class="col-12">
                            <strong><i class="fa-solid fa-users text-accent me-2"></i>Customer Focus:</strong>
                            Your satisfaction and convenience are our absolute top priority.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Logo Image Display -->
        <div class="col-md-6 d-flex align-items-center justify-content-center">
            <div class="about-logo-frame glass-panel p-3 rounded-4 shadow-lg text-center w-100">
                <img src="image/logo.png" alt="PowerZone Logo" class="img-fluid rounded-3" style="max-height: 200px;">
                <p class="mt-3 text-accent fw-bold fs-4">Powering Your World.</p>
            </div>
        </div>
    </div>

    <!-- Tech Time Machine Section -->
    <section class="time-machine-section py-5 my-4" id="time-machine">
        <div class="container text-center">
            <div class="section-header mb-5">
                <span class="badge bg-accent-soft text-accent px-3 py-2 text-uppercase fw-bold mb-2">Exclusive Interactive Feature</span>
                <h2 class="section-title">PowerZone Tech Time Machine</h2>
                <p class="section-subtitle text-muted mx-auto" style="max-width: 600px;">
                    Explore the historical evolution of consumer electronics and household items through the decades!
                </p>
            </div>
            
            <!-- Timeline Slider Buttons -->
            <div class="time-machine-controls d-inline-flex justify-content-center flex-wrap gap-2 p-2 rounded-pill bg-timeline-track mb-5">
                <button class="btn btn-timeline rounded-pill px-4 active" data-era="1980">1980s</button>
                <button class="btn btn-timeline rounded-pill px-4" data-era="1990">1990s</button>
                <button class="btn btn-timeline rounded-pill px-4" data-era="2000">2000s</button>
                <button class="btn btn-timeline rounded-pill px-4" data-era="2010">2010s</button>
                <button class="btn btn-timeline rounded-pill px-4" data-era="2026">Present</button>
            </div>
            
            <!-- Display Display Panel -->
            <div class="time-machine-display card glass-panel border-0 shadow-lg p-4 mb-4">
                <div class="row align-items-center g-4">
                    <!-- Then Card -->
                    <div class="col-md-5">
                        <div class="tech-comparison-card then-card p-4 rounded-4 shadow-sm border border-secondary-subtle">
                            <span class="badge bg-secondary px-3 py-2 mb-3 text-uppercase">Then (Vintage Tech)</span>
                            <div class="comparison-image-wrapper mb-3 rounded-3 overflow-hidden">
                                <img src="https://images.unsplash.com/photo-1595935736128-db120a2797d7?w=500&auto=format&fit=crop&q=60" id="time-machine-then-img" alt="Then Tech" class="img-fluid comparison-img">
                            </div>
                            <h3 id="time-machine-then-title" class="fw-bold">CRT Television</h3>
                            <p id="time-machine-then-desc" class="text-muted mb-0">Bulky, wood grain chassis with physical manual dial tuning and static interference.</p>
                        </div>
                    </div>
                    
                    <!-- VS Connector -->
                    <div class="col-md-2 d-flex justify-content-center align-items-center">
                        <div class="vs-badge-container shadow-md">
                            <span class="vs-badge">VS</span>
                        </div>
                    </div>
                    
                    <!-- Now Card -->
                    <div class="col-md-5">
                        <div class="tech-comparison-card now-card p-4 rounded-4 shadow-sm border border-info-subtle">
                            <span class="badge bg-accent px-3 py-2 mb-3 text-uppercase">Now (Modern Tech)</span>
                            <div class="comparison-image-wrapper mb-3 rounded-3 overflow-hidden">
                                <img src="image/consumer electronic/tv.webp" id="time-machine-now-img" alt="Now Tech" class="img-fluid comparison-img">
                            </div>
                            <h3 id="time-machine-now-title" class="fw-bold">40″ Slim LED TV</h3>
                            <p id="time-machine-now-desc" class="text-muted mb-0">Paper-thin display, smart application streaming, HDMI interfaces, and crystal clear Full HD visuals.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Location map block -->
    <div class="map-section mt-5">
        <h3 class="section-title mb-4 text-center"><i class="fa-solid fa-map-location-dot me-2"></i>Find Our Physical Store</h3>
        <div class="map-frame-container shadow-lg rounded-4 overflow-hidden border border-secondary">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d31691.45637748699!2d80.3689273!3d6.9979397!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNsKwNTknNTMuMCJOIDgwwrAyMicyMy44IkU!5e0!3m2!1sen!2slk!4v1681234567890" style="border: 0; width: 100%; height: 45vh;" allowfullscreen="" loading="lazy"></iframe>
        </div>
    </div>

    <div class="text-center mt-5">
        <p class="lead text-muted italic">"Join us on this electrifying journey."</p>
    </div>
</div>

<?php include('footer.php'); ?>
