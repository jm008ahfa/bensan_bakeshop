<h3 class="mb-4"><i class="fas fa-check-circle"></i> Completed Deliveries</h3>

<?php if(!empty($orders)): ?>
    <?php foreach($orders as $order): ?>
    <div class="order-card">
        <div class="order-header">
            <span class="order-number"><i class="fas fa-receipt"></i> <?= $order['order_number'] ?></span>
            <span class="badge badge-delivered">Delivered</span>
        </div>
        <div class="order-body">
            <div class="customer-info" style="background: #e8f5e9; border-left-color: #28a745;">
                <p><i class="fas fa-user"></i> <strong><?= $order['customer_name'] ?></strong></p>
                <p><i class="fas fa-map-marker-alt"></i> <?= $order['delivery_address'] ?? 'No address' ?></p>
            </div>
            <div class="order-total">
                <span>Total</span>
                <span>₱<?= number_format($order['total'], 2) ?></span>
            </div>
            <?php if(isset($order['delivered_at']) && $order['delivered_at']): ?>
            <div style="font-size: 0.7rem; color: #6c757d; margin-top: 10px;">
                <i class="fas fa-calendar"></i> Delivered: <?= date('M d, h:i A', strtotime($order['delivered_at'])) ?>
            </div>
            <?php endif; ?>
            <a href="<?= base_url('/rider/order/'.$order['id']) ?>" class="btn btn-view">
                <i class="fas fa-eye"></i> View Details
            </a>
        </div>
    </div>
    <?php endforeach; ?>
<?php else: ?>
    <div class="empty-state">
        <i class="fas fa-history"></i>
        <p>No completed deliveries yet</p>
    </div>
<?php endif; ?>