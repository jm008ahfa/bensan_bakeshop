<div style="max-width: 1200px; margin: 0 auto; padding: 40px 24px;">
    
    <?php if(isset($product)): ?>
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 48px;">
        
        <!-- Product Image -->
        <div>
            <img src="<?= $product['image_url'] ?? base_url('assets/images/default-product.png') ?>" 
                 style="width: 100%; border-radius: 24px;" 
                 alt="<?= $product['name'] ?>">
        </div>
        
        <!-- Product Info -->
        <div>
            <h1 style="font-size: 2rem; font-weight: 600; margin-bottom: 12px;"><?= $product['name'] ?></h1>
            <p style="color: #ff6b35; font-size: 1.8rem; font-weight: 700; margin-bottom: 16px;">₱<?= number_format($product['price'], 2) ?></p>
            <p style="color: #6c757d; margin-bottom: 24px;">Freshly baked <?= $product['name'] ?> made with quality ingredients.</p>
            
            <div style="margin-bottom: 24px;">
                <span style="background: #f8f9fa; padding: 6px 12px; border-radius: 20px; font-size: 0.8rem;">
                    Stock: <?= $product['stock'] ?> units available
                </span>
            </div>
            
            <!-- Quantity Selector -->
            <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 32px;">
                <label style="font-weight: 600;">Quantity:</label>
                <div style="display: flex; align-items: center; border: 1px solid #eef2f7; border-radius: 40px;">
                    <button onclick="decrementQty()" style="width: 40px; height: 40px; border: none; background: none; font-size: 20px; cursor: pointer;">−</button>
                    <span id="qtyDisplay" style="width: 50px; text-align: center; font-weight: 600;">1</span>
                    <button onclick="incrementQty()" style="width: 40px; height: 40px; border: none; background: none; font-size: 20px; cursor: pointer;">+</button>
                </div>
            </div>
            
            <!-- Add to Cart Button -->
            <button onclick="addToCartFromDetail()" 
                    style="width: 100%; padding: 16px; background: #1a1a2e; color: white; border: none; border-radius: 40px; font-weight: 600; font-size: 1rem; cursor: pointer; margin-bottom: 16px;">
                <i class="fas fa-cart-plus"></i> Add to Cart
            </button>
            
            <a href="<?= base_url('/customer/products') ?>" style="color: #6c757d; text-decoration: none;">← Back to Products</a>
        </div>
    </div>
    <?php endif; ?>
    
    <!-- Related Products -->
    <?php if(isset($related) && !empty($related)): ?>
    <div style="margin-top: 60px;">
        <h2 style="font-size: 1.3rem; font-weight: 600; margin-bottom: 24px;">You May Also Like</h2>
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 24px;">
            <?php foreach($related as $r): ?>
            <div onclick="location.href='<?= base_url('/customer/productDetail/'.$r['id']) ?>'" 
                 style="background: white; border-radius: 16px; overflow: hidden; border: 1px solid #eef2f7; cursor: pointer;">
                <img src="<?= $r['image_url'] ?? base_url('assets/images/default-product.png') ?>" 
                     style="width: 100%; height: 150px; object-fit: cover;">
                <div style="padding: 16px;">
                    <h4 style="font-weight: 600; margin-bottom: 4px;"><?= $r['name'] ?></h4>
                    <p style="color: #ff6b35; font-weight: 700;">₱<?= number_format($r['price'], 2) ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>
    
</div>

<script>
let currentQty = 1;
let maxStock = <?= $product['stock'] ?? 0 ?>;

function incrementQty() {
    if (currentQty < maxStock) {
        currentQty++;
        document.getElementById('qtyDisplay').innerText = currentQty;
    } else {
        showToast('Only ' + maxStock + ' available!', 'error');
    }
}

function decrementQty() {
    if (currentQty > 1) {
        currentQty--;
        document.getElementById('qtyDisplay').innerText = currentQty;
    }
}

function addToCartFromDetail() {
    const product = {
        id: '<?= $product['id'] ?>',
        name: '<?= addslashes($product['name']) ?>',
        price: <?= $product['price'] ?>,
        stock: <?= $product['stock'] ?>,
        quantity: currentQty
    };
    
    // Get existing cart from localStorage
    let cart = localStorage.getItem('bensan_cart');
    cart = cart ? JSON.parse(cart) : [];
    
    // Check if product already in cart
    const existingIndex = cart.findIndex(item => item.id == product.id);
    
    if (existingIndex !== -1) {
        const newQty = cart[existingIndex].quantity + product.quantity;
        if (newQty <= product.stock) {
            cart[existingIndex].quantity = newQty;
        } else {
            showToast('Not enough stock!', 'error');
            return;
        }
    } else {
        cart.push(product);
    }
    
    // Save back to localStorage
    localStorage.setItem('bensan_cart', JSON.stringify(cart));
    
    showToast(`${product.name} added to cart!`, 'success');
    
    // Update cart count in navbar if function exists
    if (typeof updateCartCount === 'function') {
        updateCartCount();
    }
}

function showToast(message, type) {
    const toast = document.getElementById('toastMsg');
    if (toast) {
        toast.textContent = message;
        toast.style.background = type === 'success' ? '#28a745' : '#dc3545';
        toast.style.display = 'block';
        setTimeout(() => {
            toast.style.display = 'none';
        }, 2000);
    } else {
        alert(message);
    }
}
</script>