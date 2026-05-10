<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bensan Bakeshop - <?= $title ?? 'Store' ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #fafbfc;
            color: #1a1a2e;
        }

        /* Navbar */
        .navbar {
            background: white;
            padding: 16px 0;
            border-bottom: 1px solid #eef2f7;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
        }

        .navbar .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 16px;
        }

        .logo {
            font-size: 1.3rem;
            font-weight: 700;
            color: #1a1a2e;
            text-decoration: none;
        }

        .logo i {
            color: #ff6b35;
            margin-right: 8px;
        }

        .nav-links {
            display: flex;
            gap: 24px;
            align-items: center;
            flex-wrap: wrap;
        }

        .nav-links a {
            text-decoration: none;
            color: #4a5568;
            font-size: 0.9rem;
            font-weight: 500;
            transition: color 0.2s;
        }

        .nav-links a:hover {
            color: #ff6b35;
        }

        .cart-icon {
            position: relative;
            cursor: pointer;
        }

        .cart-count {
            position: absolute;
            top: -8px;
            right: -12px;
            background: #ff6b35;
            color: white;
            font-size: 10px;
            font-weight: 600;
            padding: 2px 6px;
            border-radius: 20px;
        }

        .user-name {
            color: #ff6b35;
            font-weight: 600;
            font-size: 0.85rem;
        }

        .logout-btn {
            color: #dc3545 !important;
        }

        /* Product Card */
        .product-card {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            transition: transform 0.3s;
            cursor: pointer;
            border: 1px solid #eef2f7;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

        .product-image {
            width: 100%;
            height: 180px;
            object-fit: cover;
        }

        .product-info {
            padding: 15px;
        }

        .product-name {
            font-weight: 600;
            font-size: 1rem;
            margin-bottom: 5px;
            color: #1a1a2e;
        }

        .product-price {
            color: #ff6b35;
            font-weight: bold;
            font-size: 1.1rem;
        }

        .btn-add-cart {
            background: #1a1a2e;
            color: white;
            border: none;
            padding: 8px;
            border-radius: 25px;
            width: 100%;
            margin-top: 10px;
            font-size: 0.8rem;
            cursor: pointer;
            transition: background 0.2s;
        }

        .btn-add-cart:hover {
            background: #ff6b35;
        }

        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, #ff6b35, #ff8c42);
            color: white;
            padding: 80px 0;
            text-align: center;
            margin-bottom: 40px;
        }

        .hero h1 {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 16px;
        }

        .hero p {
            font-size: 1.1rem;
            opacity: 0.9;
            margin-bottom: 32px;
        }

        .shop-btn {
            background: white;
            color: #ff6b35;
            padding: 12px 32px;
            border-radius: 40px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.2s;
            display: inline-block;
        }

        .shop-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        /* Category Grid */
        .categories-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 20px;
            margin-bottom: 60px;
        }

        .category-card {
            background: white;
            border: 1px solid #eef2f7;
            border-radius: 16px;
            padding: 24px;
            text-align: center;
            text-decoration: none;
            transition: all 0.2s;
            display: block;
        }

        .category-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            border-color: #ff6b35;
        }

        .category-card i {
            font-size: 2rem;
            color: #ff6b35;
            margin-bottom: 12px;
        }

        .category-card span {
            color: #1a1a2e;
            font-weight: 500;
        }

        /* Products Grid */
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 30px;
            margin-top: 40px;
        }

        /* Cart Sidebar */
        .cart-sidebar {
            position: fixed;
            top: 0;
            right: -420px;
            width: 400px;
            height: 100%;
            background: white;
            box-shadow: -5px 0 30px rgba(0,0,0,0.1);
            z-index: 1000;
            transition: right 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        .cart-sidebar.open {
            right: 0;
        }

        .cart-header {
            padding: 20px 24px;
            border-bottom: 1px solid #eef2f7;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .cart-close {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: #6c757d;
        }

        .cart-items {
            flex: 1;
            overflow-y: auto;
            padding: 20px 24px;
        }

        .cart-empty {
            text-align: center;
            color: #adb5bd;
            padding: 60px 20px;
        }

        .cart-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #eef2f7;
        }

        .cart-item-info h4 {
            font-size: 0.9rem;
            font-weight: 500;
            margin-bottom: 4px;
        }

        .cart-item-quantity {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .cart-item-quantity button {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            border: 1px solid #eef2f7;
            background: white;
            cursor: pointer;
        }

        .cart-item-total {
            font-weight: 600;
            color: #ff6b35;
            min-width: 70px;
            text-align: right;
        }

        .cart-footer {
            padding: 20px 24px;
            border-top: 1px solid #eef2f7;
        }

        .cart-total {
            display: flex;
            justify-content: space-between;
            font-weight: 600;
            margin-bottom: 16px;
        }

        .btn-checkout {
            width: 100%;
            padding: 12px;
            background: #ff6b35;
            color: white;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
        }

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.3);
            z-index: 999;
            display: none;
        }

        .overlay.show {
            display: block;
        }

        .toast-msg {
            position: fixed;
            bottom: 24px;
            right: 24px;
            background: #1a1a2e;
            color: white;
            padding: 10px 20px;
            border-radius: 10px;
            z-index: 1100;
            display: none;
        }

        /* Footer */
        .footer {
            background: white;
            border-top: 1px solid #eef2f7;
            padding: 48px 0 24px;
            margin-top: 60px;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 40px;
            margin-bottom: 40px;
        }

        .footer-col h4 {
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 16px;
        }

        .footer-col p, .footer-col a {
            font-size: 0.8rem;
            color: #6c757d;
            text-decoration: none;
            line-height: 1.8;
        }

        .copyright {
            text-align: center;
            font-size: 0.7rem;
            color: #adb5bd;
            padding-top: 24px;
            border-top: 1px solid #eef2f7;
        }

        @media (max-width: 768px) {
            .cart-sidebar {
                width: 100%;
                right: -100%;
            }
            .hero h1 {
                font-size: 2rem;
            }
            .products-grid {
                grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            }
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar">
    <div class="container">
        <a href="<?= base_url('/customer/store') ?>" class="logo">
            <i class="fas fa-bread-slice"></i> Bensan Bakeshop
        </a>
        <div class="nav-links">
            <a href="<?= base_url('/customer/store') ?>">Shop</a>
            <a href="<?= base_url('/customer/products') ?>">Products</a>
            <a href="<?= base_url('/customer/track-order') ?>">Track Orders</a>
            <a href="<?= base_url('/customer/account') ?>">My Account</a>
            <div class="cart-icon" onclick="toggleCart()">
                <i class="fas fa-shopping-bag"></i>
                <span class="cart-count" id="cartCount">0</span>
            </div>
            <span class="user-name">Hi, <?= session()->get('customer_name') ?></span>
            <a href="<?= base_url('/customer/logout') ?>" class="logout-btn">Logout</a>
        </div>
    </div>
</nav>

<!-- Main Content -->
<div class="main-content">
    <?= $content ?>
</div>

<!-- Footer -->
<footer class="footer">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-col">
                <h4>Bensan Bakeshop</h4>
                <p>Freshly baked goods made with love.</p>
            </div>
            <div class="footer-col">
                <h4>Quick Links</h4>
                <p><a href="<?= base_url('/customer/store') ?>">Shop</a></p>
                <p><a href="<?= base_url('/customer/products') ?>">Products</a></p>
                <p><a href="<?= base_url('/customer/track-order') ?>">Track Orders</a></p>
                <p><a href="<?= base_url('/customer/account') ?>">My Account</a></p>
            </div>
            <div class="footer-col">
                <h4>Contact</h4>
                <p><i class="fas fa-phone"></i> +63 912 345 6789</p>
                <p><i class="fas fa-envelope"></i> hello@bensan.com</p>
            </div>
        </div>
        <div class="copyright">
            <p>&copy; 2024 Bensan Bakeshop. All rights reserved.</p>
        </div>
    </div>
</footer>

<!-- Cart Sidebar -->
<div class="overlay" id="overlay" onclick="closeCart()"></div>
<div class="cart-sidebar" id="cartSidebar">
    <div class="cart-header">
        <h3><i class="fas fa-shopping-cart"></i> Your Cart</h3>
        <button class="cart-close" onclick="closeCart()">&times;</button>
    </div>
    <div class="cart-items" id="cartItemsList">
        <div class="cart-empty">Your cart is empty</div>
    </div>
    <div class="cart-footer">
        <div class="cart-total">
            <span>Total</span>
            <span id="cartTotalAmount">₱0</span>
        </div>
        <button class="btn-checkout" onclick="showCheckout()">Proceed to Checkout</button>
    </div>
</div>

<!-- Checkout Modal -->
<div id="checkoutModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 2000; justify-content: center; align-items: center;">
    <div style="background: white; width: 500px; max-width: 90%; border-radius: 24px; overflow: hidden;">
        <div style="padding: 20px 24px; background: #1a1a2e; color: white; display: flex; justify-content: space-between;">
            <h3>Checkout</h3>
            <button onclick="closeCheckout()" style="background: none; border: none; color: white; font-size: 24px;">&times;</button>
        </div>
        <div style="padding: 24px;">
            <form id="checkoutForm">
                <input type="text" id="customerName" value="<?= session()->get('customer_name') ?>" placeholder="Full Name" required style="width: 100%; padding: 12px; margin-bottom: 12px; border: 1px solid #eef2f7; border-radius: 12px;">
                <input type="email" id="customerEmail" value="<?= session()->get('customer_email') ?>" placeholder="Email" required style="width: 100%; padding: 12px; margin-bottom: 12px; border: 1px solid #eef2f7; border-radius: 12px;">
                <input type="tel" id="customerPhone" value="<?= session()->get('customer_phone') ?>" placeholder="Phone" required style="width: 100%; padding: 12px; margin-bottom: 12px; border: 1px solid #eef2f7; border-radius: 12px;">
                <textarea id="deliveryAddress" rows="3" placeholder="Delivery Address" required style="width: 100%; padding: 12px; margin-bottom: 12px; border: 1px solid #eef2f7; border-radius: 12px;"><?= session()->get('customer_address') ?></textarea>
                <div id="orderSummary" style="background: #f8f9fa; padding: 16px; border-radius: 12px; margin-bottom: 16px;"></div>
                <button type="submit" style="width: 100%; padding: 14px; background: #28a745; color: white; border: none; border-radius: 40px; font-weight: 600;">Place Order</button>
            </form>
        </div>
    </div>
</div>

<!-- Success Modal -->
<div id="successModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 2000; justify-content: center; align-items: center;">
    <div style="background: white; width: 400px; max-width: 90%; border-radius: 24px; text-align: center; padding: 32px;">
        <i class="fas fa-check-circle" style="font-size: 64px; color: #28a745; margin-bottom: 16px;"></i>
        <h3>Order Placed!</h3>
        <p id="successMessage" style="margin: 16px 0;">Your order has been received</p>
        <button onclick="closeSuccessModal()" style="padding: 12px 24px; background: #ff6b35; color: white; border: none; border-radius: 40px; cursor: pointer;">Continue Shopping</button>
    </div>
</div>

<div class="toast-msg" id="toastMsg"></div>

<script>
let cart = [];

function loadCart() {
    const saved = localStorage.getItem('bensan_cart');
    if (saved) {
        cart = JSON.parse(saved);
        updateCartUI();
    }
}

function saveCart() {
    localStorage.setItem('bensan_cart', JSON.stringify(cart));
}

function addToCart(id, name, price, stock) {
    const existing = cart.find(item => item.id == id);
    if (existing) {
        if (existing.quantity < stock) {
            existing.quantity++;
        } else {
            showToast('Not enough stock!', 'error');
            return;
        }
    } else {
        cart.push({ id: id, name: name, price: price, quantity: 1, stock: stock });
    }
    saveCart();
    updateCartUI();
    showToast(`${name} added to cart!`, 'success');
}

function updateCartUI() {
    const container = document.getElementById('cartItemsList');
    const totalSpan = document.getElementById('cartTotalAmount');
    const countSpan = document.getElementById('cartCount');
    
    if (!container) return;
    
    if (cart.length === 0) {
        container.innerHTML = '<div class="cart-empty">Your cart is empty</div>';
        if (totalSpan) totalSpan.innerText = '₱0';
        if (countSpan) countSpan.innerText = '0';
        return;
    }
    
    let html = '';
    let total = 0;
    
    cart.forEach((item, index) => {
        const itemTotal = item.price * item.quantity;
        total += itemTotal;
        html += `
            <div class="cart-item">
                <div class="cart-item-info">
                    <h4>${item.name}</h4>
                    <p>₱${item.price.toFixed(2)} each</p>
                </div>
                <div class="cart-item-quantity">
                    <button onclick="updateQuantity(${index}, -1)">−</button>
                    <span>${item.quantity}</span>
                    <button onclick="updateQuantity(${index}, 1)">+</button>
                </div>
                <div class="cart-item-total">₱${itemTotal.toFixed(2)}</div>
            </div>
        `;
    });
    
    container.innerHTML = html;
    if (totalSpan) totalSpan.innerText = `₱${total.toFixed(2)}`;
    if (countSpan) countSpan.innerText = cart.reduce((sum, i) => sum + i.quantity, 0);
}

function updateQuantity(index, change) {
    const item = cart[index];
    const newQty = item.quantity + change;
    if (newQty < 1) {
        cart.splice(index, 1);
    } else if (newQty <= item.stock) {
        item.quantity = newQty;
    } else {
        showToast(`Only ${item.stock} available`, 'error');
        return;
    }
    saveCart();
    updateCartUI();
}

function toggleCart() {
    const sidebar = document.getElementById('cartSidebar');
    const overlay = document.getElementById('overlay');
    sidebar.classList.toggle('open');
    overlay.classList.toggle('show');
}

function closeCart() {
    const sidebar = document.getElementById('cartSidebar');
    const overlay = document.getElementById('overlay');
    sidebar.classList.remove('open');
    overlay.classList.remove('show');
}

function showCheckout() {
    if (cart.length === 0) {
        showToast('Cart is empty!', 'error');
        return;
    }
    let summaryHtml = '', total = 0;
    cart.forEach(item => {
        const itemTotal = item.price * item.quantity;
        total += itemTotal;
        summaryHtml += `<div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
            <span>${item.name} x ${item.quantity}</span>
            <span>₱${itemTotal.toFixed(2)}</span>
        </div>`;
    });
    summaryHtml += `<div style="display: flex; justify-content: space-between; font-weight: bold; border-top: 1px solid #eef2f7; padding-top: 12px; margin-top: 8px;">
        <span>Total:</span>
        <span>₱${total.toFixed(2)}</span>
    </div>`;
    document.getElementById('orderSummary').innerHTML = summaryHtml;
    closeCart();
    document.getElementById('checkoutModal').style.display = 'flex';
}

function closeCheckout() {
    document.getElementById('checkoutModal').style.display = 'none';
}

function closeSuccessModal() {
    document.getElementById('successModal').style.display = 'none';
    cart = [];
    saveCart();
    updateCartUI();
    window.location.href = '<?= base_url("/customer/store") ?>';
}

function showToast(msg, type) {
    const toast = document.getElementById('toastMsg');
    toast.textContent = msg;
    toast.style.background = type === 'success' ? '#28a745' : '#dc3545';
    toast.style.display = 'block';
    setTimeout(() => {
        toast.style.display = 'none';
    }, 2000);
}

document.getElementById('checkoutForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    if (cart.length === 0) {
        showToast('Cart is empty!', 'error');
        return;
    }
    const btn = this.querySelector('button[type="submit"]');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
    try {
        const response = await fetch('<?= base_url("/customer/placeOrder") ?>', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({
                'cart': JSON.stringify(cart),
                'customer_name': document.getElementById('customerName').value,
                'customer_email': document.getElementById('customerEmail').value,
                'customer_phone': document.getElementById('customerPhone').value,
                'delivery_address': document.getElementById('deliveryAddress').value
            })
        });
        const data = await response.json();
        if (data.success) {
            closeCheckout();
            document.getElementById('successMessage').innerHTML = `Order #${data.order_number}<br>Total: ₱${data.total.toFixed(2)}`;
            document.getElementById('successModal').style.display = 'flex';
            showToast('Order placed successfully!', 'success');
        } else {
            showToast(data.message, 'error');
        }
    } catch (error) {
        showToast('Failed to place order!', 'error');
    } finally {
        btn.disabled = false;
        btn.innerHTML = 'Place Order';
    }
});

loadCart();
</script>
</body>
</html>