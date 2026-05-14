<h3 class="mb-4"><i class="fas fa-truck"></i> My Deliveries (In Progress)</h3>

<?php if(!empty($orders)): ?>
    <?php foreach($orders as $order): ?>
    <div class="order-card">
        <div class="order-header">
            <span class="order-number"><i class="fas fa-receipt"></i> <?= $order['order_number'] ?></span>
            <span class="badge badge-assigned">Assigned to You</span>
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
            <?php if(isset($order['estimated_delivery_time']) && $order['estimated_delivery_time']): ?>
            <div style="background: #fff3e0; padding: 8px; border-radius: 8px; margin: 10px 0; font-size: 0.75rem;">
                <i class="fas fa-hourglass-half"></i> Deliver by: <strong><?= date('h:i A', strtotime($order['estimated_delivery_time'])) ?></strong>
            </div>
            <?php endif; ?>
            <a href="<?= base_url('/rider/deliverOrder/'.$order['id']) ?>" class="btn btn-deliver" onclick="return confirm('Complete this delivery?')">
                <i class="fas fa-check-circle"></i> Complete Delivery
            </a>
        </div>
    </div>
    <?php endforeach; ?>
<?php else: ?>
    <div class="empty-state">
        <i class="fas fa-box-open"></i>
        <p>No active deliveries</p>
        <small>Accept orders from "Ready for Pickup" section</small>
    </div>
<?php endif; ?>