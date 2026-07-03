<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1. Load products data
$products_file = 'products.json';
if (!file_exists($products_file)) {
    die("Product database not found.");
}
$products_data = json_decode(file_get_contents($products_file), true);

// 2. Fetch product ID
$product_id = isset($_GET['id']) ? trim($_GET['id']) : '';

if (empty($product_id) || !isset($products_data[$product_id])) {
    // Redirect to home if invalid or missing product
    header("Location: index.php");
    exit();
}

$product = $products_data[$product_id];

// 3. Database connection check and schema insertion fallback
include('db.php'); // loads $conn

$db_available = false;
if (isset($conn) && $conn instanceof mysqli && !$conn->connect_error) {
    // Check if reviews table exists
    $table_check = $conn->query("SHOW TABLES LIKE 'reviews'");
    if ($table_check && $table_check->num_rows > 0) {
        $db_available = true;
    }
}

// 4. Handle review submission (POST)
$submission_success = false;
$submission_error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_review'])) {
    $reviewer_name = isset($_POST['name']) ? trim(htmlspecialchars($_POST['name'])) : '';
    $reviewer_comment = isset($_POST['comment']) ? trim(htmlspecialchars($_POST['comment'])) : '';
    $product_rating = isset($_POST['rating']) ? intval($_POST['rating']) : 5;
    
    if ($reviewer_name !== '' && $reviewer_comment !== '') {
        if ($db_available) {
            // Insert into MySQL database
            $stmt = $conn->prepare("INSERT INTO reviews (product_id, name, comment, rating) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("sssi", $product_id, $reviewer_name, $reviewer_comment, $product_rating);
            if ($stmt->execute()) {
                $submission_success = true;
            } else {
                $submission_error = "Database error saving review: " . $stmt->error;
            }
            $stmt->close();
        } else {
            // Fallback: Save directly to products.json
            $products_data[$product_id]['reviews'][] = [
                'name' => $reviewer_name,
                'comment' => $reviewer_comment,
                'rating' => $product_rating
            ];
            
            // Recalculate average rating
            $total_reviews = count($products_data[$product_id]['reviews']);
            $products_data[$product_id]['reviews_count'] = $total_reviews;
            
            if (file_put_contents($products_file, json_encode($products_data, JSON_PRETTY_PRINT))) {
                // Update local array reference
                $product = $products_data[$product_id];
                $submission_success = true;
            } else {
                $submission_error = "File permission error saving review.";
            }
        }
    } else {
        $submission_error = "Please fill in all fields.";
    }
}

// 5. Fetch reviews (merge database and json reviews if db is available)
$display_reviews = $product['reviews'];
if ($db_available) {
    $stmt = $conn->prepare("SELECT name, comment, rating FROM reviews WHERE product_id = ? ORDER BY id DESC");
    $stmt->bind_param("s", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        // Clear default reviews if we have user entries or just append
        $display_reviews = [];
        while ($row = $result->fetch_assoc()) {
            $display_reviews[] = [
                'name' => $row['name'],
                'comment' => $row['comment']
            ];
        }
    }
    $stmt->close();
}

include('header.php');
?>

<div class="product-page-container container py-5">
    <!-- Breadcrumbs -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item">
                <a href="<?php echo $product['category'] === 'consumer' ? 'consumer.php' : 'household.php'; ?>">
                    <?php echo $product['category'] === 'consumer' ? 'Consumer Electronics' : 'Household Appliances'; ?>
                </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page"><?php echo htmlspecialchars($product['name']); ?></li>
        </ol>
    </nav>

    <!-- Success / Error messages -->
    <?php if ($submission_success): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fa-solid fa-circle-check me-2"></i>Review submitted successfully! Thank you for your feedback.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php elseif ($submission_error !== ""): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fa-solid fa-circle-exclamation me-2"></i><?php echo $submission_error; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Main Product Grid -->
    <div class="row g-5">
        <!-- Product Image Section -->
        <div class="col-lg-6">
            <div class="product-gallery-card">
                <span class="category-tag text-uppercase"><?php echo htmlspecialchars($product['category']); ?></span>
                <div class="main-image-container">
                    <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="img-fluid product-main-img" id="productImage">
                </div>
            </div>
        </div>
        
        <!-- Product Details Section -->
        <div class="col-lg-6">
            <div class="product-info-panel">
                <h1 class="product-title mb-2"><?php echo htmlspecialchars($product['name']); ?></h1>
                
                <div class="rating-summary-row d-flex align-items-center gap-3 mb-4">
                    <div class="star-rating-display text-warning">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star-half-stroke"></i>
                    </div>
                    <span class="rating-text text-muted"><?php echo count($display_reviews); ?> reviews</span>
                </div>
                
                <div class="price-box mb-4 d-flex align-items-center justify-content-between flex-wrap gap-3 w-100">
                    <div>
                        <span class="price-label">Retail Price</span>
                        <h2 class="product-price"><?php echo htmlspecialchars($product['price']); ?></h2>
                    </div>
                    <a href="checkout.php?id=<?php echo urlencode($product_id); ?>" class="btn btn-buy-now px-4 py-2"><i class="fa-solid fa-cart-shopping me-2"></i>Buy Now</a>
                </div>
                
                <div class="description-box mb-4">
                    <h4 class="section-title-sm mb-3">Description</h4>
                    <p class="product-desc"><?php echo htmlspecialchars($product['description']); ?></p>
                </div>
                
                <!-- Features List -->
                <?php if (!empty($product['features'])): ?>
                    <div class="features-box mb-4">
                        <h4 class="section-title-sm mb-3">Key Specifications & Features</h4>
                        <ul class="features-list">
                            <?php foreach ($product['features'] as $feature): ?>
                                <li>
                                    <i class="fa-solid fa-circle-check text-accent me-2"></i>
                                    <?php echo htmlspecialchars($feature); ?>
                                </li>
                            <?php endphp; ?>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Reviews Section -->
    <div class="row mt-5 pt-4 border-top">
        <!-- Left: Customer Reviews list -->
        <div class="col-lg-7">
            <div class="reviews-display-column">
                <h3 class="section-title mb-4">Customer Reviews</h3>
                
                <div id="customer-reviews" class="reviews-list-container d-flex flex-column gap-3">
                    <?php if (empty($display_reviews)): ?>
                        <div class="no-reviews-fallback text-center py-4 text-muted">
                            <i class="fa-regular fa-comments fa-3x mb-3 text-secondary"></i>
                            <p>No reviews yet. Be the first to write a review!</p>
                        </div>
                    <?php else: ?>
                        <?php foreach ($display_reviews as $review): ?>
                            <div class="review-card">
                                <div class="review-header d-flex justify-content-between mb-2">
                                    <h5 class="reviewer-name m-0"><i class="fa-solid fa-circle-user text-secondary me-2"></i><?php echo htmlspecialchars($review['name']); ?></h5>
                                    <div class="reviewer-stars text-warning">
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                    </div>
                                </div>
                                <p class="reviewer-comment m-0 text-muted"><?php echo htmlspecialchars($review['comment']); ?></p>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <!-- Right: Submit Review Form -->
        <div class="col-lg-5">
            <div class="review-form-card">
                <h3 class="section-title mb-4">Leave a Review</h3>
                <form id="review-form" action="product.php?id=<?php echo urlencode($product_id); ?>" method="POST" class="d-flex flex-column gap-3">
                    <div class="form-group">
                        <label for="reviewer-name" class="form-label fw-semibold">Your Name</label>
                        <input type="text" id="reviewer-name" name="name" class="form-control" placeholder="Enter your name" required 
                               value="<?php echo isset($_SESSION['Username']) ? htmlspecialchars($_SESSION['Username']) : ''; ?>">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label fw-semibold">Your Rating</label>
                        <div class="star-rating-selector d-flex gap-2">
                            <input type="hidden" name="rating" id="rating-value" value="5">
                            <i class="fa-regular fa-star star-select" data-value="1"></i>
                            <i class="fa-regular fa-star star-select" data-value="2"></i>
                            <i class="fa-regular fa-star star-select" data-value="3"></i>
                            <i class="fa-regular fa-star star-select" data-value="4"></i>
                            <i class="fa-solid fa-star star-select select-filled" data-value="5"></i>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="reviewer-comment" class="form-label fw-semibold">Your Comment</label>
                        <textarea id="reviewer-comment" name="comment" rows="4" class="form-control" placeholder="Share your experience with this product..." required></textarea>
                    </div>
                    
                    <button type="submit" name="submit_review" class="btn btn-submit-review py-2 mt-2">
                        <i class="fa-solid fa-paper-plane me-2"></i>Submit Review
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JS star rating code extension -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    const stars = document.querySelectorAll(".star-select");
    const ratingInput = document.getElementById("rating-value");
    
    stars.forEach(star => {
        star.addEventListener("click", function() {
            const selectedVal = parseInt(this.getAttribute("data-value"));
            ratingInput.value = selectedVal;
            
            stars.forEach(s => {
                const sVal = parseInt(s.getAttribute("data-value"));
                if(sVal <= selectedVal) {
                    s.classList.remove("fa-regular");
                    s.classList.add("fa-solid", "select-filled");
                } else {
                    s.classList.remove("fa-solid", "select-filled");
                    s.classList.add("fa-regular");
                }
            });
        });
    });
});
</script>

<?php include('footer.php'); ?>
