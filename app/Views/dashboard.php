<!-- Stats Grid -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-title">Total Products</div>
        <div class="stat-value"><?= $total_products ?? 0 ?></div>
    </div>
    <div class="stat-card">
        <div class="stat-title">Total Stock</div>
        <div class="stat-value"><?= $total_stock ?? 0 ?></div>
    </div>
    <div class="stat-card">
        <div class="stat-title">Total Orders</div>
        <div class="stat-value"><?= $total_orders ?? 0 ?></div>
    </div>
    <div class="stat-card">
        <div class="stat-title">Low Stock</div>
        <div class="stat-value"><?= $low_stock_count ?? 0 ?></div>
    </div>
</div>

<?php if(($low_stock_count ?? 0) > 0): ?>
<div class="alert alert-warning">
    <i class="fas fa-exclamation-triangle"></i> 
    <strong>Low Stock Alert:</strong> <?= $low_stock_count ?> product(s) need reordering.
</div>
<?php endif; ?>

<!-- Recent Orders -->
<div class="card">
    <div class="card-header">
        <h4>Recent Transactions</h4>
        <a href="<?= base_url('/orders') ?>" class="btn btn-primary btn-sm">View All</a>
    </div>
    <div class="card-body">
        <?php if(isset($recent_orders) && !empty($recent_orders)): ?>
            <table class="table">
                <thead>
                    <tr><th>Order #</th><th>Customer</th><th>Total</th><th>Date</th><th>Status</th></tr>
                </thead>
                <tbody>
                    <?php foreach(array_slice($recent_orders, 0, 5) as $order): ?>
                    <tr>
                        <td><?= $order['order_number'] ?></td>
                        <td><?= $order['customer_name'] ?></td>
                        <td class="text-success">₱<?= number_format($order['total'], 2) ?></td>
                        <td><?= date('M d, Y', strtotime($order['order_date'])) ?></td>
                        <td><span class="badge badge-success">Completed</span></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="text-muted" style="text-align: center; padding: 40px;">No transactions yet.</p>
        <?php endif; ?>
    </div>
</div>

<!-- Quick Actions -->
<div class="stats-grid">
    <a href="<?= base_url('/pos') ?>" class="stat-card" style="text-decoration: none;">
        <div class="stat-title"><i class="fas fa-cash-register"></i> Point of Sale</div>
        <div class="stat-value" style="font-size: 18px;">Process new sale</div>
    </a>
    <a href="<?= base_url('/product/create') ?>" class="stat-card" style="text-decoration: none;">
        <div class="stat-title"><i class="fas fa-plus"></i> Add Product</div>
        <div class="stat-value" style="font-size: 18px;">Add new product</div>
    </a>
    <a href="<?= base_url('/order-confirmation/pending') ?>" class="stat-card" style="text-decoration: none;">
        <div class="stat-title"><i class="fas fa-clock"></i> Pending Orders</div>
        <div class="stat-value" style="font-size: 18px;">Confirm online orders</div>
    </a>
    <a href="<?= base_url('/customer') ?>" class="stat-card" style="text-decoration: none;">
        <div class="stat-title"><i class="fas fa-store"></i> Customer Store</div>
        <div class="stat-value" style="font-size: 18px;">View customer page</div>
    </a>
</div>