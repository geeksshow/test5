<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>DND COMPUTERS - Premium Computer Hardware Store</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://unpkg.com/alpinejs" defer></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #000;
            color: #fff;
            overflow-x: hidden;
        }

        /* Navigation Styles */
        .navbar-custom {
            background: rgba(0, 0, 0, 0.1) !important;
            backdrop-filter: blur(5px);
            padding: 1rem 0;
          
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .navbar-brand {
            font-weight: 800;
            font-size: 2rem;
            color: #fff !important;
            text-decoration: none;
            background: linear-gradient(45deg, #ffc107, #ffb400);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .navbar-nav .nav-link {
            color: #fff !important;
            font-weight: 500;
            margin: 0 0.5rem;
            padding: 0.5rem 1rem !important;
            border-radius: 25px;
            transition: all 0.3s ease;
            position: relative;
        }

        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-link.active {
            color: #ffc107 !important;
            background-color: rgba(255, 193, 7, 0.1);
            transform: translateY(-2px);
        }

        .navbar-icons {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .navbar-icons span {
            color: #fff;
            font-size: 1.2rem;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 50%;
            transition: all 0.3s ease;
            position: relative;
        }

        .navbar-icons span:hover {
            color: #ffc107;
            background-color: rgba(255, 193, 7, 0.1);
            transform: translateY(-2px);
        }

        .cart-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #ffc107;
            color: #000;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 0.7rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }

        .login-btn {
            background: linear-gradient(45deg, #ffc107, #ffb400);
            color: #000;
            border: none;
            padding: 0.5rem 1.5rem;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(255, 193, 7, 0.4);
            color: #000;
        }

        .logout-btn {
            background: linear-gradient(45deg, #dc3545, #c82333);
            color: #fff;
            border: none;
            padding: 0.5rem 1.5rem;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .logout-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(220, 53, 69, 0.4);
            color: #fff;
            background: linear-gradient(45deg, #c82333, #bd2130);
        }

        /* Hero Section */
        .hero-section {
            min-height: 100vh;
            background: linear-gradient(135deg, #000 0%, #1a1a1a 50%, #000 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
            text-align: center;
        }

        /* Video Background Styles */
        .hero-video-background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: 1;
            opacity: 0.6;
            transition: opacity 0.5s ease;
        }

        .hero-video-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, 
                rgba(0, 0, 0, 0.4) 0%, 
                rgba(26, 26, 26, 0.3) 50%, 
                rgba(0, 0, 0, 0.4) 100%);
            z-index: 1;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><defs><radialGradient id="a" cx="50%" cy="50%"><stop offset="0%" stop-color="%23ffc107" stop-opacity="0.1"/><stop offset="100%" stop-color="%23000" stop-opacity="0"/></radialGradient></defs><circle cx="200" cy="200" r="100" fill="url(%23a)"/><circle cx="800" cy="300" r="150" fill="url(%23a)"/><circle cx="400" cy="700" r="120" fill="url(%23a)"/></svg>');
            animation: float 20s ease-in-out infinite;
            z-index: 2;
        }

        /* Video Loading and Fallback */
        .video-loading {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: #ffc107;
            font-size: 1.2rem;
            z-index: 1;
        }

        .video-fallback {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #000 0%, #1a1a1a 50%, #000 100%);
            z-index: 1;
        }

        /* Responsive Video Adjustments */
        @media (max-width: 768px) {
            .hero-video-background {
                opacity: 0.5;
            }
            
            .hero-video-overlay {
                background: linear-gradient(135deg, 
                    rgba(0, 0, 0, 0.7) 0%, 
                    rgba(26, 26, 26, 0.6) 50%, 
                    rgba(0, 0, 0, 0.7) 100%);
            }
        }

        @media (max-width: 480px) {
            .hero-video-background {
                opacity: 0.4;
            }
            
            .hero-video-overlay {
                background: linear-gradient(135deg, 
                    rgba(0, 0, 0, 0.8) 0%, 
                    rgba(26, 26, 26, 0.7) 50%, 
                    rgba(0, 0, 0, 0.8) 100%);
            }
        }

        /* Video Playback Controls */
        .video-controls {
            position: absolute;
            bottom: 20px;
            right: 20px;
            z-index: 10;
            display: flex;
            gap: 10px;
        }

        .video-control-btn {
            background: rgba(0, 0, 0, 0.7);
            border: 1px solid rgba(255, 193, 7, 0.3);
            color: #ffc107;
            padding: 8px 12px;
            border-radius: 20px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 0.9rem;
            backdrop-filter: blur(10px);
        }

        .video-control-btn:hover {
            background: rgba(255, 193, 7, 0.2);
            border-color: #ffc107;
            transform: translateY(-2px);
        }

        .video-control-btn:active {
            transform: translateY(0);
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }

        .hero-content {
            position: relative;
            z-index: 2;
            max-width: 800px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        .hero-title {
            font-size: 2.5rem;
            font-weight: 900;
            line-height: 1.1;
            margin-bottom: 1.5rem;
            background: linear-gradient(45deg, #fff, #ffc107);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-align: center;
        }

        .hero-subtitle {
            font-size: 1rem;
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 2rem;
            line-height: 1.6;
            text-align: center;
        }

        .hero-cta {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
        }

        .btn-primary-custom {
            background: linear-gradient(45deg, #ffc107, #ffb400);
            color: #000;
            border: none;
            padding: 0.8rem 1.5rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-primary-custom:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(255, 193, 7, 0.4);
            color: #000;
        }

        .btn-secondary-custom {
            background: transparent;
            color: #fff;
            border: 2px solid rgba(255, 255, 255, 0.3);
            padding: 0.8rem 1.5rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-secondary-custom:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: #ffc107;
            color: #ffc107;
            transform: translateY(-3px);
        }

        /* Featured Products Section */
        .featured-section {
            padding: 5rem 0;
            background: linear-gradient(135deg, #1a1a1a 0%, #000 100%);
        }

        .section-title {
            text-align: center;
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 1rem;
            background: linear-gradient(45deg, #fff, #ffc107);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .section-subtitle {
            text-align: center;
            font-size: 1.2rem;
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 3rem;
        }

        .product-card {
            background: rgba(20, 20, 20, 0.8);
            border-radius: 20px;
            padding: 2rem;
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
            height: 100%;
            position: relative;
            overflow: hidden;
        }

        .product-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(45deg, #ffc107, #ffb400);
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .product-card:hover::before {
            transform: scaleX(1);
        }

        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            border-color: rgba(255, 193, 7, 0.3);
        }

        .product-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 15px;
            margin-bottom: 1.5rem;
        }

        .product-title {
            color: #fff;
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            line-height: 1.3;
        }

        .product-price {
            color: #ffc107;
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .product-description {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.9rem;
            margin-bottom: 1.5rem;
            line-height: 1.5;
        }

        .add-to-cart-btn {
            background: linear-gradient(45deg, #ffc107, #ffb400);
            color: #000;
            border: none;
            padding: 0.8rem 1.5rem;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .add-to-cart-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(255, 193, 7, 0.4);
        }

        /* Categories Section */
        .categories-section {
            padding: 5rem 0;
            background: #000;
        }

        .category-card {
            background: linear-gradient(135deg, rgba(255, 193, 7, 0.1), rgba(255, 180, 0, 0.05));
            border-radius: 20px;
            padding: 3rem 2rem;
            text-align: center;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 193, 7, 0.2);
            height: 100%;
        }

        .category-card:hover {
            transform: translateY(-10px);
            background: linear-gradient(135deg, rgba(255, 193, 7, 0.2), rgba(255, 180, 0, 0.1));
            box-shadow: 0 20px 40px rgba(255, 193, 7, 0.1);
        }

        .category-icon {
            font-size: 4rem;
            color: #ffc107;
            margin-bottom: 1.5rem;
        }

        .category-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #fff;
            margin-bottom: 1rem;
        }

        .category-description {
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        .category-link {
            color: #ffc107;
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
        }

        .category-link:hover {
            color: #ffb400;
            transform: translateX(5px);
        }

        /* Stats Section */
        .stats-section {
            padding: 5rem 0;
            background: linear-gradient(135deg, #1a1a1a 0%, #000 100%);
        }

        .stat-card {
            text-align: center;
            padding: 2rem;
        }

        .stat-number {
            font-size: 3rem;
            font-weight: 900;
            color: #ffc107;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            font-size: 1.1rem;
            color: rgba(255, 255, 255, 0.8);
            font-weight: 500;
        }

        /* Footer */
        .footer {
            background: #000;
            padding: 3rem 0 1rem;
            border-top: 1px solid rgba(255, 193, 7, 0.2);
        }

        .footer-content {
            color: rgba(255, 255, 255, 0.8);
            text-align: center;
        }

        .footer-brand {
            font-size: 1.5rem;
            font-weight: 700;
            color: #ffc107;
            margin-bottom: 1rem;
        }

        .footer-links {
            display: flex;
            justify-content: center;
            gap: 2rem;
            margin-bottom: 2rem;
            flex-wrap: wrap;
        }

        .footer-links a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer-links a:hover {
            color: #ffc107;
        }

        .social-links {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .social-links a {
            color: rgba(255, 255, 255, 0.7);
            font-size: 1.5rem;
            transition: all 0.3s ease;
        }

        .social-links a:hover {
            color: #ffc107;
            transform: translateY(-2px);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2rem;
            }
            
            .hero-subtitle {
                font-size: 0.9rem;
            }
            
            .section-title {
                font-size: 1.8rem;
            }
            
            .hero-cta {
                flex-direction: column;
                align-items: center;
                width: 100%;
            }
            
            .btn-primary-custom,
            .btn-secondary-custom {
                width: 100%;
                max-width: 300px;
                justify-content: center;
                font-size: 0.9rem;
                padding: 0.7rem 1.3rem;
            }

            .hero-content {
                padding: 0 1rem;
            }
        }

        @media (max-width: 480px) {
            .hero-content {
                padding: 0 0.5rem;
            }
            
            .hero-title {
                font-size: 1.8rem;
            }
            
            .hero-subtitle {
                font-size: 0.85rem;
            }

            .btn-primary-custom,
            .btn-secondary-custom {
                font-size: 0.85rem;
                padding: 0.6rem 1.2rem;
            }
        }

        /* Loading Animation */
        .loading {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 9999;
        }

        .loading.show {
            display: block;
        }

        /* Scroll Animations */
        .fade-in {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s ease;
        }

        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* Mobile Sidebar Styles */
        .mobile-sidebar {
            position: fixed;
            top: 0;
            right: -300px; /* Hidden by default */
            width: 280px;
            height: 100%;
            background: rgba(20, 20, 20, 0.98);
            box-shadow: -5px 0 15px rgba(0, 0, 0, 0.5);
            z-index: 1001;
            transition: right 0.3s ease-in-out;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            padding: 1rem;
        }

        .mobile-sidebar.open {
            right: 0;
        }

        .sidebar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid rgba(255, 193, 7, 0.2);
        }

        .sidebar-header h5 {
            color: #ffc107;
            font-size: 1.2rem;
        }

        .close-btn {
            background: none;
            border: none;
            color: #fff;
            font-size: 1.5rem;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 50%;
            transition: background-color 0.3s ease;
        }

        .close-btn:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .sidebar-content {
            flex-grow: 1;
        }

        .sidebar-section {
            margin-bottom: 2rem;
        }

        .sidebar-section h6 {
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 1rem;
            padding-bottom: 0.8rem;
            border-bottom: 1px solid rgba(255, 193, 7, 0.1);
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            color: #fff;
            text-decoration: none;
            padding: 0.8rem 1rem;
            border-radius: 10px;
            transition: all 0.3s ease;
            margin-bottom: 0.5rem;
        }

        .sidebar-link:hover {
            background-color: rgba(255, 193, 7, 0.1);
            color: #ffc107;
            transform: translateX(5px);
        }

        .sidebar-link.active {
            background-color: rgba(255, 193, 7, 0.2);
            color: #ffc107;
            font-weight: 600;
        }

        .sidebar-link i {
            font-size: 1rem;
            margin-right: 0.8rem;
            color: #ffc107;
        }

        .sidebar-link.text-danger {
            color: #dc3545;
        }

        .sidebar-link.text-danger:hover {
            background-color: rgba(220, 53, 69, 0.1);
            color: #dc3545;
        }

        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            display: none;
        }

        .sidebar-overlay.show {
            display: block;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container">
            <!-- Left Side - Logo -->
            <div class="d-flex align-items-center">
                <a class="navbar-brand" href="/">DND COMPUTERS</a>
            </div>

            <!-- Center - Navigation Items -->
            <div class="navbar-nav d-none d-lg-flex mx-auto">
                <a class="nav-link active" href="/">Home</a>
                <a class="nav-link" href="/laptops">Laptops</a>
                <a class="nav-link" href="/keyboard">Keyboards</a>
                <a class="nav-link" href="/mouse">Mice</a>
            </div>

            <!-- Right Side - Icons and Login (Far Right) -->
            <div class="d-flex align-items-center ms-auto">
                <!-- Icons -->
                <div class="navbar-icons d-flex align-items-center me-3">
                    <span class="icon-search me-3" data-bs-toggle="tooltip" title="Search">
                        <i class="fas fa-search"></i>
                    </span>
                    <div id="authSection">
                        <span class="icon-user me-3" data-bs-toggle="tooltip" title="User Account" onclick="window.location.href='{{ route('jwt.login') }}'">
                            <i class="fas fa-user"></i>
                        </span>
                    </div>
                    <div id="userSection" class="d-none">
                        <div class="dropdown">
                            <span class="icon-user me-3 dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" style="cursor: pointer;">
                                <i class="fas fa-user-circle"></i>
                            </span>
                            <ul class="dropdown-menu dropdown-menu-end" style="background: rgba(20, 20, 20, 0.95); border: 1px solid rgba(255, 193, 7, 0.2);">
                                <li><h6 class="dropdown-header text-warning" id="userNameHeader">User Menu</h6></li>
                                <li><a class="dropdown-item text-white" href="#" onclick="showProfile()"><i class="fas fa-user me-2"></i>Profile</a></li>
                                <li><a class="dropdown-item text-white" href="#" onclick="showOrders()"><i class="fas fa-shopping-bag me-2"></i>My Orders</a></li>
                                <li><a class="dropdown-item text-white" href="#" onclick="showWishlist()"><i class="fas fa-heart me-2"></i>Wishlist</a></li>
                                <li><a class="dropdown-item text-white" href="#" onclick="showSettings()"><i class="fas fa-cog me-2"></i>Settings</a></li>
                                <li><hr class="dropdown-divider" style="border-color: rgba(255, 193, 7, 0.2);"></li>
                                <li><a class="dropdown-item text-danger" href="#" onclick="logout()"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                            </ul>
                        </div>
                    </div>
                    <span class="icon-cart me-3" data-bs-toggle="tooltip" title="Shopping Cart" onclick="window.location.href='/cart'">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="cart-badge" id="cartBadge" style="display: none;">0</span>
                    </span>
                </div>

                <!-- Login/Logout Button -->
                <div id="desktopLoginBtn">
                    <a href="{{ route('jwt.login') }}" class="login-btn d-none d-md-inline-block me-3">Login</a>
                </div>
                
                <div id="desktopLogoutBtn" class="d-none">
                    <button onclick="logout()" class="logout-btn d-none d-md-inline-block me-3">
                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                    </button>
                </div>
                
                <!-- Mobile Menu Toggle -->
                <button class="navbar-toggler d-lg-none" type="button" onclick="toggleMobileSidebar()">
                    <i class="fas fa-bars text-white"></i>
                </button>
            </div>
        </div>
    </nav>

    <!-- Mobile Sidebar -->
    <div id="mobileSidebar" class="mobile-sidebar">
        <div class="sidebar-header">
            <h5 class="text-warning mb-0">Menu</h5>
            <button class="close-btn" onclick="toggleMobileSidebar()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div class="sidebar-content">
            <div class="sidebar-section">
                <h6 class="text-white mb-3">Navigation</h6>
                <a href="/" class="sidebar-link active">
                    <i class="fas fa-home me-3"></i>Home
                </a>
                <a href="/laptops" class="sidebar-link">
                    <i class="fas fa-laptop me-3"></i>Laptops
                </a>
                <a href="/keyboard" class="sidebar-link">
                    <i class="fas fa-keyboard me-3"></i>Keyboards
                </a>
                <a href="/mouse" class="sidebar-link">
                    <i class="fas fa-mouse me-3"></i>Mice
                </a>
            </div>

            <div class="sidebar-section">
                <h6 class="text-white mb-3">Quick Actions</h6>
                <div id="mobileAuthSection">
                    <a href="{{ route('jwt.login') }}" class="sidebar-link">
                        <i class="fas fa-sign-in-alt me-3"></i>Login
                    </a>
                </div>
                <div id="mobileUserSection" class="d-none">
                    <div class="sidebar-link text-warning" style="background-color: rgba(255, 193, 7, 0.1);">
                        <i class="fas fa-user me-3"></i><span id="mobileUserName">User</span>
                    </div>
                    <a href="#" class="sidebar-link" onclick="showProfile()">
                        <i class="fas fa-user me-3"></i>Profile
                    </a>
                    <a href="#" class="sidebar-link" onclick="showOrders()">
                        <i class="fas fa-shopping-bag me-3"></i>My Orders
                    </a>
                    <a href="#" class="sidebar-link" onclick="showWishlist()">
                        <i class="fas fa-heart me-3"></i>Wishlist
                    </a>
                    <a href="#" class="sidebar-link" onclick="showSettings()">
                        <i class="fas fa-cog me-3"></i>Settings
                    </a>
                    <a href="#" class="sidebar-link text-danger" onclick="logout()">
                        <i class="fas fa-sign-out-alt me-3"></i>Logout
                    </a>
                </div>
                <a href="/cart" class="sidebar-link">
                    <i class="fas fa-shopping-cart me-3"></i>Cart
                </a>
                <span class="sidebar-link" onclick="toggleSearch()">
                    <i class="fas fa-search me-3"></i>Search
                </span>
            </div>
        </div>
    </div>

    <!-- Sidebar Overlay -->
    <div id="sidebarOverlay" class="sidebar-overlay" onclick="toggleMobileSidebar()"></div>

    <!-- Hero Section -->
    <section class="hero-section">
        <!-- Video Background -->
        <video id="heroVideo" class="hero-video-background" autoplay muted loop playsinline>
            <source src="/videos/hero-video.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        
        <!-- Video Overlay -->
        <div class="hero-video-overlay"></div>
        
        <!-- Video Loading Indicator -->
        <div class="video-loading">
            <i class="fas fa-spinner fa-spin"></i> Loading video...
        </div>
        
        <!-- Video Fallback Background -->
        <div class="video-fallback" style="display: none;"></div>
        
        <!-- Video Controls -->
        <div class="video-controls">
            <button id="playPauseBtn" class="video-control-btn" style="display: none;">
                <i class="fas fa-play"></i> Play
            </button>
            <button id="muteBtn" class="video-control-btn">
                <i class="fas fa-volume-mute"></i> Unmute
            </button>
        </div>

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-10 col-12">
                    <div class="hero-content fade-in">
                        <h1 class="hero-title">Premium Computer Hardware Store</h1>
                        <p class="hero-subtitle">
                            Discover the latest laptops, keyboards, and mice from top brands. 
                            Experience cutting-edge technology with unbeatable prices and exceptional service.
                        </p>
                        <div class="hero-cta">
                            <a href="/laptops" class="btn-primary-custom">
                                <i class="fas fa-laptop"></i>
                                Shop Laptops
                            </a>
                            <a href="#featured" class="btn-secondary-custom">
                                <i class="fas fa-star"></i>
                                View Featured
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Products Section -->
    <section id="featured" class="featured-section">
        <div class="container">
            <div class="fade-in">
                <h2 class="section-title">Featured Products</h2>
                <p class="section-subtitle">Handpicked premium products for tech enthusiasts</p>
            </div>
            
            <div class="row" id="featuredProducts">
                <!-- Featured products will be loaded here -->
                <div class="col-12 text-center">
                    <div class="loading show">
                        <i class="fas fa-spinner fa-spin fa-2x text-warning"></i>
                        <p class="mt-2">Loading featured products...</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="categories-section">
        <div class="container">
            <div class="fade-in">
                <h2 class="section-title">Shop by Category</h2>
                <p class="section-subtitle">Find exactly what you're looking for</p>
            </div>
            
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="category-card fade-in">
                        <div class="category-icon">
                            <i class="fas fa-laptop"></i>
                        </div>
                        <h3 class="category-title">Laptops</h3>
                        <p class="category-description">
                            High-performance laptops for gaming, work, and creativity. 
                            From ultrabooks to gaming rigs.
                        </p>
                        <a href="/laptops" class="category-link">
                            Explore Laptops <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="category-card fade-in">
                        <div class="category-icon">
                            <i class="fas fa-keyboard"></i>
                        </div>
                        <h3 class="category-title">Keyboards</h3>
                        <p class="category-description">
                            Mechanical and wireless keyboards for enhanced typing experience. 
                            Gaming and productivity focused.
                        </p>
                        <a href="/keyboard" class="category-link">
                            Explore Keyboards <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="category-card fade-in">
                        <div class="category-icon">
                            <i class="fas fa-mouse"></i>
                        </div>
                        <h3 class="category-title">Mice</h3>
                        <p class="category-description">
                            Precision mice for gaming and professional work. 
                            Wireless and wired options available.
                        </p>
                        <a href="/mouse" class="category-link">
                            Explore Mice <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-6">
                    <div class="stat-card fade-in">
                        <div class="stat-number">1000+</div>
                        <div class="stat-label">Happy Customers</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-card fade-in">
                        <div class="stat-number">500+</div>
                        <div class="stat-label">Products</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-card fade-in">
                        <div class="stat-number">24/7</div>
                        <div class="stat-label">Support</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-card fade-in">
                        <div class="stat-number">5★</div>
                        <div class="stat-label">Rating</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-brand">DND COMPUTERS</div>
                <div class="footer-links">
                    <a href="/">Home</a>
                    <a href="/laptops">Laptops</a>
                    <a href="/keyboard">Keyboards</a>
                    <a href="/mouse">Mice</a>
                    <a href="#contact">Contact</a>
                </div>
                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-linkedin"></i></a>
                </div>
                <p>&copy; 2025 DND COMPUTERS. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Initialize tooltips
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Load featured products
            loadFeaturedProducts();
            
            // Update cart badge
            updateCartBadge();
            
            // Check authentication
            checkAuth();
            
            // Initialize scroll animations
            initScrollAnimations();

            // Initialize video background
            initVideoBackground();
        });

        // Load featured products
        function loadFeaturedProducts() {
            fetch('/api/featured-products')
                .then(response => response.json())
                .then(data => {
                    const container = document.getElementById('featuredProducts');
                    container.innerHTML = '';
                    
                    if (data.products && data.products.length > 0) {
                        data.products.forEach(product => {
                            const productCard = createProductCard(product);
                            container.appendChild(productCard);
                        });
                    } else {
                        container.innerHTML = '<div class="col-12 text-center"><p class="text-muted">No featured products available.</p></div>';
                    }
                })
                .catch(error => {
                    console.error('Error loading featured products:', error);
                    document.getElementById('featuredProducts').innerHTML = 
                        '<div class="col-12 text-center"><p class="text-muted">Error loading products.</p></div>';
                });
        }

        // Create product card
        function createProductCard(product) {
            const col = document.createElement('div');
            col.className = 'col-lg-4 col-md-6 mb-4';
            
            col.innerHTML = `
                <div class="product-card fade-in">
                    <img src="${product.image || 'https://via.placeholder.com/300x200/2a2a2a/ffc107?text=Product'}" 
                         alt="${product.name}" 
                         class="product-image">
                    <h5 class="product-title">${product.name}</h5>
                    <div class="product-price">$${parseFloat(product.price).toFixed(2)}</div>
                    <p class="product-description">${product.description.substring(0, 100)}...</p>
                    <button class="add-to-cart-btn" onclick="addToCart(${product.id})">
                        <i class="fas fa-shopping-cart"></i>
                        Add to Cart
                    </button>
                </div>
            `;
            
            return col;
        }

        // Add to cart function
        function addToCart(productId) {
            const btn = event.target;
            const originalText = btn.innerHTML;
            
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Adding...';
            btn.disabled = true;

            fetch('/cart/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    laptop_id: productId,
                    quantity: 1
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    btn.innerHTML = '<i class="fas fa-check"></i> Added!';
                    btn.style.background = '#28a745';
                    updateCartBadge();
                    
                    // Show success notification
                    showNotification('Product added to cart!', 'success');
                } else {
                    btn.innerHTML = '<i class="fas fa-exclamation-triangle"></i> Error';
                    btn.style.background = '#dc3545';
                    showNotification(data.message || 'Error adding to cart', 'error');
                }
                
                setTimeout(() => {
                    btn.innerHTML = originalText;
                    btn.style.background = '';
                    btn.disabled = false;
                }, 2000);
            })
            .catch(error => {
                console.error('Error:', error);
                btn.innerHTML = '<i class="fas fa-exclamation-triangle"></i> Error';
                btn.style.background = '#dc3545';
                showNotification('Error adding to cart', 'error');
                
                setTimeout(() => {
                    btn.innerHTML = originalText;
                    btn.style.background = '';
                    btn.disabled = false;
                }, 2000);
            });
        }

        // Update cart badge
        function updateCartBadge() {
            fetch('/api/cart-count')
                .then(response => response.json())
                .then(data => {
                    const badge = document.getElementById('cartBadge');
                    if (data.count > 0) {
                        badge.textContent = data.count;
                        badge.style.display = 'flex';
                    } else {
                        badge.style.display = 'none';
                    }
                })
                .catch(error => console.error('Error updating cart badge:', error));
        }

        // Show notification
        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            notification.className = `alert alert-${type === 'success' ? 'success' : 'danger'} position-fixed`;
            notification.style.cssText = 'top: 100px; right: 20px; z-index: 9999; min-width: 300px;';
            notification.innerHTML = `
                <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} me-2"></i>
                ${message}
                <button type="button" class="btn-close" onclick="this.parentElement.remove()"></button>
            `;
            
            document.body.appendChild(notification);
            
            setTimeout(() => {
                if (notification.parentElement) {
                    notification.remove();
                }
            }, 5000);
        }

        // Scroll animations
        function initScrollAnimations() {
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                    }
                });
            }, observerOptions);

            document.querySelectorAll('.fade-in').forEach(el => {
                observer.observe(el);
            });
        }

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar-custom');
            if (window.scrollY > 100) {
                navbar.style.background = 'rgba(0, 0, 0, 0.2)';
            } else {
                navbar.style.background = 'rgba(0, 0, 0, 0.1)';
            }
        });

        // Check authentication status
        function checkAuth() {
            const token = localStorage.getItem('jwt_token');
            const user = localStorage.getItem('user');
            
            if (token && user) {
                const userData = JSON.parse(user);
                
                // Update main navbar
                document.getElementById('authSection').classList.add('d-none');
                document.getElementById('userSection').classList.remove('d-none');
                document.getElementById('userNameHeader').textContent = userData.name;
                document.getElementById('desktopLoginBtn').classList.add('d-none');
                document.getElementById('desktopLogoutBtn').classList.remove('d-none');
                
                // Update mobile sidebar
                document.getElementById('mobileAuthSection').classList.add('d-none');
                document.getElementById('mobileUserSection').classList.remove('d-none');
                
                // Show user info in mobile sidebar
                const mobileUserName = document.getElementById('mobileUserName');
                if (mobileUserName) {
                    mobileUserName.textContent = userData.name;
                }
            } else {
                // User not logged in
                document.getElementById('authSection').classList.remove('d-none');
                document.getElementById('userSection').classList.add('d-none');
                document.getElementById('desktopLoginBtn').classList.remove('d-none');
                document.getElementById('desktopLogoutBtn').classList.add('d-none');
                
                // Update mobile sidebar
                document.getElementById('mobileAuthSection').classList.remove('d-none');
                document.getElementById('mobileUserSection').classList.add('d-none');
            }
        }

        // User menu functions
        function showProfile() {
            showNotification('Profile page coming soon!', 'info');
        }

        function showOrders() {
            showNotification('Orders page coming soon!', 'info');
        }

        function showWishlist() {
            showNotification('Wishlist feature coming soon!', 'info');
        }

        function showSettings() {
            showNotification('Settings page coming soon!', 'info');
        }

        // Logout function
        function logout() {
            const token = localStorage.getItem('jwt_token');
            
            if (token) {
                fetch('/jwt/logout', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                }).finally(() => {
                    // Clear local storage
                    localStorage.removeItem('jwt_token');
                    localStorage.removeItem('user');
                    
                    // Show success notification
                    showNotification('Logged out successfully!', 'success');
                    
                    // Refresh the page to update UI
                    location.reload();
                });
            } else {
                // Clear local storage even if no token
                localStorage.removeItem('jwt_token');
                localStorage.removeItem('user');
                location.reload();
            }
        }

        // Mobile sidebar functions
        function toggleMobileSidebar() {
            const sidebar = document.getElementById('mobileSidebar');
            const overlay = document.getElementById('sidebarOverlay');
            sidebar.classList.toggle('open');
            overlay.classList.toggle('show');
        }

        function toggleSearch() {
            const searchInput = document.createElement('input');
            searchInput.type = 'text';
            searchInput.placeholder = 'Search...';
            searchInput.style.width = '100%';
            searchInput.style.padding = '0.5rem';
            searchInput.style.borderRadius = '10px';
            searchInput.style.border = '1px solid rgba(255, 255, 255, 0.3)';
            searchInput.style.backgroundColor = 'rgba(20, 20, 20, 0.9)';
            searchInput.style.color = '#fff';
            searchInput.style.marginBottom = '1rem';

            const searchForm = document.createElement('form');
            searchForm.method = 'GET';
            searchForm.action = '/search';
            searchForm.style.width = '100%';
            searchForm.style.display = 'flex';
            searchForm.style.gap = '0.5rem';

            const searchButton = document.createElement('button');
            searchButton.type = 'submit';
            searchButton.innerHTML = '<i class="fas fa-search"></i>';
            searchButton.style.background = 'none';
            searchButton.style.border = 'none';
            searchButton.style.color = '#fff';
            searchButton.style.cursor = 'pointer';
            searchButton.style.padding = '0.5rem';
            searchButton.style.borderRadius = '10px';
            searchButton.style.transition = 'background-color 0.3s ease';
            searchButton.style.display = 'flex';
            searchButton.style.alignItems = 'center';
            searchButton.style.justifyContent = 'center';

            searchForm.appendChild(searchInput);
            searchForm.appendChild(searchButton);

            const searchSection = document.querySelector('.sidebar-section:nth-of-type(3)'); // Quick Actions section
            searchSection.innerHTML = ''; // Clear existing content
            searchSection.appendChild(searchForm);

            toggleMobileSidebar(); // Close sidebar after opening search
        }

        // Video Background Functionality
        function initVideoBackground() {
            const video = document.getElementById('heroVideo');
            const playPauseBtn = document.getElementById('playPauseBtn');
            const muteBtn = document.getElementById('muteBtn');
            
            if (!video) return;

            // Set video properties for continuous looping
            video.muted = true;
            video.loop = true;
            video.autoplay = true;
            video.playsinline = true;
            video.preload = 'auto';

            // Ensure video plays continuously
            video.addEventListener('ended', () => {
                video.currentTime = 0;
                video.play().catch(e => console.log('Video replay error:', e));
            });

            // Handle play errors and retry
            video.addEventListener('error', () => {
                console.log('Video error, attempting to restart...');
                setTimeout(() => {
                    video.currentTime = 0;
                    video.play().catch(e => console.log('Video restart error:', e));
                }, 1000);
            });

            // Auto-play with muted (required for most browsers)
            video.play().catch(e => {
                console.log('Auto-play prevented:', e);
                // Show play button if auto-play fails
                if (playPauseBtn) playPauseBtn.style.display = 'block';
            });

            // Play/Pause functionality
            if (playPauseBtn) {
                playPauseBtn.addEventListener('click', () => {
                    if (video.paused) {
                        video.play();
                        playPauseBtn.innerHTML = '<i class="fas fa-pause"></i> Pause';
                    } else {
                        video.pause();
                        playPauseBtn.innerHTML = '<i class="fas fa-play"></i> Play';
                    }
                });
            }

            // Mute/Unmute functionality
            if (muteBtn) {
                muteBtn.addEventListener('click', () => {
                    video.muted = !video.muted;
                    muteBtn.innerHTML = video.muted ? 
                        '<i class="fas fa-volume-mute"></i> Unmute' : 
                        '<i class="fas fa-volume-up"></i> Mute';
                });
            }

            // Video loading states
            video.addEventListener('loadstart', () => {
                document.querySelector('.video-loading').style.display = 'block';
            });

            video.addEventListener('canplay', () => {
                document.querySelector('.video-loading').style.display = 'none';
            });

            video.addEventListener('error', () => {
                document.querySelector('.video-loading').style.display = 'none';
                document.querySelector('.video-fallback').style.display = 'block';
            });

            // Ensure video keeps playing - multiple event listeners for reliability
            video.addEventListener('pause', () => {
                // Auto-resume if video gets paused unexpectedly
                if (!video.ended) {
                    setTimeout(() => {
                        if (video.paused && !video.ended) {
                            video.play().catch(e => console.log('Auto-resume error:', e));
                        }
                    }, 100);
                }
            });

            // Monitor video state and ensure it's playing
            setInterval(() => {
                if (video.paused && !video.ended && document.visibilityState === 'visible') {
                    video.play().catch(e => console.log('Periodic play check error:', e));
                }
            }, 5000);

            // Pause video when not visible (performance optimization)
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        if (video.paused && !video.ended) {
                            video.play().catch(e => console.log('Intersection play error:', e));
                        }
                    } else {
                        // Don't pause on scroll, let it keep playing
                        // if (!video.paused) video.pause();
                    }
                });
            }, { threshold: 0.1 });

            observer.observe(video);
        }
    </script>
</body>
</html>