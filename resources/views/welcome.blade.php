<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>DND COMPUTERS - Premium Computer Store</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #000 0%, #1a1a1a 100%);
            color: #fff;
            overflow-x: hidden;
        }

        .navbar-custom {
            background: rgba(0, 0, 0, 0.95) !important;
            backdrop-filter: blur(20px);
            padding: 1rem 0;
            border-bottom: 1px solid rgba(255, 193, 7, 0.2);
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

        .hero-section {
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        .hero-content {
            z-index: 2;
            position: relative;
        }

        .hero-title {
            font-size: 4rem;
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 1.5rem;
            background: linear-gradient(45deg, #fff, #ffc107);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-subtitle {
            font-size: 1.3rem;
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        .cta-button {
            background: linear-gradient(45deg, #ffc107, #ffb400);
            color: #000;
            border: none;
            padding: 1rem 2.5rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1.1rem;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
            margin-right: 1rem;
        }

        .cta-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(255, 193, 7, 0.4);
            color: #000;
            text-decoration: none;
        }

        .cta-secondary {
            background: transparent;
            color: #fff;
            border: 2px solid rgba(255, 255, 255, 0.3);
            padding: 1rem 2.5rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1.1rem;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
        }

        .cta-secondary:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: #ffc107;
            color: #ffc107;
            text-decoration: none;
            transform: translateY(-3px);
        }

        .floating-elements {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 1;
        }

        .floating-element {
            position: absolute;
            opacity: 0.1;
            animation: float 6s ease-in-out infinite;
        }

        .floating-element:nth-child(1) {
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }

        .floating-element:nth-child(2) {
            top: 60%;
            right: 10%;
            animation-delay: -2s;
        }

        .floating-element:nth-child(3) {
            bottom: 20%;
            left: 20%;
            animation-delay: -4s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }

        .features-section {
            padding: 5rem 0;
            background: rgba(20, 20, 20, 0.5);
        }

        .feature-card {
            background: rgba(40, 40, 40, 0.8);
            border-radius: 20px;
            padding: 2rem;
            text-align: center;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.1);
            height: 100%;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            border-color: rgba(255, 193, 7, 0.3);
        }

        .feature-icon {
            font-size: 3rem;
            color: #ffc107;
            margin-bottom: 1.5rem;
        }

        .feature-title {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: #fff;
        }

        .feature-description {
            color: rgba(255, 255, 255, 0.7);
            line-height: 1.6;
        }

        .products-section {
            padding: 5rem 0;
        }

        .section-title {
            text-align: center;
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 3rem;
            background: linear-gradient(45deg, #fff, #ffc107);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }

        .product-card {
            background: rgba(20, 20, 20, 0.95);
            border-radius: 20px;
            padding: 2rem;
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
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

        .auth-buttons {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .auth-btn {
            background: transparent;
            color: #fff;
            border: 2px solid rgba(255, 255, 255, 0.3);
            padding: 0.5rem 1.5rem;
            border-radius: 25px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .auth-btn:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: #ffc107;
            color: #ffc107;
            text-decoration: none;
        }

        .auth-btn.primary {
            background: linear-gradient(45deg, #ffc107, #ffb400);
            color: #000;
            border-color: transparent;
        }

        .auth-btn.primary:hover {
            background: linear-gradient(45deg, #ffb400, #ffa000);
            color: #000;
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
            
            .hero-subtitle {
                font-size: 1.1rem;
            }
            
            .cta-button, .cta-secondary {
                display: block;
                margin-bottom: 1rem;
                text-align: center;
            }
            
            .auth-buttons {
                flex-direction: column;
                width: 100%;
            }
            
            .auth-btn {
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-custom fixed-top">
        <div class="container">
            <!-- Logo -->
            <a class="navbar-brand" href="/">DND COMPUTERS</a>

            <!-- Mobile Toggle -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Desktop Navigation -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="navbar-nav mx-auto">
                    <a class="nav-link active" href="/">Home</a>
                    <a class="nav-link" href="/laptops">Laptops</a>
                    <a class="nav-link" href="/keyboard">Keyboards</a>
                    <a class="nav-link" href="/mouse">Mice</a>
                </div>

                <!-- Right Side Icons & Auth -->
                <div class="d-flex align-items-center gap-3">
                    <div class="navbar-icons d-none d-md-flex">
                        <span class="icon-search" data-bs-toggle="tooltip" title="Search">
                            <i class="fas fa-search"></i>
                        </span>
                        <span class="icon-cart" data-bs-toggle="tooltip" title="Shopping Cart" onclick="window.location.href='/cart'">
                            <i class="fas fa-shopping-cart"></i>
                            <span class="cart-badge" id="cartBadge" style="display: none;">0</span>
                        </span>
                    </div>
                    
                    <div class="auth-buttons">
                        <a href="/jwt/login" class="auth-btn">Login</a>
                        <a href="/jwt/register" class="auth-btn primary">Register</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="floating-elements">
            <div class="floating-element">
                <i class="fas fa-laptop fa-3x"></i>
            </div>
            <div class="floating-element">
                <i class="fas fa-keyboard fa-2x"></i>
            </div>
            <div class="floating-element">
                <i class="fas fa-mouse fa-2x"></i>
            </div>
        </div>
        
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="hero-content">
                        <h1 class="hero-title">Premium Computing Solutions</h1>
                        <p class="hero-subtitle">
                            Discover the latest laptops, keyboards, and mice from top brands. 
                            Experience cutting-edge technology with unmatched performance and style.
                        </p>
                        <div class="hero-buttons">
                            <a href="/laptops" class="cta-button">
                                <i class="fas fa-laptop me-2"></i>Shop Laptops
                            </a>
                            <a href="#features" class="cta-secondary">
                                <i class="fas fa-info-circle me-2"></i>Learn More
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="hero-image text-center">
                        <img src="https://images.pexels.com/photos/205421/pexels-photo-205421.jpeg?auto=compress&cs=tinysrgb&w=600" 
                             alt="Premium Laptop" 
                             class="img-fluid" 
                             style="max-width: 80%; border-radius: 20px; box-shadow: 0 20px 40px rgba(0,0,0,0.3);">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section" id="features">
        <div class="container">
            <h2 class="section-title">Why Choose DND COMPUTERS?</h2>
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-award"></i>
                        </div>
                        <h3 class="feature-title">Premium Quality</h3>
                        <p class="feature-description">
                            We offer only the highest quality products from trusted brands, 
                            ensuring reliability and performance you can count on.
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-shipping-fast"></i>
                        </div>
                        <h3 class="feature-title">Fast Delivery</h3>
                        <p class="feature-description">
                            Quick and secure shipping to get your products to you as fast as possible, 
                            with tracking available on all orders.
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-headset"></i>
                        </div>
                        <h3 class="feature-title">Expert Support</h3>
                        <p class="feature-description">
                            Our knowledgeable support team is here to help you find the perfect 
                            products and provide assistance whenever you need it.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Products Section -->
    <section class="products-section">
        <div class="container">
            <h2 class="section-title">Featured Products</h2>
            <div class="product-grid" id="featuredProducts">
                <!-- Products will be loaded here via JavaScript -->
                <div class="text-center col-12">
                    <i class="fas fa-spinner fa-spin fa-2x text-warning"></i>
                    <p class="mt-2">Loading featured products...</p>
                </div>
            </div>
            <div class="text-center">
                <a href="/laptops" class="cta-button">
                    <i class="fas fa-eye me-2"></i>View All Products
                </a>
            </div>
        </div>
    </section>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('resources/js/auth.js') }}"></script>
    
    <script>
        // Initialize tooltips
        document.addEventListener('DOMContentLoaded', function() {
            // Check if user is logged in and update UI
            updateAuthUI();
            
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Load featured products
            loadFeaturedProducts();
            
            // Update cart badge
            updateCartBadge();
        });

        // Update authentication UI
        function updateAuthUI() {
            if (window.jwtAuth && window.jwtAuth.isAuthenticated()) {
                const user = window.jwtAuth.getUser();
                if (user) {
                    // Update auth buttons to show user info
                    const authButtons = document.querySelector('.auth-buttons');
                    if (authButtons) {
                        authButtons.innerHTML = `
                            <div class="dropdown">
                                <button class="auth-btn dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-user me-2"></i>${user.name}
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#" onclick="showProfile()">Profile</a></li>
                                    <li><a class="dropdown-item" href="#" onclick="logout()">Logout</a></li>
                                </ul>
                            </div>
                        `;
                    }
                }
            }
        }

        // Logout function
        async function logout() {
            if (window.jwtAuth) {
                await window.jwtAuth.logout();
                window.location.reload();
            }
        }

        // Show profile function
        function showProfile() {
            if (window.jwtAuth) {
                const user = window.jwtAuth.getUser();
                alert(`Profile: ${user.name} (${user.email})`);
            }
        }
        // Load featured products
        function loadFeaturedProducts() {
            fetch('/api/featured-products')
                .then(response => response.json())
                .then(data => {
                    const container = document.getElementById('featuredProducts');
                    
                    if (data.success && data.products.length > 0) {
                        container.innerHTML = '';
                        data.products.forEach(product => {
                            const productCard = createProductCard(product);
                            container.appendChild(productCard);
                        });
                    } else {
                        container.innerHTML = `
                            <div class="col-12 text-center">
                                <i class="fas fa-box-open fa-3x text-warning mb-3"></i>
                                <h4>No featured products available</h4>
                                <p class="text-muted">Check back soon for amazing deals!</p>
                                <a href="/laptops" class="cta-button">Browse All Products</a>
                            </div>
                        `;
                    }
                })
                .catch(error => {
                    console.error('Error loading featured products:', error);
                    document.getElementById('featuredProducts').innerHTML = `
                        <div class="col-12 text-center">
                            <i class="fas fa-exclamation-triangle fa-3x text-danger mb-3"></i>
                            <h4>Error loading products</h4>
                            <p class="text-muted">Please try again later</p>
                        </div>
                    `;
                });
        }

        // Create product card element
        function createProductCard(product) {
            const card = document.createElement('div');
            card.className = 'product-card';
            
            card.innerHTML = `
                <img src="${product.image || 'https://via.placeholder.com/300x200/2a2a2a/ffc107?text=Laptop'}" 
                     alt="${product.name}" 
                     style="width: 100%; height: 200px; object-fit: cover; border-radius: 15px; margin-bottom: 1.5rem;">
                
                <div style="color: #ffc107; font-size: 0.9rem; font-weight: 500; margin-bottom: 0.5rem;">${product.brand}</div>
                <h5 style="color: #fff; font-size: 1.3rem; font-weight: 600; margin-bottom: 0.5rem; line-height: 1.3;">${product.name}</h5>
                
                <div style="color: rgba(255, 255, 255, 0.7); font-size: 0.8rem; margin-bottom: 1rem;">
                    <div><i class="fas fa-microchip me-1"></i> ${product.processor}</div>
                    <div><i class="fas fa-memory me-1"></i> ${product.ram} RAM</div>
                    <div><i class="fas fa-hdd me-1"></i> ${product.storage}</div>
                </div>
                
                <div style="color: #ffc107; font-size: 1.5rem; font-weight: 700; margin-bottom: 1rem;">$${parseFloat(product.price).toFixed(2)}</div>
                
                <button class="btn btn-warning w-100" 
                        onclick="addToCart(${product.id})"
                        style="background: linear-gradient(45deg, #ffc107, #ffb400); color: #000; border: none; padding: 0.8rem 1.5rem; border-radius: 25px; font-weight: 600;">
                    <i class="fas fa-shopping-cart me-2"></i>Add to Cart
                </button>
            `;
            
            return card;
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
    </script>
</body>
</html>