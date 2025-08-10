<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Shopping Cart - DND COMPUTERS</title>
    
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

        .main-content {
            padding-top: 100px;
            min-height: 100vh;
        }

        .cart-container {
            background: rgba(20, 20, 20, 0.95);
            border-radius: 20px;
            padding: 2rem;
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 2rem;
        }

        .cart-title {
            color: #ffc107;
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 2rem;
            text-align: center;
        }

        .cart-item {
            background: rgba(40, 40, 40, 0.8);
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }

        .cart-item:hover {
            border-color: rgba(255, 193, 7, 0.3);
            transform: translateY(-2px);
        }

        .item-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 10px;
        }

        .item-name {
            color: #fff;
            font-weight: 600;
            font-size: 1.1rem;
            margin-bottom: 0.5rem;
        }

        .item-price {
            color: #ffc107;
            font-weight: 700;
            font-size: 1.2rem;
        }

        .quantity-controls {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .quantity-btn {
            background: #ffc107;
            color: #000;
            border: none;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .quantity-btn:hover {
            background: #ffb400;
            transform: scale(1.1);
        }

        .quantity-input {
            background: rgba(60, 60, 60, 0.8);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            color: #fff;
            text-align: center;
            width: 60px;
            padding: 0.5rem;
        }

        .remove-btn {
            background: #dc3545;
            color: #fff;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .remove-btn:hover {
            background: #c82333;
            transform: translateY(-2px);
        }

        .cart-summary {
            background: rgba(20, 20, 20, 0.95);
            border-radius: 20px;
            padding: 2rem;
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            position: sticky;
            top: 120px;
        }

        .summary-title {
            color: #ffc107;
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .summary-total {
            font-size: 1.3rem;
            font-weight: 700;
            color: #ffc107;
        }

        .checkout-btn {
            background: linear-gradient(45deg, #ffc107, #ffb400);
            color: #000;
            border: none;
            padding: 1rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1.1rem;
            width: 100%;
            transition: all 0.3s ease;
            margin-top: 1rem;
        }

        .checkout-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(255, 193, 7, 0.4);
        }

        .continue-shopping {
            background: transparent;
            color: #fff;
            border: 2px solid rgba(255, 255, 255, 0.3);
            padding: 0.8rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
            margin-top: 1rem;
            width: 100%;
            text-align: center;
        }

        .continue-shopping:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: #ffc107;
            color: #ffc107;
            text-decoration: none;
        }

        .empty-cart {
            text-align: center;
            padding: 3rem;
        }

        .empty-cart i {
            font-size: 4rem;
            color: #ffc107;
            margin-bottom: 1rem;
        }

        .empty-cart h3 {
            color: #fff;
            margin-bottom: 1rem;
        }

        .empty-cart p {
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 2rem;
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
                <a class="nav-link" href="/mouse">Mice</a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container">
            @if(empty($cart))
                <div class="cart-container">
                    <div class="empty-cart">
                        <i class="fas fa-shopping-cart"></i>
                        <h3>Your cart is empty</h3>
                        <p>Looks like you haven't added any items to your cart yet.</p>
                        <a href="/laptops" class="checkout-btn" style="width: auto; display: inline-block;">
                            <i class="fas fa-shopping-bag me-2"></i>Start Shopping
                        </a>
                    </div>
                </div>
            @else
                <div class="row">
                    <!-- Cart Items -->
                    <div class="col-lg-8">
                        <div class="cart-container">
                            <h2 class="cart-title">
                                <i class="fas fa-shopping-cart me-2"></i>Shopping Cart
                            </h2>
                            
                            <div id="cartItems">
                                @foreach($cart as $id => $item)
                                    <div class="cart-item" data-id="{{ $id }}">
                                        <div class="row align-items-center">
                                            <div class="col-md-2">
                                                <img src="{{ $item['image'] ?? 'https://via.placeholder.com/80x80/2a2a2a/ffc107?text=Product' }}" 
                                                     alt="{{ $item['name'] }}" 
                                                     class="item-image">
                                            </div>
                                            <div class="col-md-4">
                                                <div class="item-name">{{ $item['name'] }}</div>
                                                <div class="item-price">${{ number_format($item['price'], 2) }}</div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="quantity-controls">
                                                    <button class="quantity-btn" onclick="updateQuantity({{ $id }}, {{ $item['quantity'] - 1 }})">
                                                        <i class="fas fa-minus"></i>
                                                    </button>
                                                    <input type="number" 
                                                           class="quantity-input" 
                                                           value="{{ $item['quantity'] }}" 
                                                           min="1"
                                                           onchange="updateQuantity({{ $id }}, this.value)">
                                                    <button class="quantity-btn" onclick="updateQuantity({{ $id }}, {{ $item['quantity'] + 1 }})">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="item-price">${{ number_format($item['price'] * $item['quantity'], 2) }}</div>
                                            </div>
                                            <div class="col-md-1">
                                                <button class="remove-btn" onclick="removeFromCart({{ $id }})">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Cart Summary -->
                    <div class="col-lg-4">
                        <div class="cart-summary">
                            <h3 class="summary-title">Order Summary</h3>
                            
                            <div class="summary-row">
                                <span>Subtotal:</span>
                                <span id="subtotal">${{ number_format($total, 2) }}</span>
                            </div>
                            <div class="summary-row">
                                <span>Shipping:</span>
                                <span>Free</span>
                            </div>
                            <div class="summary-row">
                                <span>Tax:</span>
                                <span id="tax">${{ number_format($total * 0.1, 2) }}</span>
                            </div>
                            <div class="summary-row summary-total">
                                <span>Total:</span>
                                <span id="total">${{ number_format($total * 1.1, 2) }}</span>
                            </div>
                            
                            <button class="checkout-btn" onclick="proceedToCheckout()">
                                <i class="fas fa-credit-card me-2"></i>Proceed to Checkout
                            </button>
                            
                            <a href="/laptops" class="continue-shopping">
                                <i class="fas fa-arrow-left me-2"></i>Continue Shopping
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Update quantity
        function updateQuantity(laptopId, quantity) {
            if (quantity < 1) {
                removeFromCart(laptopId);
                return;
            }

            fetch('/cart/update-quantity', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    laptop_id: laptopId,
                    quantity: quantity
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    showNotification(data.message || 'Error updating quantity', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Error updating quantity', 'error');
            });
        }

        // Remove from cart
        function removeFromCart(laptopId) {
            if (!confirm('Are you sure you want to remove this item from your cart?')) {
                return;
            }

            fetch('/cart/remove', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    laptop_id: laptopId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    showNotification(data.message || 'Error removing item', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Error removing item', 'error');
            });
        }

        // Proceed to checkout
        function proceedToCheckout() {
            // For now, just show a message
            showNotification('Checkout functionality will be implemented soon!', 'info');
        }

        // Show notification
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