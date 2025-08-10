<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Mice - DND COMPUTERS</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #000 0%, #1a1a1a 100%);
            color: #fff;
            min-height: 100vh;
        }

        .navbar-custom {
            background: rgba(0, 0, 0, 0.95) !important;
            backdrop-filter: blur(20px);
            padding: 1rem 0;
            border-bottom: 1px solid rgba(255, 193, 7, 0.2);
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
        }

        .main-content {
            padding-top: 100px;
            min-height: 100vh;
        }

        .hero-section {
            background: rgba(20, 20, 20, 0.95);
            border-radius: 20px;
            padding: 3rem 2rem;
            margin-bottom: 3rem;
            text-align: center;
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .hero-title {
            font-size: 3rem;
            font-weight: 800;
            background: linear-gradient(45deg, #fff, #ffc107);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 1rem;
        }

        .hero-subtitle {
            font-size: 1.2rem;
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 2rem;
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
            text-align: center;
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
        }

        .product-brand {
            color: #ffc107;
            font-size: 0.9rem;
            font-weight: 500;
            margin-bottom: 1rem;
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
        }

        .add-to-cart-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(255, 193, 7, 0.4);
        }

        .coming-soon {
            background: rgba(40, 40, 40, 0.8);
            border-radius: 15px;
            padding: 3rem;
            text-align: center;
            margin: 3rem 0;
        }

        .coming-soon i {
            font-size: 4rem;
            color: #ffc107;
            margin-bottom: 1.5rem;
        }

        .coming-soon h3 {
            color: #fff;
            font-size: 2rem;
            margin-bottom: 1rem;
        }

        .coming-soon p {
            color: rgba(255, 255, 255, 0.7);
            font-size: 1.1rem;
            margin-bottom: 2rem;
        }

        .notify-btn {
            background: linear-gradient(45deg, #ffc107, #ffb400);
            color: #000;
            border: none;
            padding: 1rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
        }

        .notify-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(255, 193, 7, 0.4);
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-custom fixed-top">
        <div class="container">
            <a class="navbar-brand" href="/">DND COMPUTERS</a>
            <div class="navbar-nav d-none d-lg-flex">
                <a class="nav-link" href="/">Home</a>
                <a class="nav-link" href="/laptops">Laptops</a>
                <a class="nav-link" href="/keyboard">Keyboards</a>
                <a class="nav-link active" href="/mouse">Mice</a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container">
            <!-- Hero Section -->
            <div class="hero-section">
                <h1 class="hero-title">Precision Mice</h1>
                <p class="hero-subtitle">
                    Professional gaming and productivity mice with advanced sensors, customizable buttons, and ergonomic designs.
                </p>
            </div>

            <!-- Coming Soon Section -->
            <div class="coming-soon">
                <i class="fas fa-mouse"></i>
                <h3>Mice Collection Coming Soon!</h3>
                <p>
                    We're preparing an extensive collection of high-precision mice for gaming, design work, and everyday use. 
                    Featuring top brands like Logitech, Razer, SteelSeries, and more with cutting-edge sensors and customizable features.
                </p>
                <button class="notify-btn" onclick="notifyMe()">
                    <i class="fas fa-bell me-2"></i>Notify Me When Available
                </button>
            </div>

            <!-- Sample Products (for demonstration) -->
            <div class="row">
                <div class="col-12">
                    <h2 class="text-center mb-4" style="color: #ffc107; font-weight: 700;">Featured Mouse Categories</h2>
                </div>
            </div>

            <div class="product-grid">
                <div class="product-card">
                    <img src="https://images.pexels.com/photos/2115256/pexels-photo-2115256.jpeg?auto=compress&cs=tinysrgb&w=400" 
                         alt="Gaming Mouse" 
                         class="product-image">
                    <h5 class="product-title">Gaming Mice</h5>
                    <div class="product-brand">High DPI & RGB</div>
                    <div class="product-price">Starting at $59.99</div>
                    <p class="product-description">
                        Ultra-precise gaming mice with high DPI sensors, customizable RGB lighting, and programmable buttons.
                    </p>
                    <button class="add-to-cart-btn" disabled>
                        <i class="fas fa-clock me-2"></i>Coming Soon
                    </button>
                </div>

                <div class="product-card">
                    <img src="https://images.pexels.com/photos/1772123/pexels-photo-1772123.jpeg?auto=compress&cs=tinysrgb&w=400" 
                         alt="Wireless Mouse" 
                         class="product-image">
                    <h5 class="product-title">Wireless Mice</h5>
                    <div class="product-brand">Bluetooth & 2.4GHz</div>
                    <div class="product-price">Starting at $29.99</div>
                    <p class="product-description">
                        Freedom of movement with reliable wireless connectivity and long-lasting battery life.
                    </p>
                    <button class="add-to-cart-btn" disabled>
                        <i class="fas fa-clock me-2"></i>Coming Soon
                    </button>
                </div>

                <div class="product-card">
                    <img src="https://images.pexels.com/photos/1772123/pexels-photo-1772123.jpeg?auto=compress&cs=tinysrgb&w=400" 
                         alt="Ergonomic Mouse" 
                         class="product-image">
                    <h5 class="product-title">Ergonomic Mice</h5>
                    <div class="product-brand">Comfort Design</div>
                    <div class="product-price">Starting at $39.99</div>
                    <p class="product-description">
                        Designed for comfort during long work sessions with ergonomic shapes and smooth tracking.
                    </p>
                    <button class="add-to-cart-btn" disabled>
                        <i class="fas fa-clock me-2"></i>Coming Soon
                    </button>
                </div>

                <div class="product-card">
                    <img src="https://images.pexels.com/photos/2115256/pexels-photo-2115256.jpeg?auto=compress&cs=tinysrgb&w=400" 
                         alt="Professional Mouse" 
                         class="product-image">
                    <h5 class="product-title">Professional Mice</h5>
                    <div class="product-brand">Design & CAD</div>
                    <div class="product-price">Starting at $79.99</div>
                    <p class="product-description">
                        Precision mice for designers and professionals with advanced features and customizable settings.
                    </p>
                    <button class="add-to-cart-btn" disabled>
                        <i class="fas fa-clock me-2"></i>Coming Soon
                    </button>
                </div>
            </div>

            <!-- Newsletter Signup -->
            <div class="coming-soon">
                <h3>Stay Updated</h3>
                <p>Be the first to know when our mouse collection launches!</p>
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="input-group">
                            <input type="email" class="form-control" placeholder="Enter your email" id="emailInput" 
                                   style="background: rgba(60, 60, 60, 0.8); border: 1px solid rgba(255, 255, 255, 0.2); color: #fff;">
                            <button class="btn notify-btn" onclick="subscribeNewsletter()">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        function notifyMe() {
            showNotification('Thank you! We\'ll notify you when mice are available.', 'success');
        }

        function subscribeNewsletter() {
            const email = document.getElementById('emailInput').value;
            if (!email) {
                showNotification('Please enter your email address.', 'error');
                return;
            }
            
            if (!isValidEmail(email)) {
                showNotification('Please enter a valid email address.', 'error');
                return;
            }

            // Here you would typically send the email to your backend
            showNotification('Thank you for subscribing! We\'ll keep you updated.', 'success');
            document.getElementById('emailInput').value = '';
        }

        function isValidEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }

        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            notification.className = `alert alert-${type === 'success' ? 'success' : type === 'error' ? 'danger' : 'info'} position-fixed`;
            notification.style.cssText = 'top: 100px; right: 20px; z-index: 9999; min-width: 300px;';
            notification.innerHTML = `
                <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'} me-2"></i>
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
    </script>
</body>
</html>