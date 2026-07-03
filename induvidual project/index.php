<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Load products for search and dynamic features
$products_file = 'products.json';
$products = [];
if (file_exists($products_file)) {
    $products = json_decode(file_get_contents($products_file), true);
}

// Check if search query is present
$search_query = isset($_GET['search']) ? trim($_GET['search']) : '';
$search_results = [];

if ($search_query !== '') {
    foreach ($products as $id => $product) {
        if (stripos($product['name'], $search_query) !== false || stripos($product['description'], $search_query) !== false) {
            $search_results[$id] = $product;
        }
    }
}

include('header.php');
?>

<!-- Main Content Area -->
<main class="home-main-content">
    <?php if ($search_query !== ''): ?>
        <!-- Search Results Section -->
        <section class="search-results-section py-5">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="section-title m-0">Search Results for "<?php echo htmlspecialchars($search_query); ?>"</h2>
                    <a href="index.php" class="btn btn-outline-secondary btn-sm"><i class="fa-solid fa-arrow-left me-2"></i>Clear Search</a>
                </div>
                
                <?php if (empty($search_results)): ?>
                    <div class="no-results-card text-center py-5 glass-panel">
                        <i class="fa-solid fa-magnifying-glass fa-4x text-muted mb-3"></i>
                        <h3>No Products Found</h3>
                        <p class="text-muted">We couldn't find any products matching your query. Please try searching other keywords.</p>
                    </div>
                <?php else: ?>
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                        <?php foreach ($search_results as $id => $product): ?>
                            <div class="col">
                                <div class="product-item-card h-100 glass-card">
                                    <span class="badge-category text-uppercase"><?php echo htmlspecialchars($product['category']); ?></span>
                                    <div class="product-img-wrapper">
                                        <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="img-fluid">
                                    </div>
                                    <div class="product-card-body p-3 text-center">
                                        <h4 class="product-card-title"><?php echo htmlspecialchars($product['name']); ?></h4>
                                        <h5 class="product-card-price text-accent"><?php echo htmlspecialchars($product['price']); ?></h5>
                                        <a href="product.php?id=<?php echo $id; ?>" class="btn btn-view-product w-100 mt-3">View Details</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    <?php else: ?>
        <!-- Modernized 3D Hero Section -->
        <section class="home-hero-section overflow-hidden py-5 d-flex align-items-center" style="min-height: 80vh;">
            <div class="container hero-container d-flex flex-column flex-lg-row align-items-center justify-content-between gap-5 position-relative z-2">
                <!-- Text Column -->
                <div class="hero-content-column text-center text-lg-start col-lg-6">
                    <div class="badge bg-accent-soft text-accent px-3 py-2 text-uppercase fw-bold mb-3 animate-fade-in"><i class="fa-solid fa-circle-nodes me-2"></i>Smart Electronics Showroom</div>
                    <h1 class="hero-title animate-fade-in mb-3">Powering the Future of <span class="logo-power">Smart</span><span class="logo-zone">Living</span></h1>
                    <h2 class="hero-subtitle mb-4 text-muted fs-4 fw-medium">Welcome to PowerZone.lk – Registry No: DEH/IT/0057</h2>
                    <p class="hero-desc mb-4 text-muted">
                        Explore our curated selection of high-performance appliances and next-generation consumer gadgets. Experience our 3D secure checkout, digital tracking, and decade-defining timeline tools today!
                    </p>
                    <div class="hero-actions d-flex justify-content-center justify-content-lg-start gap-3 flex-wrap">
                        <a href="#featured-showroom" class="btn btn-hero-primary px-4 py-3"><i class="fa-solid fa-cart-shopping me-2"></i>Shop Showroom</a>
                        <a href="#video-demo" class="btn btn-hero-secondary px-4 py-3"><i class="fa-solid fa-circle-play me-2"></i>Live 2D Demo</a>
                    </div>
                </div>
                
                <!-- 3D Flipping Showcase Column -->
                <div class="hero-image-column col-lg-5 d-flex flex-column align-items-center">
                    <div class="cube-showcase-container">
                        <div class="cube-carousel" id="cube-carousel-box">
                            <!-- Card 1 -->
                            <div class="cube-card active glass-card text-center" data-index="0">
                                <span class="badge bg-danger text-white mb-3 text-uppercase text-xs font-bold">Hot Selling</span>
                                <img src="image/consumer electronic/playstation 5.jpg" alt="PS5 Slim" class="img-fluid mb-2">
                                <h4 class="fw-bold text-white mb-1">PlayStation 5 Slim</h4>
                                <p class="text-accent fw-semibold mb-2">LKR184,990.00</p>
                                <a href="product.php?id=playstation" class="btn btn-view-product btn-sm px-4">Buy Now</a>
                            </div>
                            <!-- Card 2 -->
                            <div class="cube-card glass-card text-center" data-index="1">
                                <span class="badge bg-warning text-dark mb-3 text-uppercase text-xs font-bold">Premium Tech</span>
                                <img src="image/consumer electronic/laptop.webp" alt="HP Ryzen Laptop" class="img-fluid mb-2">
                                <h4 class="fw-bold text-white mb-1">HP Ryzen 5 Laptop</h4>
                                <p class="text-accent fw-semibold mb-2">LKR220,000.00</p>
                                <a href="product.php?id=laptop" class="btn btn-view-product btn-sm px-4">Buy Now</a>
                            </div>
                            <!-- Card 3 -->
                            <div class="cube-card glass-card text-center" data-index="2">
                                <span class="badge bg-info text-white mb-3 text-uppercase text-xs font-bold">Adventure ready</span>
                                <img src="image/consumer electronic/gopro.jpg" alt="GoPro Camera" class="img-fluid mb-2">
                                <h4 class="fw-bold text-white mb-1">GoPro Action Camera</h4>
                                <p class="text-accent fw-semibold mb-2">LKR114,990.00</p>
                                <a href="product.php?id=actioncamera" class="btn btn-view-product btn-sm px-4">Buy Now</a>
                            </div>
                        </div>
                        
                        <!-- 3D Controls -->
                        <div class="cube-controls d-flex justify-content-center gap-3 mt-4">
                            <button class="btn btn-cube-control" id="cube-prev" aria-label="Previous Showcase"><i class="fa-solid fa-chevron-left"></i></button>
                            <button class="btn btn-cube-control" id="cube-next" aria-label="Next Showcase"><i class="fa-solid fa-chevron-right"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Dynamic Store Stats & Features Panel -->
        <section class="store-features-section py-4 bg-glass-dark border-top border-bottom border-secondary">
            <div class="container">
                <div class="row row-cols-2 row-cols-lg-4 g-4 text-center">
                    <div class="col">
                        <div class="stat-card p-3">
                            <i class="fa-solid fa-shield-halved fa-2x text-accent mb-2"></i>
                            <h5 class="fw-bold mb-1 text-white">3D Secure Checkout</h5>
                            <p class="text-muted text-xs m-0">Interactive validation overlays</p>
                        </div>
                    </div>
                    <div class="col">
                        <div class="stat-card p-3">
                            <i class="fa-solid fa-clock-rotate-left fa-2x text-accent mb-2"></i>
                            <h5 class="fw-bold mb-1 text-white">Decades Archive</h5>
                            <p class="text-muted text-xs m-0">Explore historic tech evolution</p>
                        </div>
                    </div>
                    <div class="col">
                        <div class="stat-card p-3">
                            <i class="fa-solid fa-truck-fast fa-2x text-accent mb-2"></i>
                            <h5 class="fw-bold mb-1 text-white">Islandwide Delivery</h5>
                            <p class="text-muted text-xs m-0">Direct shipping from Kithulgala</p>
                        </div>
                    </div>
                    <div class="col">
                        <div class="stat-card p-3">
                            <i class="fa-solid fa-circle-info fa-2x text-accent mb-2"></i>
                            <h5 class="fw-bold mb-1 text-white">DEH/IT/0057</h5>
                            <p class="text-muted text-xs m-0">Accredited Student Project</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Category Showcases -->
        <section class="category-cards-section py-5">
            <div class="container">
                <h2 class="section-title text-center mb-5">Browse Our Premium Categories</h2>
                <div class="row g-4">
                    <!-- Category 1 -->
                    <div class="col-md-6">
                        <a href="consumer.php" class="category-banner-card glass-card d-flex align-items-center justify-content-between p-4 p-lg-5 overflow-hidden">
                            <div class="category-card-text text-start">
                                <span class="badge bg-accent-soft text-accent mb-2">High Tech</span>
                                <h3 class="fw-bold text-white mb-2">Consumer Electronics</h3>
                                <p class="text-muted text-sm mb-4">Laptops, Gaming devices, smart watches, and security CCTV systems.</p>
                                <span class="btn btn-sm btn-outline-light rounded-pill px-4">Explore Products</span>
                            </div>
                            <div class="category-card-icon-overlay">
                                <i class="fa-solid fa-laptop-code"></i>
                            </div>
                        </a>
                    </div>
                    <!-- Category 2 -->
                    <div class="col-md-6">
                        <a href="household.php" class="category-banner-card glass-card d-flex align-items-center justify-content-between p-4 p-lg-5 overflow-hidden">
                            <div class="category-card-text text-start">
                                <span class="badge bg-accent-soft text-accent mb-2">Smart Living</span>
                                <h3 class="fw-bold text-white mb-2">Household Appliances</h3>
                                <p class="text-muted text-sm mb-4">Refrigerators, digital microwave ovens, fans, blenders, and smart kettles.</p>
                                <span class="btn btn-sm btn-outline-light rounded-pill px-4">Explore Products</span>
                            </div>
                            <div class="category-card-icon-overlay">
                                <i class="fa-solid fa-kitchen-set"></i>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Interactive 2D Animation HUD Console Demo Video Mockup -->
        <section class="video-console-section py-5 bg-glass-dark border-top border-bottom border-secondary-subtle" id="video-demo">
            <div class="container">
                <div class="section-header text-center mb-5">
                    <span class="badge bg-accent-soft text-accent px-3 py-2 text-uppercase fw-bold mb-2"><i class="fa-solid fa-display me-2"></i>Showroom Interactive Simulation</span>
                    <h2 class="section-title">PowerZone Smart Tech Live Demo</h2>
                    <p class="section-subtitle text-muted mx-auto" style="max-width: 600px;">
                        Operate our custom 2D animated HUD control panel to test electrical voltage flow and equalizer telemetry outputs!
                    </p>
                </div>
                
                <div class="video-console-frame glass-panel p-3 mx-auto shadow-lg border border-secondary" style="max-width: 800px; border-radius: 20px;">
                    <!-- Simulated Video Screen -->
                    <div class="simulated-screen position-relative overflow-hidden bg-black rounded-3 d-flex flex-column justify-content-center align-items-center" style="height: 360px;">
                        
                        <!-- Grid overlay background -->
                        <div class="console-grid-overlay"></div>
                        
                        <!-- HUD Interface -->
                        <div class="hud-container text-start p-3 w-100 h-100 d-flex flex-column justify-content-between position-relative z-2">
                            <div class="hud-top d-flex justify-content-between align-items-center text-success font-monospace text-xs">
                                <span class="hud-blink"><i class="fa-solid fa-circle text-danger me-1"></i>SYSTEM STATUS: <span id="hud-status-node">OFFLINE</span></span>
                                <span>GRID VOLTAGE: <span id="hud-voltage-val">0.00V</span> | TEMP: <span id="hud-temp-val">22.5°C</span></span>
                            </div>
                            
                            <!-- Middle Play/HUD details -->
                            <div class="hud-center text-center my-auto d-flex flex-column align-items-center gap-3">
                                <div class="play-pulse-circle" id="hud-play-btn">
                                    <i class="fa-solid fa-play fa-2x text-white" id="hud-play-icon"></i>
                                </div>
                                <h4 class="text-white fw-bold mb-0" id="hud-status-text">PowerZone Live Showcase</h4>
                                <span class="text-success text-xs font-monospace" id="hud-instruction-text">Click play to initialize interactive console telemetry</span>
                                
                                <!-- Equalizer telemetry bars -->
                                <div class="equalizer-bars d-flex gap-1 justify-content-center mt-2" id="console-equalizer">
                                    <div class="bar bar-1"></div>
                                    <div class="bar bar-2"></div>
                                    <div class="bar bar-3"></div>
                                    <div class="bar bar-4"></div>
                                    <div class="bar bar-5"></div>
                                    <div class="bar bar-6"></div>
                                    <div class="bar bar-7"></div>
                                    <div class="bar bar-8"></div>
                                </div>
                            </div>
                            
                            <!-- Bottom HUD Status Indicators -->
                            <div class="hud-bottom w-100">
                                <div class="d-flex justify-content-between text-success font-monospace text-xs mb-1">
                                    <span id="hud-time-elapsed">00:00</span>
                                    <span id="hud-time-total">00:45</span>
                                </div>
                                <div class="hud-progress-track bg-secondary rounded-pill overflow-hidden" style="height: 6px;">
                                    <div class="hud-progress-bar bg-success" id="hud-progress" style="width: 0%; height: 100%;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Video Controls Panel -->
                    <div class="video-controls-panel d-flex justify-content-between align-items-center mt-3 px-2">
                        <div class="d-flex gap-2">
                            <button class="btn btn-sm btn-outline-secondary" id="console-btn-play"><i class="fa-solid fa-play me-1"></i>Play Demo</button>
                            <button class="btn btn-sm btn-outline-secondary" id="console-btn-reset"><i class="fa-solid fa-rotate-left me-1"></i>Reset System</button>
                        </div>
                        <div class="d-flex align-items-center gap-2 text-muted text-sm">
                            <i class="fa-solid fa-wave-square text-accent"></i>
                            <span class="font-monospace text-xs">Equalizer Output</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>



        <!-- Featured Showroom Section -->
        <section class="showroom-section py-5" id="featured-showroom">
            <div class="container">
                <h2 class="section-title text-center mb-5">Featured Store Items</h2>
                
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                    <!-- Slice top 4 products for showcasing -->
                    <?php 
                    $featured_keys = ['playstation', 'laptop', 'tv', 'washinmachine'];
                    foreach ($featured_keys as $key): 
                        if (isset($products[$key])):
                            $prod = $products[$key];
                    ?>
                        <div class="col animate-fade-in">
                            <div class="product-item-card h-100 glass-card">
                                <span class="badge-category text-uppercase"><?php echo htmlspecialchars($prod['category']); ?></span>
                                <div class="product-img-wrapper">
                                    <img src="<?php echo htmlspecialchars($prod['image']); ?>" alt="<?php echo htmlspecialchars($prod['name']); ?>" class="img-fluid">
                                </div>
                                <div class="product-card-body p-3 text-center">
                                    <h4 class="product-card-title"><?php echo htmlspecialchars($prod['name']); ?></h4>
                                    <h5 class="product-card-price text-accent"><?php echo htmlspecialchars($prod['price']); ?></h5>
                                    <a href="product.php?id=<?php echo $key; ?>" class="btn btn-view-product w-100 mt-3">View Details</a>
                                </div>
                            </div>
                        </div>
                    <?php 
                        endif;
                    endforeach; 
                    ?>
                </div>
            </div>
        </section>

        <!-- Carousel Advertisements Slider -->
        <section class="ads-carousel-section py-5 bg-glass-dark border-top border-secondary">
            <div class="container">
                <h2 class="text-center section-title mb-5">Latest Promotional Updates</h2>
                <div id="carouselExampleSlidesOnly" class="carousel slide shadow-lg rounded-4 overflow-hidden border border-secondary" data-bs-ride="carousel" data-bs-interval="4000">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="image/homead1.jpg" class="d-block w-100 ad-carousel-img" alt="Promotional Banner 1">
                        </div>
                        <div class="carousel-item">
                            <img src="image/homead2.jpg" class="d-block w-100 ad-carousel-img" alt="Promotional Banner 2">
                        </div>
                        <div class="carousel-item">
                            <img src="image/homead3.jpg" class="d-block w-100 ad-carousel-img" alt="Promotional Banner 3">
                        </div>
                        <div class="carousel-item">
                            <img src="image/homead4.jpg" class="d-block w-100 ad-carousel-img" alt="Promotional Banner 4">
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>
</main>

<!-- Interactive Showcase and Demo Script -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    // 1. 3D Card Showcase flip logic
    const box = document.getElementById("cube-carousel-box");
    const prev = document.getElementById("cube-prev");
    const next = document.getElementById("cube-next");
    
    if (box && prev && next) {
        const cards = box.querySelectorAll(".cube-card");
        let activeIdx = 0;
        
        function update3DCarousel() {
            cards.forEach((card, idx) => {
                card.className = "cube-card glass-card text-center";
                
                if (idx === activeIdx) {
                    card.classList.add("active");
                } else if (idx === (activeIdx - 1 + cards.length) % cards.length) {
                    card.classList.add("prev-card");
                } else {
                    card.classList.add("next-card");
                }
            });
        }
        
        prev.addEventListener("click", function () {
            activeIdx = (activeIdx - 1 + cards.length) % cards.length;
            update3DCarousel();
        });
        
        next.addEventListener("click", function () {
            activeIdx = (activeIdx + 1) % cards.length;
            update3DCarousel();
        });
        
        // Auto-rotation every 5 seconds
        setInterval(function() {
            activeIdx = (activeIdx + 1) % cards.length;
            update3DCarousel();
        }, 5000);
        
        // Initialize
        update3DCarousel();
    }
    
    // 2. Simulated HUD video player control panel
    const btnPlay = document.getElementById("console-btn-play");
    const btnReset = document.getElementById("console-btn-reset");
    const hudPlay = document.getElementById("hud-play-btn");
    const hudPlayIcon = document.getElementById("hud-play-icon");
    const statusNode = document.getElementById("hud-status-node");
    const voltageVal = document.getElementById("hud-voltage-val");
    const tempVal = document.getElementById("hud-temp-val");
    const statusText = document.getElementById("hud-status-text");
    const instructionText = document.getElementById("hud-instruction-text");
    const equalizer = document.getElementById("console-equalizer");
    const elapsedEl = document.getElementById("hud-time-elapsed");
    const progressTrack = document.getElementById("hud-progress");
    
    let isPlaying = false;
    let timer = null;
    let elapsedSec = 0;
    const totalSec = 45;
    
    function updateHUD() {
        if (isPlaying) {
            elapsedSec++;
            if (elapsedSec >= totalSec) {
                resetHUD();
                return;
            }
            
            // Generate random voltage and temperature checks
            const volt = (220 + Math.random() * 15).toFixed(2);
            const temp = (23 + Math.random() * 4).toFixed(1);
            
            voltageVal.innerText = volt + "V";
            tempVal.innerText = temp + "°C";
            
            // Progress Calculation
            const pct = (elapsedSec / totalSec) * 100;
            progressTrack.style.width = pct + "%";
            
            // Format time display
            const mins = String(Math.floor(elapsedSec / 60)).padStart(2, '0');
            const secs = String(elapsedSec % 60).padStart(2, '0');
            elapsedEl.innerText = `${mins}:${secs}`;
        }
    }
    
    function playHUD() {
        if (isPlaying) return;
        isPlaying = true;
        
        statusNode.innerText = "ONLINE";
        statusNode.parentElement.classList.remove("text-danger");
        statusNode.parentElement.classList.add("text-success");
        statusText.innerText = "STREAMING: DEMO TELEMETRY";
        instructionText.innerText = "Console running. Generating visual wave analytics.";
        
        hudPlayIcon.className = "fa-solid fa-pause fa-2x text-white";
        btnPlay.innerHTML = '<i class="fa-solid fa-pause me-1"></i>Pause Demo';
        
        equalizer.classList.add("animating");
        
        timer = setInterval(updateHUD, 1000);
    }
    
    function pauseHUD() {
        if (!isPlaying) return;
        isPlaying = false;
        
        statusNode.innerText = "PAUSED";
        hudPlayIcon.className = "fa-solid fa-play fa-2x text-white";
        btnPlay.innerHTML = '<i class="fa-solid fa-play me-1"></i>Resume Demo';
        
        equalizer.classList.remove("animating");
        
        clearInterval(timer);
    }
    
    function resetHUD() {
        pauseHUD();
        elapsedSec = 0;
        elapsedEl.innerText = "00:00";
        progressTrack.style.width = "0%";
        voltageVal.innerText = "0.00V";
        tempVal.innerText = "22.5°C";
        statusNode.innerText = "OFFLINE";
        statusText.innerText = "PowerZone Live Showcase";
        instructionText.innerText = "Click play to initialize interactive console telemetry";
        
        btnPlay.innerHTML = '<i class="fa-solid fa-play me-1"></i>Play Demo';
    }
    
    function toggleHUD() {
        if (isPlaying) {
            pauseHUD();
        } else {
            playHUD();
        }
    }
    
    if (btnPlay && btnReset && hudPlay) {
        btnPlay.addEventListener("click", toggleHUD);
        hudPlay.addEventListener("click", toggleHUD);
        btnReset.addEventListener("click", resetHUD);
    }
});
</script>

<?php include('footer.php'); ?>
