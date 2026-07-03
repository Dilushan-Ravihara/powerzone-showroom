<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include database connection
include('db.php');

$error_msg = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = isset($_POST['Username']) ? trim($_POST['Username']) : '';
    $password = isset($_POST['Password']) ? trim($_POST['Password']) : '';

    if (!empty($username) && !empty($password)) {
        // Sanitize input to prevent SQL injection
        $username = mysqli_real_escape_string($conn, $username);

        // Query unified 'users' table
        $sql = "SELECT * FROM users WHERE username='$username'";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            // Verify password using bcrypt (verify against hash)
            if (password_verify($password, $row['password'])) {
                $_SESSION['Username'] = $row['username'];
                $_SESSION['Name'] = $row['name'];
                $_SESSION['id'] = $row['id'];
                
                header("Location: index.php");
                exit();
            } else {
                $error_msg = "Invalid password. Please try again.";
            }
        } else {
            $error_msg = "Username not found. Please register first.";
        }
    } else {
        $error_msg = "Please enter both Username and Password.";
    }
}

// If user is already logged in, redirect to home
if (isset($_SESSION['Username'])) {
    header("Location: index.php");
    exit();
}

include('header.php');
?>

<div class="auth-page-wrapper container py-5 d-flex justify-content-center align-items-center">
    <div class="auth-card" id="log-in">
        <div class="row g-0">
            <!-- Info Sidebar banner -->
            <div class="col-md-5 d-flex flex-column justify-content-center text-center p-4 auth-sidebar" id="slide1">
                <h3 class="auth-sidebar-title">Welcome Back!</h3>
                <p class="auth-sidebar-desc mt-2">Connect to your PowerZone account to explore exclusive offers.</p>
                <div class="logo-display mt-4">
                    <span class="logo-power">Power</span><span class="logo-zone">Zone.lk</span>
                </div>
            </div>
            
            <!-- Login Form block -->
            <div class="col-md-7 p-5 auth-form-container" id="slide2">
                <h3 class="text-center auth-title">Account Login</h3>
                <p class="text-center text-muted mb-4">Login to your account to continue</p>
                
                <?php if ($error_msg !== ""): ?>
                    <div class="alert alert-danger d-flex align-items-center gap-2" role="alert">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                        <div><?php echo $error_msg; ?></div>
                    </div>
                <?php endif; ?>
                
                <form action="login.php" method="POST" class="d-flex flex-column gap-3 mt-3">
                    <div class="form-floating input2">
                        <input type="text" class="form-control" id="floatingUsername" name="Username" placeholder="Username" required autocomplete="username">
                        <label for="floatingUsername"><i class="fa-solid fa-user me-2"></i>Username</label>
                    </div>
                    
                    <div class="form-floating input2">
                        <input type="password" class="form-control" id="floatingPassword" name="Password" placeholder="Password" required autocomplete="current-password">
                        <label for="floatingPassword"><i class="fa-solid fa-key me-2"></i>Password</label>
                    </div>
                    
                    <button type="submit" class="btn btn-auth py-2 mt-3">
                        <i class="fa-solid fa-arrow-right-to-bracket me-2"></i>Log-In
                    </button>
                    
                    <p class="text-center mt-3 mb-0 register-prompt text-muted">
                        Don't have an account? <a href="register.php" class="fw-semibold text-accent">Register here</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>