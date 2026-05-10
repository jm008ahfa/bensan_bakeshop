<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bensan Bakeshop - <?= $title ?? 'Home' ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #f5f7fa;
            color: #1a1a2e;
        }

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
            gap: 32px;
            align-items: center;
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

        .main-content {
            min-height: calc(100vh - 300px);
        }

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
            color: #1a1a2e;
        }

        .footer-col p, .footer-col a {
            font-size: 0.8rem;
            color: #6c757d;
            text-decoration: none;
            line-height: 1.8;
        }

        .footer-col a:hover {
            color: #ff6b35;
        }

        .copyright {
            text-align: center;
            font-size: 0.7rem;
            color: #adb5bd;
            padding-top: 24px;
            border-top: 1px solid #eef2f7;
        }

        /* Cart Sidebar */
        .cart-sidebar {
            position: fixed;
            top: 0;
            right: -420px;
            width: 400px;
            height: 100%;
            background: white;
            box-shadow: -5px 0 30px rgba(0,0,0,0.05);
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

        .cart-header h3 {
            font-size: 1.1rem;
            font-weight: 600;
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

        .cart-item-info p {
            font-size: 0.75rem;
            color: #6c757d;
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
            font-weight: 500;
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
            font-size: 0.8rem;
            z-index: 1100;
            display: none;
        }

        @media (max-width: 768px) {
            .nav-links {
                gap: 16px;
            }
            .cart-sidebar {
                width: 100%;
                right: -100%;
            }
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar">
    <div class="container">
        <a href="<?= base_url('/customer') ?>" class="logo">
            <i class="fas fa-bread-slice"></i> Bensan Bakeshop
        </a>
        <div class="nav-links">
            <a href="<?= base_url('/customer') ?>">Home</a>
            <a href="<?= base_url('/customer/products') ?>">Products</a>
            <a href="<?= base_url('/customer/trackOrder') ?>">Track Order</a>
            <div class="cart-icon" onclick="toggleCart()">
                <i class="fas fa-shopping-bag"></i>
                <span class="cart-count" id="cartCount">0</span>
            </div>
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
                <p><a href="<?= base_url('/customer') ?>">Home</a></p>
                <p><a href="<?= base_url('/customer/products') ?>">Products</a></p>
                <p><a href="<?= base_url('/customer/trackOrder') ?>">Track Order</a></p>
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
<div class="overlay" id="overlay" onclick="toggleCart()"></div>
<div class="cart-sidebar" id="cartSidebar">
    <div class="cart-header">
        <h3>Your Cart</h3>
        <button class="cart-close" onclick="toggleCart()">&times;</button>
    </div>
    <div class="cart-items" id="cartItemsList">
        <div class="cart-empty">Your cart is empty</div>
    </div>
    <div class="cart-footer">
        <div class="cart-total">
            <span>Total</span>
            <span id="cartTotalAmount">₱0</span>
        </div>
        <button class="btn-checkout" onclick="showCheckout()">Checkout</button>
    </div>
</div>

<div class="toast-msg" id="toastMsg"></div>

<!-- Checkout Modal -->
<div id="checkoutModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 2000; justify-content: center; align-items: center;">
    <div style="background: white; width: 500px; max-width: 90%; border-radius: 24px; overflow: hidden;">
        <div style="padding: 24px; background: #1a1a2e; color: white; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="margin: 0;"><i class="fas fa-clipboard-list"></i> Checkout</h3>
            <button onclick="closeCheckout()" style="background: none; border: none; color: white; font-size: 24px; cursor: pointer;">&times;</button>
        </div>
        <div style="padding: 24px;">
            <form id="checkoutForm">
                <div style="margin-bottom: 16px;">
                    <label style="display: block; font-weight: 600; margin-bottom: 6px;">Full Name</label>
                    <input type="text" id="customerName" required style="width: 100%; padding: 12px; border: 1px solid #eef2f7; border-radius: 12px;">
                </div>
                <div style="margin-bottom: 16px;">
                    <label style="display: block; font-weight: 600; margin-bottom: 6px;">Email</label>
                    <input type="email" id="customerEmail" required style="width: 100%; padding: 12px; border: 1px solid #eef2f7; border-radius: 12px;">
                </div>
                <div style="margin-bottom: 16px;">
                    <label style="display: block; font-weight: 600; margin-bottom: 6px;">Phone</label>
                    <input type="tel" id="customerPhone" required style="width: 100%; padding: 12px; border: 1px solid #eef2f7; border-radius: 12px;">
                </div>
                <div style="margin-bottom: 16px;">
                    <label style="display: block; font-weight: 600; margin-bottom: 6px;">Address</label>
                    <textarea id="deliveryAddress" rows="3" required style="width: 100%; padding: 12px; border: 1px solid #eef2f7; border-radius: 12px;"></textarea>
                </div>
                <div style="background: #f8f9fa; padding: 16px; border-radius: 12px; margin-bottom: 20px;">
                    <div style="display: flex; justify-content: space-between;">
                        <span>Total:</span>
                        <span id="checkoutTotal" style="color: #ff6b35; font-weight: bold;">₱0</span>
                    </div>
                </div>
                <button type="submit" style="width: 100%; padding: 14px; background: #ff6b35; color: white; border: none; border-radius: 40px; font-weight: 600; cursor: pointer;">Place Order</button>
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

<script>
let cart = [];
let totalAmount = 0;

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
        cart.push({ id, name, price, quantity: 1, stock });
    }
    saveCart();
    updateCartUI();
    showToast(`${name} added to cart`, 'success');
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
        totalAmount = 0;
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
                    <button onclick="updateQty(${index}, -1)">−</button>
                    <span>${item.quantity}</span>
                    <button onclick="updateQty(${index}, 1)">+</button>
                </div>
                <div class="cart-item-total">₱${itemTotal.toFixed(2)}</div>
            </div>
        `;
    });
    
    container.innerHTML = html;
    if (totalSpan) totalSpan.innerText = `₱${total.toFixed(2)}`;
    if (countSpan) countSpan.innerText = cart.reduce((sum, i) => sum + i.quantity, 0);
    totalAmount = total;
}

function updateQty(index, change) {
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
    if (sidebar) {
        sidebar.classList.toggle('open');
        overlay.classList.toggle('show');
    }
}

function showCheckout() {
    if (cart.length === 0) {
        showToast('Cart is empty!', 'error');
        return;
    }
    document.getElementById('checkoutTotal').innerText = `₱${totalAmount.toFixed(2)}`;
    document.getElementById('checkoutModal').style.display = 'flex';
    document.getElementById('overlay').classList.add('show');
    toggleCart();
}

function closeCheckout() {
    document.getElementById('checkoutModal').style.display = 'none';
    document.getElementById('overlay').classList.remove('show');
}

function closeSuccessModal() {
    document.getElementById('successModal').style.display = 'none';
    document.getElementById('overlay').classList.remove('show');
    cart = [];
    saveCart();
    updateCartUI();
    window.location.href = '<?= base_url("/customer") ?>';
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

// Checkout form submission
document.getElementById('checkoutForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const btn = this.querySelector('button[type="submit"]');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
    
    const orderData = {
        cart: JSON.stringify(cart),
        customer_name: document.getElementById('customerName').value,
        customer_email: document.getElementById('customerEmail').value,
        customer_phone: document.getElementById('customerPhone').value,
        delivery_address: document.getElementById('deliveryAddress').value
    };
    
    try {
        const response = await fetch('<?= base_url("/customer/placeOrder") ?>', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams(orderData)
        });
        
        const data = await response.json();
        
        if (data.success) {
            closeCheckout();
            document.getElementById('successMessage').innerHTML = `Order #${data.order_number}<br>Total: ₱${data.total.toFixed(2)}`;
            document.getElementById('successModal').style.display = 'flex';
            document.getElementById('overlay').classList.add('show');
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