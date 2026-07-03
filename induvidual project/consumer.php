<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Load products
$products_file = 'products.json';
$products = [];
if (file_exists($products_file)) {
    $products = json_decode(file_get_contents($products_file), true);
}

include('header.php');
?>

<div class="category-page-wrapper container py-5">
    <div class="text-center mb-5">
        <h1 class="section-title">Consumer Electronics</h1>
        <p class="section-subtitle text-muted">Discover state-of-the-art tech gadgets and entertainment setups</p>
    </div>

    <!-- Product Grid -->
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4" id="Product-list">
        <?php 
        $has_items = false;
        foreach ($products as $id => $product): 
            if ($product['category'] === 'consumer'):
                $has_items = true;
        ?>
            <div class="col">
                <div class="product-item-card h-100 glass-card">
                    <span class="badge-category text-uppercase"><?php echo htmlspecialchars($product['category']); ?></span>
                    <div class="product-img-wrapper">
                        <a href="product.php?id=<?php echo $id; ?>">
                            <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="img-fluid">
                        </a>
                    </div>
                    <div class="product-card-body p-3 text-center">
                        <h4 class="product-card-title"><?php echo htmlspecialchars($product['name']); ?></h4>
                        <h5 class="product-card-price text-accent"><?php echo htmlspecialchars($product['price']); ?></h5>
                        <a href="product.php?id=<?php echo $id; ?>" class="btn btn-view-product w-100 mt-3">View Details</a>
                    </div>
                </div>
            </div>
        <?php 
            endif;
        endforeach; 
        
        if (!$has_items):
        ?>
            <div class="col-12 text-center py-5">
                <i class="fa-solid fa-box-open fa-3x text-muted mb-3"></i>
                <p class="text-muted">No consumer electronic items found in inventory.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include('footer.php'); ?>
