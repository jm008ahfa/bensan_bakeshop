<div class="card">
    <div class="card-header">
        <h4><i class="fas fa-plus-circle"></i> Create New Order</h4>
    </div>
    <div class="card-body">
        <form action="<?= base_url('/order/store') ?>" method="post">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Customer Name</label>
                        <input type="text" name="customer_name" class="form-control" required placeholder="Enter customer name">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Order Type</label>
                        <select name="order_type" class="form-control" required>
                            <option value="walk_in">🏪 Walk-in Customer</option>
                            <option value="online">📱 Online Order</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-5">
                    <div class="mb-3">
                        <label class="form-label">Select Product</label>
                        <select name="product_id" class="form-control" id="productSelect" required>
                            <option value="">-- Select Product --</option>
                            <?php foreach($products as $p): ?>
                            <option value="<?= $p['id'] ?>" data-price="<?= $p['price'] ?>" data-stock="<?= $p['stock'] ?>">
                                <?= $p['name'] ?> - ₱<?= number_format($p['price'], 2) ?> (Stock: <?= $p['stock'] ?>)
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label">Quantity</label>
                        <input type="number" name="quantity" id="quantity" class="form-control" min="1" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Total Amount</label>
                        <input type="text" id="total" class="form-control" readonly style="background:#e9ecef; font-weight:bold;">
                    </div>
                </div>
            </div>
            
            <div id="stockWarning" class="alert alert-warning" style="display:none;"></div>
            
            <button type="submit" class="btn btn-primary btn-lg">
                <i class="fas fa-check"></i> Place Order
            </button>
            <a href="<?= base_url('/orders') ?>" class="btn btn-secondary btn-lg">
                <i class="fas fa-times"></i> Cancel
            </a>
        </form>
    </div>
</div>

<script>
const productSelect = document.getElementById('productSelect');
const quantityInput = document.getElementById('quantity');
const totalDisplay = document.getElementById('total');
const stockWarning = document.getElementById('stockWarning');

function calculateTotal() {
    const selectedOption = productSelect.options[productSelect.selectedIndex];
    const price = selectedOption.getAttribute('data-price') || 0;
    const stock = selectedOption.getAttribute('data-stock') || 0;
    const qty = quantityInput.value || 0;
    const total = price * qty;
    totalDisplay.value = '₱' + total.toFixed(2);
    
    if (qty > stock && stock > 0) {
        stockWarning.style.display = 'block';
        stockWarning.innerHTML = '⚠️ Warning: Only ' + stock + ' items available in stock!';
    } else {
        stockWarning.style.display = 'none';
    }
}

productSelect.addEventListener('change', calculateTotal);
quantityInput.addEventListener('input', calculateTotal);
</script>