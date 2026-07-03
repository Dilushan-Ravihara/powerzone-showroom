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
    header("Location: index.php");
    exit();
}

$product = $products_data[$product_id];

// 3. Database connection check
include('db.php'); // loads $conn

$db_available = false;
if (isset($conn) && $conn instanceof mysqli && !$conn->connect_error) {
    $table_check = $conn->query("SHOW TABLES LIKE 'orders'");
    if ($table_check && $table_check->num_rows > 0) {
        $db_available = true;
    }
}

// 4. Handle checkout submission (POST)
$order_placed = false;
$order_id = "";
$error_msg = "";
$p_method = "COD";
$p_status = "Unpaid";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['place_order'])) {
    $cust_name = isset($_POST['customer_name']) ? trim(htmlspecialchars($_POST['customer_name'])) : '';
    $cust_email = isset($_POST['email']) ? trim(htmlspecialchars($_POST['email'])) : '';
    $cust_phone = isset($_POST['phone']) ? trim(htmlspecialchars($_POST['phone'])) : '';
    $cust_address = isset($_POST['address']) ? trim(htmlspecialchars($_POST['address'])) : '';
    $selected_payment = isset($_POST['payment_option']) ? trim($_POST['payment_option']) : 'COD';
    
    if ($cust_name !== '' && $cust_email !== '' && $cust_phone !== '' && $cust_address !== '') {
        $amount = $product['price'];
        
        if ($selected_payment === 'card') {
            $p_method = "Card";
            $p_status = "Paid"; // Online card payment processed successfully!
        } else {
            $p_method = "COD";
            $p_status = "Unpaid";
        }
        
        if ($db_available) {
            // Save to MySQL orders table with payment columns
            $stmt = $conn->prepare("INSERT INTO orders (product_id, product_name, customer_name, email, phone, address, amount, payment_method, payment_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssssss", $product_id, $product['name'], $cust_name, $cust_email, $cust_phone, $cust_address, $amount, $p_method, $p_status);
            if ($stmt->execute()) {
                $order_id = "ORD-" . str_pad($stmt->insert_id, 5, '0', STR_PAD_LEFT);
                $order_placed = true;
            } else {
                $error_msg = "Database error saving order: " . $stmt->error;
            }
            $stmt->close();
        } else {
            // Fallback: Save to orders.json local database
            $orders_file = 'orders.json';
            $orders_data = [];
            if (file_exists($orders_file)) {
                $orders_data = json_decode(file_get_contents($orders_file), true);
            }
            
            $next_id = count($orders_data) + 1;
            $new_order_num = "ORD-" . str_pad($next_id, 5, '0', STR_PAD_LEFT);
            
            $new_order = [
                'id' => $next_id,
                'order_id' => $new_order_num,
                'product_id' => $product_id,
                'product_name' => $product['name'],
                'customer_name' => $cust_name,
                'email' => $cust_email,
                'phone' => $cust_phone,
                'address' => $cust_address,
                'amount' => $amount,
                'payment_method' => $p_method,
                'payment_status' => $p_status,
                'status' => 'Pending',
                'created_at' => date('Y-m-d H:i:s')
            ];
            
            $orders_data[] = $new_order;
            
            if (file_put_contents($orders_file, json_encode($orders_data, JSON_PRETTY_PRINT))) {
                $order_id = $new_order_num;
                $order_placed = true;
            } else {
                $error_msg = "Local file permission error saving order details.";
            }
        }
    } else {
        $error_msg = "Please fill in all required checkout fields.";
    }
}

include('header.php');
?>

<div class="checkout-page-container container py-5">
    <div class="text-center mb-5">
        <h1 class="section-title"><i class="fa-solid fa-credit-card me-2 text-accent"></i>Secure Checkout</h1>
        <p class="section-subtitle text-muted font-medium">Complete your order details & secure checkout payment below</p>
    </div>

    <?php if ($order_placed): ?>
        <!-- Success Screen -->
        <div class="checkout-success-card text-center py-5 px-4 glass-panel max-width-700 mx-auto rounded-4 shadow-lg border-accent animate-fade-in">
            <div class="success-icon-container mb-4">
                <div class="success-icon-circle shadow-md">
                    <i class="fa-solid fa-circle-check fa-4x text-success"></i>
                </div>
            </div>
            <h2 class="fw-bold mb-3 text-white">Order Placed Successfully!</h2>
            <p class="lead text-muted mb-4">Your purchase has been completed. Review the invoice receipt details below.</p>
            
            <div class="order-summary-box text-start bg-glass-dark p-4 rounded-3 border border-secondary mb-4 mx-auto" style="max-width: 500px;">
                <h4 class="mb-3 text-accent border-bottom pb-2"><i class="fa-solid fa-file-invoice me-2"></i>Invoice Details</h4>
                <p class="mb-2"><strong>Order ID:</strong> <span class="text-white"><?php echo $order_id; ?></span></p>
                <p class="mb-2"><strong>Product Name:</strong> <span class="text-white"><?php echo htmlspecialchars($product['name']); ?></span></p>
                <p class="mb-2"><strong>Price:</strong> <span class="text-white"><?php echo htmlspecialchars($product['price']); ?></span></p>
                <p class="mb-2"><strong>Payment Method:</strong> <span class="badge <?php echo $p_method === 'Card' ? 'bg-success' : 'bg-secondary'; ?> text-white"><?php echo $p_method === 'Card' ? 'Online Card (Paid)' : 'Cash on Delivery'; ?></span></p>
                <p class="mb-0"><strong>Estimated Delivery:</strong> <span class="text-white">2 - 3 Working Days</span></p>
            </div>
            
            <div class="success-actions d-flex justify-content-center gap-3">
                <a href="index.php" class="btn btn-hero-primary px-4"><i class="fa-solid fa-house me-2"></i>Back to Home</a>
                <a href="consumer.php" class="btn btn-hero-secondary px-4"><i class="fa-solid fa-cart-shopping me-2"></i>Continue Shopping</a>
            </div>
        </div>
    <?php else: ?>
        <!-- Error alert -->
        <?php if ($error_msg !== ""): ?>
            <div class="alert alert-danger alert-dismissible fade show max-width-900 mx-auto mb-4" role="alert">
                <i class="fa-solid fa-triangle-exclamation me-2"></i><?php echo $error_msg; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- Checkout Form Grid -->
        <div class="row g-5 max-width-1100 mx-auto">
            <!-- Left: Form -->
            <div class="col-lg-7">
                <div class="checkout-form-card glass-card p-4 p-md-5 rounded-4 shadow-sm">
                    <h3 class="mb-4 text-accent"><i class="fa-solid fa-truck-ramp-box me-2"></i>Shipping & Payment</h3>
                    
                    <form action="checkout.php?id=<?php echo urlencode($product_id); ?>" method="POST" id="checkout-form" class="d-flex flex-column gap-3">
                        <div class="form-group">
                            <label for="cust-name" class="form-label fw-semibold">Customer Full Name *</label>
                            <input type="text" id="cust-name" name="customer_name" class="form-control" placeholder="Enter your full name" required
                                   value="<?php echo isset($_SESSION['Username']) ? htmlspecialchars($_SESSION['Username']) : ''; ?>">
                        </div>
                        
                        <div class="form-group">
                            <label for="cust-email" class="form-label fw-semibold">Email Address *</label>
                            <input type="email" id="cust-email" name="email" class="form-control" placeholder="example@mail.com" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="cust-phone" class="form-label fw-semibold">Contact Phone Number *</label>
                            <input type="tel" id="cust-phone" name="phone" class="form-control" placeholder="+94 77 123 4567" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="cust-address" class="form-label fw-semibold">Shipping Address *</label>
                            <textarea id="cust-address" name="address" rows="3" class="form-control" placeholder="Enter full street address, city, and postal code" required></textarea>
                        </div>
                        
                        <!-- Interactive Payment Option Select -->
                        <div class="form-group">
                            <label class="form-label fw-semibold">Payment Option *</label>
                            <div class="payment-tabs-container d-flex gap-2 p-1 bg-timeline-track rounded-3 mb-3">
                                <button type="button" class="btn btn-payment-tab active" id="btn-pay-cod" data-method="cod">
                                    <i class="fa-solid fa-money-bill-wave me-2"></i>Cash on Delivery
                                </button>
                                <button type="button" class="btn btn-payment-tab" id="btn-pay-card" data-method="card">
                                    <i class="fa-solid fa-credit-card me-2"></i>Pay Online (Card)
                                </button>
                            </div>
                            
                            <!-- Hidden input field for form post -->
                            <input type="hidden" name="payment_option" id="payment-option-input" value="cod">
                            
                            <!-- Online Credit Card Simulator (Dynamic Slide Drawer) -->
                            <div class="credit-card-simulator-drawer mt-3 d-none animate-fade-in">
                                <!-- Interactive 3D Card Display -->
                                <div class="credit-card-box mb-4 mx-auto">
                                    <div class="credit-card-inner">
                                        <!-- Card Front Face -->
                                        <div class="card-face card-front shadow-lg">
                                            <div class="card-logo-row d-flex justify-content-between align-items-center">
                                                <i class="fa-solid fa-microchip card-chip-icon"></i>
                                                <span id="card-brand-logo" class="card-brand-text"><i class="fa-brands fa-cc-visa fa-2x"></i></span>
                                            </div>
                                            <div class="card-number-row mt-4">
                                                <span id="card-display-number" class="card-num-text">•••• •••• •••• ••••</span>
                                            </div>
                                            <div class="card-info-row d-flex justify-content-between mt-4">
                                                <div>
                                                    <span class="card-lbl">Card Holder</span>
                                                    <span id="card-display-name" class="card-val-text">FULL NAME</span>
                                                </div>
                                                <div class="text-end">
                                                    <span class="card-lbl">Expires</span>
                                                    <span id="card-display-expiry" class="card-val-text">MM/YY</span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Card Back Face -->
                                        <div class="card-face card-back shadow-lg">
                                            <div class="card-magnetic-strip"></div>
                                            <div class="card-cvv-section px-3 mt-4">
                                                <span class="card-lbl d-block text-end">CVV</span>
                                                <div class="card-signature-bar d-flex justify-content-end align-items-center pr-3">
                                                    <span id="card-display-cvv" class="card-cvv-text fw-bold">•••</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Card Fields Inputs -->
                                <div class="row g-2 card-inputs-grid">
                                    <div class="col-12">
                                        <input type="text" id="card-number-input" class="form-control form-control-sm" placeholder="Card Number (16 Digits)" maxlength="19">
                                    </div>
                                    <div class="col-12">
                                        <input type="text" id="card-name-input" class="form-control form-control-sm text-uppercase" placeholder="Cardholder Name">
                                    </div>
                                    <div class="col-6">
                                        <input type="text" id="card-expiry-input" class="form-control form-control-sm" placeholder="MM/YY" maxlength="5">
                                    </div>
                                    <div class="col-6">
                                        <input type="password" id="card-cvv-input" class="form-control form-control-sm" placeholder="CVV" maxlength="3">
                                    </div>
                                </div>
                            </div>
                            
                            <!-- COD helper notice -->
                            <div class="cod-helper-notice p-3 rounded-3 border border-secondary bg-glass-dark mt-3">
                                <p class="text-white fw-medium mb-1"><i class="fa-solid fa-circle-info text-accent me-2"></i>Cash on Delivery Selected</p>
                                <p class="text-muted text-sm m-0">No online payment required. Pay by cash when the parcel is delivered to your address.</p>
                            </div>
                        </div>
                        
                        <button type="submit" name="place_order" class="btn btn-place-order py-3 mt-3" id="submit-order-btn">
                            <i class="fa-solid fa-lock me-2"></i>Place Order (Cash On Delivery)
                        </button>
                    </form>
                </div>
            </div>

            <!-- Right: Order Summary -->
            <div class="col-lg-5">
                <div class="checkout-summary-card glass-card p-4 rounded-4 shadow-sm position-sticky" style="top: 100px;">
                    <h3 class="mb-4 text-accent"><i class="fa-solid fa-cart-flatbed me-2"></i>Order Summary</h3>
                    
                    <div class="checkout-product-details text-center border-bottom pb-4 mb-4">
                        <div class="checkout-img-container mb-3 bg-glass-dark p-3 rounded-3">
                            <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="img-fluid" style="max-height: 150px; object-fit: contain;">
                        </div>
                        <h4 class="product-title-summary font-bold text-white"><?php echo htmlspecialchars($product['name']); ?></h4>
                        <span class="text-muted text-uppercase text-xs"><?php echo htmlspecialchars($product['category']); ?> Item</span>
                    </div>
                    
                    <div class="checkout-price-panel d-flex flex-column gap-2 mb-4">
                        <div class="d-flex justify-content-between text-muted">
                            <span>Subtotal:</span>
                            <span class="fw-semibold text-white"><?php echo htmlspecialchars($product['price']); ?></span>
                        </div>
                        <div class="d-flex justify-content-between text-muted">
                            <span>Delivery Charges:</span>
                            <span class="text-success fw-semibold">FREE</span>
                        </div>
                        <hr class="my-2 border-secondary">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="m-0 font-bold text-white">Total Amount:</h4>
                            <h3 class="text-accent m-0 font-bold"><?php echo htmlspecialchars($product['price']); ?></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<!-- Dynamic Payment Script handling Card Simulator animations -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    const btnCod = document.getElementById("btn-pay-cod");
    const btnCard = document.getElementById("btn-pay-card");
    const inputOption = document.getElementById("payment-option-input");
    const cardDrawer = document.querySelector(".credit-card-simulator-drawer");
    const codNotice = document.querySelector(".cod-helper-notice");
    const submitBtn = document.getElementById("submit-order-btn");
    
    // Forms validation links
    const cardNum = document.getElementById("card-number-input");
    const cardName = document.getElementById("card-name-input");
    const cardExpiry = document.getElementById("card-expiry-input");
    const cardCvv = document.getElementById("card-cvv-input");
    
    // Card mirrors
    const dNum = document.getElementById("card-display-number");
    const dName = document.getElementById("card-display-name");
    const dExpiry = document.getElementById("card-display-expiry");
    const dCvv = document.getElementById("card-display-cvv");
    const dBrand = document.getElementById("card-brand-logo");
    const cardBox = document.querySelector(".credit-card-box");
    
    // 1. Toggle Tab Actions
    btnCod.addEventListener("click", function() {
        btnCard.classList.remove("active");
        this.classList.add("active");
        inputOption.value = "cod";
        cardDrawer.classList.add("d-none");
        codNotice.classList.remove("d-none");
        submitBtn.innerHTML = '<i class="fa-solid fa-lock me-2"></i>Place Order (Cash On Delivery)';
        
        // Remove validations on Card fields
        cardNum.removeAttribute("required");
        cardName.removeAttribute("required");
        cardExpiry.removeAttribute("required");
        cardCvv.removeAttribute("required");
    });
    
    btnCard.addEventListener("click", function() {
        btnCod.classList.remove("active");
        this.classList.add("active");
        inputOption.value = "card";
        cardDrawer.classList.remove("d-none");
        codNotice.classList.add("d-none");
        submitBtn.innerHTML = '<i class="fa-solid fa-lock me-2"></i>Authorize Online Payment';
        
        // Add validations on Card fields
        cardNum.setAttribute("required", "");
        cardName.setAttribute("required", "");
        cardExpiry.setAttribute("required", "");
        cardCvv.setAttribute("required", "");
    });
    
    // 2. Card Spacing on numbers & Card Type detection
    cardNum.addEventListener("input", function(e) {
        let val = e.target.value.replace(/\D/g, '');
        
        // Dynamic Brand Detection
        if (val.startsWith("4")) {
            dBrand.innerHTML = '<i class="fa-brands fa-cc-visa fa-2x text-white"></i>';
        } else if (val.startsWith("5")) {
            dBrand.innerHTML = '<i class="fa-brands fa-cc-mastercard fa-2x text-warning"></i>';
        } else if (val.startsWith("3")) {
            dBrand.innerHTML = '<i class="fa-brands fa-cc-amex fa-2x text-info"></i>';
        } else {
            dBrand.innerHTML = '<i class="fa-solid fa-credit-card fa-2x text-white"></i>';
        }
        
        // Group spacing (1234 5678 ...)
        let formatted = val.match(/.{1,4}/g);
        if (formatted) {
            e.target.value = formatted.join(' ');
            dNum.innerText = formatted.join(' ');
        } else {
            dNum.innerText = "•••• •••• •••• ••••";
        }
    });
    
    // 3. Name mirror
    cardName.addEventListener("input", function(e) {
        dName.innerText = e.target.value ? e.target.value.toUpperCase() : "FULL NAME";
    });
    
    // 4. Expiry spacing and mirror
    cardExpiry.addEventListener("input", function(e) {
        let val = e.target.value.replace(/\D/g, '');
        if (val.length >= 2) {
            e.target.value = val.substring(0, 2) + '/' + val.substring(2, 4);
            dExpiry.innerText = e.target.value;
        } else {
            dExpiry.innerText = val ? val : "MM/YY";
        }
    });
    
    // 5. CVV flip trigger & CVV mirror
    cardCvv.addEventListener("input", function(e) {
        let val = e.target.value.replace(/\D/g, '');
        dCvv.innerText = val ? "•".repeat(val.length) : "•••";
    });
    
    cardCvv.addEventListener("focus", function() {
        cardBox.classList.add("flipped");
    });
    
    cardCvv.addEventListener("blur", function() {
        cardBox.classList.remove("flipped");
    });
});
</script>

<?php include('footer.php'); ?>
