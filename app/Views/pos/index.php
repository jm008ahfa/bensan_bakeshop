<div class="pos-container">
    <!-- Products Panel -->
    <div class="products-panel">
        <div class="products-header">
            <h2><i class="fas fa-box"></i> Products</h2>
            <p>Click on any product to add to cart</p>
        </div>
        <div class="products-grid">
            <?php if(isset($products) && !empty($products)): ?>
                <?php 
                // Remove duplicates by ID
                $uniqueProducts = [];
                foreach($products as $p) {
                    if (!isset($uniqueProducts[$p['id']])) {
                        $uniqueProducts[$p['id']] = $p;
                    }
                }
                ?>
                <?php foreach($uniqueProducts as $p): ?>
                <div class="product-item <?= $p['stock'] <= 0 ? 'out-of-stock' : '' ?>" 
                     data-id="<?= $p['id'] ?>"
                     data-name="<?= htmlspecialchars($p['name']) ?>"
                     data-price="<?= $p['price'] ?>"
                     data-stock="<?= $p['stock'] ?>"
                     onclick="addToCart(this)">
                    
                    <img src="<?= isset($p['image_url']) && $p['image_url'] ? $p['image_url'] : base_url('assets/images/default-product.png') ?>" 
                         class="product-img" alt="<?= $p['name'] ?>">
                    <div class="product-name"><?= htmlspecialchars($p['name']) ?></div>
                    <div class="product-price">₱<?= number_format($p['price'], 2) ?></div>
                    <div class="product-stock">Stock: <?= $p['stock'] ?></div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div style="grid-column: 1/-1; text-align: center; padding: 40px;">No products found. Please add products first.</div>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Cart Panel -->
    <div class="cart-panel">
        <div class="cart-header">
            <h2><i class="fas fa-shopping-cart"></i> Current Order</h2>
        </div>
        
        <div class="customer-form">
            <label>Customer Name</label>
            <input type="text" id="customerName" placeholder="Enter customer name" value="Walk-in Customer">
            <label>Order Type</label>
            <select id="orderType">
                <option value="walk_in">🏪 Walk-in Customer</option>
            </select>
        </div>
        
        <div class="cart-items" id="cartItems">
            <div class="cart-empty">
                <i class="fas fa-shopping-cart"></i>
                <p>Cart is empty</p>
                <small>Click on products to add</small>
            </div>
        </div>
        
        <div class="cart-footer">
            <div class="cart-total">
                <span>Total:</span>
                <span id="cartTotal">₱0.00</span>
            </div>
            <div class="cart-buttons">
                <button class="btn-complete" onclick="completeSale()">Complete Sale</button>
                <button class="btn-clear" onclick="clearCart()">Clear Cart</button>
            </div>
        </div>
    </div>
</div>

<!-- Receipt Modal -->
<div id="receiptModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <i class="fas fa-receipt" style="font-size: 2rem;"></i>
            <h3>Bensan Bakeshop</h3>
            <p>Order Receipt</p>
        </div>
        <div class="modal-body" id="receiptBody"></div>
        <div class="modal-footer">
            <button class="btn-print" onclick="printReceipt()">🖨️ Print</button>
            <button class="btn-close-modal" onclick="closeReceipt()">Close</button>
        </div>
    </div>
</div>

<div id="toast" class="toast"></div>

<style>
    .pos-container {
        display: flex;
        gap: 24px;
        min-height: calc(100vh - 150px);
    }
    
    .products-panel {
        flex: 2;
        background: white;
        border-radius: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }
    
    .products-header {
        padding: 20px 24px;
        border-bottom: 1px solid #eef2f7;
    }
    
    .products-header h2 {
        font-size: 1.2rem;
        font-weight: 600;
        margin: 0;
    }
    
    .products-header p {
        font-size: 0.8rem;
        color: #6c757d;
        margin-top: 4px;
    }
    
    .products-grid {
        padding: 20px 24px;
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 16px;
        overflow-y: auto;
        max-height: calc(100vh - 200px);
    }
    
    .product-item {
        background: #f8f9fa;
        border-radius: 16px;
        padding: 16px;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s;
        border: 2px solid transparent;
    }
    
    .product-item:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        border-color: #ff6b35;
        background: white;
    }
    
    .product-item.out-of-stock {
        opacity: 0.5;
        cursor: not-allowed;
    }
    
    .product-img {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 12px;
        margin-bottom: 12px;
    }
    
    .product-name {
        font-weight: 600;
        font-size: 0.85rem;
        margin-bottom: 4px;
        color: #1a1a2e;
    }
    
    .product-price {
        font-weight: 700;
        font-size: 0.9rem;
        color: #ff6b35;
    }
    
    .product-stock {
        font-size: 0.65rem;
        color: #6c757d;
        margin-top: 4px;
    }
    
    .cart-panel {
        flex: 1;
        background: white;
        border-radius: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }
    
    .cart-header {
        padding: 20px 24px;
        border-bottom: 1px solid #eef2f7;
    }
    
    .cart-header h2 {
        font-size: 1.2rem;
        font-weight: 600;
        margin: 0;
    }
    
    .customer-form {
        padding: 20px 24px;
        background: #f8f9fa;
        border-bottom: 1px solid #eef2f7;
    }
    
    .customer-form label {
        display: block;
        font-size: 0.75rem;
        font-weight: 600;
        margin-bottom: 6px;
        color: #1a1a2e;
    }
    
    .customer-form input,
    .customer-form select {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #e9ecef;
        border-radius: 10px;
        font-family: 'Inter', sans-serif;
        font-size: 0.85rem;
        margin-bottom: 12px;
    }
    
    .cart-items {
        flex: 1;
        overflow-y: auto;
        padding: 16px 24px;
        min-height: 200px;
    }
    
    .cart-empty {
        text-align: center;
        color: #adb5bd;
        padding: 40px 20px;
    }
    
    .cart-empty i {
        font-size: 48px;
        margin-bottom: 12px;
        opacity: 0.5;
    }
    
    .cart-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 0;
        border-bottom: 1px solid #eef2f7;
    }
    
    .cart-item-info {
        flex: 2;
    }
    
    .cart-item-name {
        font-weight: 600;
        font-size: 0.85rem;
    }
    
    .cart-item-price {
        font-size: 0.7rem;
        color: #6c757d;
    }
    
    .cart-item-actions {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .cart-item-qty {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .cart-item-qty button {
        width: 26px;
        height: 26px;
        border-radius: 50%;
        border: 1px solid #e9ecef;
        background: white;
        cursor: pointer;
        font-weight: bold;
    }
    
    .cart-item-qty span {
        min-width: 24px;
        text-align: center;
        font-size: 0.85rem;
    }
    
    .cart-item-total {
        font-weight: 600;
        color: #ff6b35;
        min-width: 70px;
        text-align: right;
        font-size: 0.85rem;
    }
    
    .cart-item-remove {
        color: #dc3545;
        cursor: pointer;
        margin-left: 8px;
    }
    
    .cart-footer {
        padding: 20px 24px;
        border-top: 1px solid #eef2f7;
    }
    
    .cart-total {
        display: flex;
        justify-content: space-between;
        font-weight: 700;
        font-size: 1.2rem;
        margin-bottom: 16px;
    }
    
    .cart-total span:last-child {
        color: #ff6b35;
    }
    
    .cart-buttons {
        display: flex;
        gap: 12px;
    }
    
    .btn-complete {
        flex: 1;
        padding: 12px;
        background: #28a745;
        color: white;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
    }
    
    .btn-clear {
        flex: 1;
        padding: 12px;
        background: #dc3545;
        color: white;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
    }
    
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.5);
        z-index: 2000;
        justify-content: center;
        align-items: center;
    }
    
    .modal-content {
        background: white;
        width: 400px;
        max-width: 90%;
        border-radius: 20px;
        overflow: hidden;
    }
    
    .modal-header {
        background: #1a1a2e;
        color: white;
        padding: 20px;
        text-align: center;
    }
    
    .modal-body {
        padding: 20px;
    }
    
    .modal-footer {
        padding: 15px 20px;
        border-top: 1px solid #eef2f7;
        display: flex;
        gap: 10px;
    }
    
    .btn-print {
        flex: 1;
        padding: 10px;
        background: #ff6b35;
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;
    }
    
    .btn-close-modal {
        flex: 1;
        padding: 10px;
        background: #6c757d;
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;
    }
    
    .toast {
        position: fixed;
        bottom: 24px;
        right: 24px;
        padding: 12px 20px;
        border-radius: 10px;
        color: white;
        z-index: 2100;
        display: none;
    }
    
    @media (max-width: 768px) {
        .pos-container {
            flex-direction: column;
        }
    }
</style>

<script>
let cart = [];

function addToCart(element) {
    if (element.classList.contains('out-of-stock')) {
        showMessage('Product is out of stock!', 'error');
        return;
    }
    
    const id = element.dataset.id;
    const name = element.dataset.name;
    const price = parseFloat(element.dataset.price);
    const stock = parseInt(element.dataset.stock);
    
    const existing = cart.find(item => item.id === id);
    
    if (existing) {
        if (existing.quantity < stock) {
            existing.quantity++;
        } else {
            showMessage('Not enough stock!', 'error');
            return;
        }
    } else {
        cart.push({ id, name, price, quantity: 1, stock });
    }
    
    updateCart();
    showMessage(`${name} added to cart!`, 'success');
}

function updateCart() {
    const container = document.getElementById('cartItems');
    const totalSpan = document.getElementById('cartTotal');
    
    if (cart.length === 0) {
        container.innerHTML = '<div class="cart-empty"><i class="fas fa-shopping-cart"></i><p>Cart is empty</p><small>Click on products to add</small></div>';
        totalSpan.innerText = '₱0.00';
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
                    <div class="cart-item-name">${escapeHtml(item.name)}</div>
                    <div class="cart-item-price">₱${item.price.toFixed(2)} each</div>
                </div>
                <div class="cart-item-actions">
                    <div class="cart-item-qty">
                        <button onclick="updateQuantity(${index}, -1)">-</button>
                        <span>${item.quantity}</span>
                        <button onclick="updateQuantity(${index}, 1)">+</button>
                    </div>
                    <div class="cart-item-total">₱${itemTotal.toFixed(2)}</div>
                    <div class="cart-item-remove" onclick="removeFromCart(${index})">
                        <i class="fas fa-trash"></i>
                    </div>
                </div>
            </div>
        `;
    });
    
    container.innerHTML = html;
    totalSpan.innerText = `₱${total.toFixed(2)}`;
}

function escapeHtml(str) {
    return str.replace(/[&<>]/g, function(m) {
        if (m === '&') return '&amp;';
        if (m === '<') return '&lt;';
        if (m === '>') return '&gt;';
        return m;
    });
}

function updateQuantity(index, change) {
    const item = cart[index];
    const newQty = item.quantity + change;
    
    if (newQty < 1) {
        cart.splice(index, 1);
    } else if (newQty <= item.stock) {
        item.quantity = newQty;
    } else {
        showMessage(`Only ${item.stock} available!`, 'error');
        return;
    }
    updateCart();
}

function removeFromCart(index) {
    cart.splice(index, 1);
    updateCart();
}

function clearCart() {
    if (cart.length > 0 && confirm('Clear entire cart?')) {
        cart = [];
        updateCart();
        showMessage('Cart cleared!', 'success');
    }
}

function completeSale() {
    if (cart.length === 0) {
        showMessage('Cart is empty!', 'error');
        return;
    }
    
    const btn = document.querySelector('.btn-complete');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
    
    fetch('<?= base_url("/pos/processOrder") ?>', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams({
            'cart': JSON.stringify(cart),
            'customer_name': document.getElementById('customerName').value,
            'order_type': document.getElementById('orderType').value
        })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            showReceipt(data.receipt);
            cart = [];
            updateCart();
            showMessage(data.message, 'success');
        } else {
            showMessage(data.message, 'error');
        }
    })
    .catch(err => {
        console.error('Error:', err);
        showMessage('Network error. Please try again.', 'error');
    })
    .finally(() => {
        btn.disabled = false;
        btn.innerHTML = 'Complete Sale';
    });
}

function showReceipt(data) {
    let itemsHtml = '';
    data.items.forEach(item => {
        itemsHtml += `<div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
            <span>${escapeHtml(item.name)} x ${item.quantity}</span>
            <span>₱${item.subtotal.toFixed(2)}</span>
        </div>`;
    });
    
    document.getElementById('receiptBody').innerHTML = `
        <div style="text-align: center; margin-bottom: 15px;">
            <p><strong>${data.order_number}</strong></p>
            <p>${data.order_date}</p>
            <p>${escapeHtml(data.customer_name)}</p>
            <p>Cashier: ${escapeHtml(data.cashier)}</p>
        </div>
        <div style="border-top: 1px dashed #ddd; border-bottom: 1px dashed #ddd; padding: 10px 0;">
            ${itemsHtml}
        </div>
        <div style="display: flex; justify-content: space-between; font-weight: bold; margin-top: 10px;">
            <span>TOTAL</span>
            <span>₱${data.total.toFixed(2)}</span>
        </div>
        <div style="text-align: center; margin-top: 15px; font-size: 11px; color: #6c757d;">
            Thank you for your purchase!
        </div>
    `;
    document.getElementById('receiptModal').style.display = 'flex';
}

function printReceipt() {
    const content = document.getElementById('receiptBody').innerHTML;
    const win = window.open('', '_blank');
    win.document.write(`
        <html><head><title>Receipt - Bensan Bakeshop</title>
        <style>body{font-family: monospace; padding: 20px; width: 300px; margin: 0 auto;}</style>
        </head><body>${content}</body></html>
    `);
    win.document.close();
    win.print();
    win.close();
}

function closeReceipt() {
    document.getElementById('receiptModal').style.display = 'none';
    setTimeout(() => location.reload(), 1000);
}

function showMessage(msg, type) {
    const toast = document.getElementById('toast');
    toast.style.background = type === 'success' ? '#28a745' : '#dc3545';
    toast.innerHTML = `<i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i> ${msg}`;
    toast.style.display = 'block';
    setTimeout(() => {
        toast.style.display = 'none';
    }, 2000);
}
</script>