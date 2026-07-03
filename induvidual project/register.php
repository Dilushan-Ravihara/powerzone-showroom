<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include('db.php');

$error_msg = "";
$success_msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';

    if (!empty($name) && !empty($username) && !empty($phone) && !empty($email) && !empty($password)) {
        // Sanitize database inputs
        $name = mysqli_real_escape_string($conn, $name);
        $username = mysqli_real_escape_string($conn, $username);
        $phone = mysqli_real_escape_string($conn, $phone);
        $email = mysqli_real_escape_string($conn, $email);
        
        // Check if username already exists in unified 'users' table
        $check_sql = "SELECT id FROM users WHERE username='$username'";
        $check_result = $conn->query($check_sql);
        
        if ($check_result && $check_result->num_rows > 0) {
            $error_msg = "Username already exists. Please choose a different one.";
        } else {
            // Hash password using BCRYPT
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            
            // Insert user details into unified 'users' table
            $sql = "INSERT INTO users (name, username, phone, email, password) 
                    VALUES ('$name', '$username', '$phone', '$email', '$hashed_password')";
            
            if ($conn->query($sql) === TRUE) {
                // Successful registration
                $success_msg = "Registration successful! Redirecting to login...";
                // Redirect after 2 seconds
                header("refresh:2;url=login.php");
            } else {
                $error_msg = "Error registering user: " . $conn->error;
            }
        }
    } else {
        $error_msg = "Please fill in all fields.";
    }
}

// Redirect already logged-in users to home
if (isset($_SESSION['Username'])) {
    header("Location: index.php");
    exit();
}

include('header.php');
?>

<div class="auth-page-wrapper container py-5 d-flex justify-content-center align-items-center">
    <div class="auth-card" id="register">
        <div class="row g-0">
            <!-- Info Sidebar banner -->
            <div class="col-md-5 d-flex flex-column justify-content-center text-center p-4 auth-sidebar" id="slide1">
                <h3 class="auth-sidebar-title">Join Us!</h3>
                <p class="auth-sidebar-desc mt-2">Create a new account and access all PowerZone features.</p>
                <div class="logo-display mt-4">
                    <span class="logo-power">Power</span><span class="logo-zone">Zone.lk</span>
                </div>
            </div>
            
            <!-- Register Form block -->
            <div class="col-md-7 p-5 auth-form-container" id="slide2">
                <h3 class="text-center auth-title">Create Account</h3>
                <p class="text-center text-muted mb-4">Fill in the details below to register</p>
                
                <?php if ($error_msg !== ""): ?>
                    <div class="alert alert-danger d-flex align-items-center gap-2" role="alert">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                        <div><?php echo $error_msg; ?></div>
                    </div>
                <?php elseif ($success_msg !== ""): ?>
                    <div class="alert alert-success d-flex align-items-center gap-2" role="alert">
                        <i class="fa-solid fa-circle-check"></i>
                        <div><?php echo $success_msg; ?></div>
                    </div>
                <?php endif; ?>
                
                <form action="register.php" method="POST" class="d-flex flex-column gap-2 mt-3">
                    <div class="form-floating input2">
                        <input type="text" class="form-control" id="floatingName" name="name" placeholder="Full Name" required autocomplete="name">
                        <label for="floatingName"><i class="fa-solid fa-user-tag me-2"></i>Full Name</label>
                    </div>
                    
                    <div class="form-floating input2">
                        <input type="text" class="form-control" id="floatingRegUsername" name="username" placeholder="Username" required autocomplete="username">
                        <label for="floatingRegUsername"><i class="fa-solid fa-user me-2"></i>Username</label>
                    </div>
                    
                    <div class="form-floating input2">
                        <input type="tel" class="form-control" id="floatingPhone" name="phone" placeholder="Phone" required autocomplete="tel">
                        <label for="floatingPhone"><i class="fa-solid fa-phone me-2"></i>Phone Number</label>
                    </div>
                    
                    <div class="form-floating input2">
                        <input type="email" class="form-control" id="floatingEmail" name="email" placeholder="Email" required autocomplete="email">
                        <label for="floatingEmail"><i class="fa-solid fa-envelope me-2"></i>Email Address</label>
                    </div>
                    
                    <div class="form-floating input2">
                        <input type="password" class="form-control" id="floatingRegPassword" name="password" placeholder="Password" required autocomplete="new-password">
                        <label for="floatingRegPassword"><i class="fa-solid fa-key me-2"></i>Password</label>
                    </div>
                    
                    <button type="submit" class="btn btn-auth py-2 mt-3">
                        <i class="fa-solid fa-user-plus me-2"></i>Sign-up
                    </button>
                    
                    <p class="text-center mt-3 mb-0 register-prompt text-muted">
                        Already have an account? <a href="login.php" class="fw-semibold text-accent">Login here</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>
