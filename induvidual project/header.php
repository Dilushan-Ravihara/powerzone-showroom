<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PowerZone.lk - Powering Your World</title>
    
    <!-- Google Fonts: Inter for text, Outfit for headings -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <!-- Custom Style Sheet -->
    <link rel="stylesheet" href="style.css">
</head>
<body id="body">
    <!-- Top Navbar (Live Clock, Present Time Greeting, Auth Info, Theme Toggle) -->
    <div class="top-navbar">
        <div class="top-nav-container container-fluid d-flex justify-content-between align-items-center">
            <!-- Dynamic Present Time Matching Display -->
            <div class="time-matching-panel d-flex align-items-center gap-2">
                <i class="fa-regular fa-clock clock-pulse-icon"></i>
                <span id="live-clock" class="fw-medium">--:--:-- AM</span>
                <span class="separator">|</span>
                <span id="time-greeting" class="fw-semibold text-accent">Welcome to PowerZone.lk</span>
            </div>
            
            <div class="top-nav-right d-flex align-items-center gap-4">
                <!-- Theme Toggle Switch -->
                <button id="theme-toggle-btn" class="theme-toggle-btn" aria-label="Toggle dark/light mode">
                    <i class="fa-solid fa-moon"></i>
                </button>
                
                <!-- Auth Info Display -->
                <div class="auth-links d-flex align-items-center gap-3">
                    <?php if (isset($_SESSION['Username'])): ?>
                        <span class="user-welcome-badge">
                            <i class="fa-solid fa-circle-user text-accent me-1"></i>
                            Hi, <strong class="user-name-highlight"><?php echo htmlspecialchars($_SESSION['Username']); ?></strong>
                        </span>
                        <a href="logout.php" class="auth-link logout-btn">
                            <i class="fa-solid fa-sign-out-alt me-1"></i>Logout
                        </a>
                    <?php else: ?>
                        <a href="login.php" class="auth-link">
                            <i class="fa-solid fa-right-to-bracket me-1"></i>Log-in
                        </a>
                        <a href="register.php" class="auth-link">
                            <i class="fa-solid fa-user-plus me-1"></i>Register
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Main Sticky Navbar -->
    <nav class="navbar navbar-expand-lg sticky-top" id="navbar">
        <div class="container-fluid">
            <!-- Brand Logo -->
            <a class="navbar-brand d-flex align-items-center" href="index.php" id="logo">
                <span class="logo-power">Power</span>
                <span class="logo-zone">Zone.lk</span>
            </a>
            
            <!-- Mobile Toggle -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <!-- Navigation Links -->
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Categories
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="consumer.php"><i class="fa-solid fa-laptop me-2"></i>Consumer Electronics</a></li>
                            <li><a class="dropdown-item" href="household.php"><i class="fa-solid fa-blender me-2"></i>Household Appliances</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.php">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.php">Contact Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-warning fw-semibold" href="admin.php"><i class="fa-solid fa-gauge-high me-1"></i>Admin Panel</a>
                    </li>
                </ul>
                
                <!-- Search Form -->
                <form class="d-flex search-form" role="search" action="index.php" method="GET">
                    <div class="input-group">
                        <input class="form-control" type="search" placeholder="Search products..." aria-label="Search" name="search" id="search">
                        <button class="btn btn-search" type="submit" id="searchbutton">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </nav>
