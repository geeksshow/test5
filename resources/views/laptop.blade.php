<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laptops - DND COMPUTERS</title>
    
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

        .main-content {
            padding-top: 100px;
            min-height: 100vh;
        }

        .filters-section {
            background: rgba(20, 20, 20, 0.95);
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .filter-group {
            margin-bottom: 1.5rem;
        }

        .filter-label {
            color: #ffc107;
            font-weight: 600;
            margin-bottom: 0.5rem;
            display: block;
        }

        .filter-select, .filter-input {
            background: rgba(40, 40, 40, 0.8);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            color: #fff;
            padding: 0.5rem 1rem;
            width: 100%;
        }

        .filter-select:focus, .filter-input:focus {
            border-color: #ffc107;
            outline: none;
            box-shadow: 0 0 0 2px rgba(255, 193, 7, 0.2);
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
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

        .product-brand {
            color: #ffc107;
            font-size: 0.9rem;
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .product-specs {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.8rem;
            margin-bottom: 1rem;
        }

        .product-price {
            color: #ffc107;
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .product-stock {
            color: #28a745;
            font-size: 0.8rem;
            margin-bottom: 1rem;
        }

        .product-stock.low {
            color: #ffc107;
        }

        .product-stock.out {
            color: #dc3545;
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

        .add-to-cart-btn:disabled {
            background: #666;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .pagination-wrapper {
            display: flex;
            justify-content: center;
            margin-top: 3rem;
        }

        .search-section {
            background: rgba(20, 20, 20, 0.95);
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .search-input {
            background: rgba(40, 40, 40, 0.8);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 50px;
            color: #fff;
            padding: 1rem 2rem;
            width: 100%;
            font-size: 1.1rem;
        }

        .search-input:focus {
            border-color: #ffc107;
            outline: none;
            box-shadow: 0 0 0 3px rgba(255, 193, 7, 0.2);
        }

        .sort-section {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .sort-label {
            color: #ffc107;
            font-weight: 600;
        }

        .sort-select {
            background: rgba(40, 40, 40, 0.8);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            color: #fff;
            padding: 0.5rem 1rem;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-custom fixed-top">
        <div class="container">
            <!-- Logo -->
            <a class="navbar-brand" href="/">DND COMPUTERS</a>

            <!-- Desktop Navigation -->
            <div class="navbar-nav d-none d-lg-flex mx-auto">
                <a class="nav-link" href="/">Home</a>
                <a class="nav-link active" href="/laptops">Laptops</a>
                <a class="nav-link" href="/keyboard">Keyboards</a>
                <a class="nav-link" href="/mouse">Mice</a>
            </div>

            <!-- Right Side Icons -->
            <div class="navbar-icons">
                <span class="icon-search" data-bs-toggle="tooltip" title="Search">
                    <i class="fas fa-search"></i>
                </span>
                <span class="icon-user" data-bs-toggle="tooltip" title="User Account">
                    <i class="fas fa-user"></i>
                </span>
                <span class="icon-cart" data-bs-toggle="tooltip" title="Shopping Cart" onclick="window.location.href='/cart'">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="cart-badge" id="cartBadge" style="display: none;">0</span>
                </span>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container">
            <!-- Search Section -->
            <div class="search-section">
                <form method="GET" action="{{ route('laptops.index') }}">
                    <div class="input-group">
                        <input type="text" 
                               name="search" 
                               class="search-input" 
                               placeholder="Search laptops by name, brand, processor..."
                               value="{{ request('search') }}">
                        <button class="btn btn-warning ms-2 px-4" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>

            <div class="row">
                <!-- Filters Sidebar -->
                <div class="col-lg-3">
                    <div class="filters-section">
                        <h4 class="text-warning mb-3">
                            <i class="fas fa-filter me-2"></i>Filters
                        </h4>
                        
                        <form method="GET" action="{{ route('laptops.index') }}" id="filterForm">
                            <input type="hidden" name="search" value="{{ request('search') }}">
                            
                            <!-- Brand Filter -->
                            <div class="filter-group">
                                <label class="filter-label">Brand</label>
                                <select name="brand" class="filter-select" onchange="document.getElementById('filterForm').submit()">
                                    <option value="">All Brands</option>
                                    @foreach($brands as $brand)
                                        <option value="{{ $brand }}" {{ request('brand') == $brand ? 'selected' : '' }}>
                                            {{ $brand }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Price Range -->
                            <div class="filter-group">
                                <label class="filter-label">Price Range</label>
                                <div class="row">
                                    <div class="col-6">
                                        <input type="number" 
                                               name="min_price" 
                                               class="filter-input" 
                                               placeholder="Min $"
                                               value="{{ request('min_price') }}"
                                               min="{{ $priceRange['min'] }}"
                                               max="{{ $priceRange['max'] }}">
                                    </div>
                                    <div class="col-6">
                                        <input type="number" 
                                               name="max_price" 
                                               class="filter-input" 
                                               placeholder="Max $"
                                               value="{{ request('max_price') }}"
                                               min="{{ $priceRange['min'] }}"
                                               max="{{ $priceRange['max'] }}">
                                    </div>
                                </div>
                            </div>

                            <!-- RAM Filter -->
                            <div class="filter-group">
                                <label class="filter-label">RAM</label>
                                <select name="ram" class="filter-select" onchange="document.getElementById('filterForm').submit()">
                                    <option value="">All RAM</option>
                                    @foreach($rams as $ram)
                                        <option value="{{ $ram }}" {{ request('ram') == $ram ? 'selected' : '' }}>
                                            {{ $ram }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Storage Filter -->
                            <div class="filter-group">
                                <label class="filter-label">Storage</label>
                                <select name="storage" class="filter-select" onchange="document.getElementById('filterForm').submit()">
                                    <option value="">All Storage</option>
                                    @foreach($storages as $storage)
                                        <option value="{{ $storage }}" {{ request('storage') == $storage ? 'selected' : '' }}>
                                            {{ $storage }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" class="btn btn-warning w-100 mt-3">
                                <i class="fas fa-filter me-2"></i>Apply Filters
                            </button>
                            
                            <a href="{{ route('laptops.index') }}" class="btn btn-outline-light w-100 mt-2">
                                <i class="fas fa-times me-2"></i>Clear Filters
                            </a>
                        </form>
                    </div>
                </div>

                <!-- Products Section -->
                <div class="col-lg-9">
                    <!-- Sort Section -->
                    <div class="sort-section">
                        <span class="sort-label">Sort by:</span>
                        <form method="GET" action="{{ route('laptops.index') }}" class="d-flex align-items-center gap-2">
                            @foreach(request()->except(['sort', 'direction']) as $key => $value)
                                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                            @endforeach
                            
                            <select name="sort" class="sort-select" onchange="this.form.submit()">
                                <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name</option>
                                <option value="price" {{ request('sort') == 'price' ? 'selected' : '' }}>Price</option>
                                <option value="brand" {{ request('sort') == 'brand' ? 'selected' : '' }}>Brand</option>
                                <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>Newest</option>
                            </select>
                            
                            <select name="direction" class="sort-select" onchange="this.form.submit()">
                                <option value="asc" {{ request('direction') == 'asc' ? 'selected' : '' }}>Ascending</option>
                                <option value="desc" {{ request('direction') == 'desc' ? 'selected' : '' }}>Descending</option>
                            </select>
                        </form>
                    </div>

                    <!-- Products Grid -->
                    <div class="product-grid">
                        @forelse($laptops as $laptop)
                            <div class="product-card">
                                <img src="{{ $laptop->image ?? 'https://via.placeholder.com/300x200/2a2a2a/ffc107?text=Laptop' }}" 
                                     alt="{{ $laptop->name }}" 
                                     class="product-image">
                                
                                <div class="product-brand">{{ $laptop->brand }}</div>
                                <h5 class="product-title">{{ $laptop->name }}</h5>
                                
                                <div class="product-specs">
                                    <div><i class="fas fa-microchip me-1"></i> {{ $laptop->processor }}</div>
                                    <div><i class="fas fa-memory me-1"></i> {{ $laptop->ram }} RAM</div>
                                    <div><i class="fas fa-hdd me-1"></i> {{ $laptop->storage }}</div>
                                    <div><i class="fas fa-desktop me-1"></i> {{ $laptop->display }}</div>
                                </div>
                                
                                <div class="product-price">${{ number_format($laptop->price, 2) }}</div>
                                
                                <div class="product-stock {{ $laptop->stock_quantity <= 5 ? ($laptop->stock_quantity == 0 ? 'out' : 'low') : '' }}">
                                    @if($laptop->stock_quantity > 5)
                                        <i class="fas fa-check-circle me-1"></i> In Stock ({{ $laptop->stock_quantity }})
                                    @elseif($laptop->stock_quantity > 0)
                                        <i class="fas fa-exclamation-triangle me-1"></i> Low Stock ({{ $laptop->stock_quantity }})
                                    @else
                                        <i class="fas fa-times-circle me-1"></i> Out of Stock
                                    @endif
                                </div>
                                
                                <button class="add-to-cart-btn" 
                                        onclick="addToCart({{ $laptop->id }})"
                                        {{ $laptop->stock_quantity == 0 ? 'disabled' : '' }}>
                                    @if($laptop->stock_quantity > 0)
                                        <i class="fas fa-shopping-cart"></i>
                                        Add to Cart
                                    @else
                                        <i class="fas fa-ban"></i>
                                        Out of Stock
                                    @endif
                                </button>
                            </div>
                        @empty
                            <div class="col-12 text-center py-5">
                                <i class="fas fa-search fa-3x text-warning mb-3"></i>
                                <h3>No laptops found</h3>
                                <p class="text-muted">Try adjusting your search or filters</p>
                                <a href="{{ route('laptops.index') }}" class="btn btn-warning">
                                    <i class="fas fa-refresh me-2"></i>View All Laptops
                                </a>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    @if($laptops->hasPages())
                        <div class="pagination-wrapper">
                            {{ $laptops->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Initialize tooltips
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Update cart badge
            updateCartBadge();
        });

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
    </script>
</body>
</html>