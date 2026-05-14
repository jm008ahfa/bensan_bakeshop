<h3 class="mb-4"><i class="fas fa-clock"></i> Ready for Pickup</h3>

<?php if(!empty($orders)): ?>
    <?php foreach($orders as $order): ?>
    <div class="order-card">
        <div class="order-header">
            <span class="order-number"><i class="fas fa-receipt"></i> <?= $order['order_number'] ?></span>
            <span class="badge badge-ready">Ready for Pickup</span>
        </div>
        <div class="order-body">
            <div class="customer-info">
                <p><i class="fas fa-user"></i> <strong><?= $order['customer_name'] ?></strong></p>
                <p><i class="fas fa-phone"></i> <?= $order['customer_phone'] ?? 'No phone' ?></p>
                <p><i class="fas fa-map-marker-alt"></i> <?= $order['delivery_address'] ?? 'No address' ?></p>
            </div>
            <div class="order-items">
                <div class="item-row"><span><strong>Items:</strong></span><span></span></div>
                <?php foreach($order['items'] as $item): ?>
                <div class="item-row">
                    <span><?= $item['product_name'] ?> x <?= $item['quantity'] ?></span>
                    <span>₱<?= number_format($item['price'] * $item['quantity'], 2) ?></span>
                </div>
                <?php endforeach; ?>
            </div>
            <div class="order-total">
                <span>Total</span>
                <span>₱<?= number_format($order['total'], 2) ?></span>
            </div>
            <a href="<?= base_url('/rider/acceptOrder/'.$order['id']) ?>" class="btn btn-accept" onclick="return confirm('Accept this delivery?')">
                <i class="fas fa-check"></i> Accept Delivery
            </a>
        </div>
    </div>
    <?php endforeach; ?>
<?php else: ?>
    <div class="empty-state">
        <i class="fas fa-motorcycle"></i>
        <p>No orders ready for pickup</p>
        <small>Orders will appear here when admin marks them as ready</small>
    </div>
<?php endif; ?>