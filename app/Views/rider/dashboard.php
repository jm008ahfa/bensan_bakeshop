<style>
    .order-card {
        background: white;
        border-radius: 16px;
        border: 1px solid #eef2f7;
        margin-bottom: 16px;
        padding: 0;
        transition: all 0.2s;
        overflow: hidden;
    }
    .order-card:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }
    .order-header {
        background: #f8f9fa;
        padding: 16px 20px;
        border-bottom: 1px solid #eef2f7;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
    }
    .order-number {
        font-weight: 700;
        font-size: 1rem;
        color: #1a1a2e;
    }
    .order-body {
        padding: 20px;
    }
    .customer-info {
        background: #f0f9ff;
        border-radius: 12px;
        padding: 15px;
        margin-bottom: 15px;
        border-left: 4px solid #ff6b35;
    }
    .customer-info h4 {
        font-size: 0.85rem;
        color: #6c757d;
        margin-bottom: 10px;
    }
    .customer-info p {
        margin-bottom: 6px;
        font-size: 0.9rem;
    }
    .customer-info i {
        width: 25px;
        color: #ff6b35;
    }
    .order-items {
        margin-top: 15px;
    }
    .order-items h4 {
        font-size: 0.85rem;
        margin-bottom: 10px;
        color: #6c757d;
    }
    .item-row {
        display: flex;
        justify-content: space-between;
        padding: 8px 0;
        border-bottom: 1px dashed #eef2f7;
        font-size: 0.85rem;
    }
    .order-total {
        margin-top: 15px;
        padding-top: 12px;
        border-top: 2px solid #eef2f7;
        display: flex;
        justify-content: space-between;
        font-weight: 700;
        font-size: 1rem;
    }
    .badge-ready { background: #fff3e0; color: #e65100; padding: 4px 12px; border-radius: 20px; font-size: 0.7rem; }
    .badge-assigned { background: #e3f2fd; color: #1565c0; padding: 4px 12px; border-radius: 20px; font-size: 0.7rem; }
    .badge-delivered { background: #e8f5e9; color: #2e7d32; padding: 4px 12px; border-radius: 20px; font-size: 0.7rem; }
    .btn-accept { background: #28a745; color: white; padding: 10px 20px; border: none; border-radius: 8px; cursor: pointer; width: 100%; font-weight: 600; }
    .btn-deliver { background: #ff6b35; color: white; padding: 10px 20px; border: none; border-radius: 8px; cursor: pointer; width: 100%; font-weight: 600; }
    .btn-view { background: #6c757d; color: white; padding: 8px 16px; border: none; border-radius: 8px; cursor: pointer; text-decoration: none; display: inline-block; font-size: 0.8rem; }
    .stats { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 30px; }
    .stat-card { background: white; border-radius: 16px; padding: 20px; text-align: center; border: 1px solid #eef2f7; }
    .stat-number { font-size: 2rem; font-weight: 700; color: #ff6b35; }
    .stat-label { color: #6c757d; font-size: 0.85rem; }
    .empty-state { text-align: center; padding: 40px; }
    .empty-state i { font-size: 48px; color: #dee2e6; margin-bottom: 16px; }
    @media (max-width: 768px) { .stats { grid-template-columns: 1fr; } }
</style>

<div class="stats">
    <div class="stat-card">
        <div class="stat-number"><?= count($readyOrders) ?></div>
        <div class="stat-label">Ready for Pickup</div>
    </div>
    <div class="stat-card">
        <div class="stat-number"><?= count($myDeliveries) ?></div>
        <div class="stat-label">My Deliveries</div>
    </div>
    <div class="stat-card">
        <div class="stat-number"><?= count($completedDeliveries) ?></div>
        <div class="stat-label">Completed</div>
    </div>
</div>

<!-- Ready Orders Section -->
<div class="card">
    <div class="card-header"><i class="fas fa-clock"></i> Ready for Pickup</div>
    <div class="card-body">
        <?php if(!empty($readyOrders)): ?>
            <?php foreach($readyOrders as $order): ?>
            <div class="order-card">
                <div class="order-header">
                    <span class="order-number"><i class="fas fa-receipt"></i> <?= $order['order_number'] ?></span>
                    <span class="badge-ready">Ready for Pickup</span>
                </div>
                <div class="order-body">
                    <!-- Customer Information - Name, Phone, Address Only -->
                    <div class="customer-info">
                        <h4><i class="fas fa-user-circle"></i> CUSTOMER INFORMATION</h4>
                        <p><i class="fas fa-user"></i> <strong><?= $order['customer_name'] ?></strong></p>
                        <p><i class="fas fa-phone"></i> <?= $order['customer_phone'] ?? 'No phone number' ?></p>
                        <p><i class="fas fa-map-marker-alt"></i> <strong>Delivery Address:</strong> <?= $order['delivery_address'] ?? 'No address provided' ?></p>
                    </div>
                    
                    <!-- Order Items -->
                    <div class="order-items">
                        <h4><i class="fas fa-box"></i> ORDER ITEMS</h4>
                        <?php foreach($order['items'] as $item): ?>
                        <div class="item-row">
                            <span><?= $item['product_name'] ?> x <?= $item['quantity'] ?></span>
                            <span>₱<?= number_format($item['price'] * $item['quantity'], 2) ?></span>
                        </div>
                        <?php endforeach; ?>
                        <div class="order-total">
                            <span>Total</span>
                            <span>₱<?= number_format($order['total'], 2) ?></span>
                        </div>
                    </div>
                    
                    <div style="margin-top: 15px;">
                        <a href="<?= base_url('/rider/acceptOrder/'.$order['id']) ?>" class="btn-accept" onclick="return confirm('Accept this delivery?')">
                            <i class="fas fa-check"></i> Accept Delivery
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="empty-state">
                <i class="fas fa-motorcycle"></i>
                <p>No orders ready for pickup</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- My Deliveries Section -->
<div class="card">
    <div class="card-header"><i class="fas fa-truck"></i> My Deliveries (In Progress)</div>
    <div class="card-body">
        <?php if(!empty($myDeliveries)): ?>
            <?php foreach($myDeliveries as $order): ?>
            <div class="order-card">
                <div class="order-header">
                    <span class="order-number"><i class="fas fa-receipt"></i> <?= $order['order_number'] ?></span>
                    <span class="badge-assigned">Assigned to You</span>
                </div>
                <div class="order-body">
                    <!-- Customer Information - Name, Phone, Address Only -->
                    <div class="customer-info">
                        <h4><i class="fas fa-user-circle"></i> CUSTOMER INFORMATION</h4>
                        <p><i class="fas fa-user"></i> <strong><?= $order['customer_name'] ?></strong></p>
                        <p><i class="fas fa-phone"></i> <?= $order['customer_phone'] ?? 'No phone number' ?></p>
                        <p><i class="fas fa-map-marker-alt"></i> <strong>Delivery Address:</strong> <?= $order['delivery_address'] ?? 'No address provided' ?></p>
                    </div>
                    
                    <!-- Order Items -->
                    <div class="order-items">
                        <h4><i class="fas fa-box"></i> ORDER ITEMS</h4>
                        <?php foreach($order['items'] as $item): ?>
                        <div class="item-row">
                            <span><?= $item['product_name'] ?> x <?= $item['quantity'] ?></span>
                            <span>₱<?= number_format($item['price'] * $item['quantity'], 2) ?></span>
                        </div>
                        <?php endforeach; ?>
                        <div class="order-total">
                            <span>Total</span>
                            <span>₱<?= number_format($order['total'], 2) ?></span>
                        </div>
                    </div>
                    
                    <?php if($order['estimated_delivery_time']): ?>
                    <div style="background: #fff3e0; padding: 10px; border-radius: 8px; margin: 15px 0; font-size: 0.8rem;">
                        <i class="fas fa-hourglass-half"></i> Deliver by: <strong><?= date('h:i A', strtotime($order['estimated_delivery_time'])) ?></strong>
                    </div>
                    <?php endif; ?>
                    
                    <div>
                        <a href="<?= base_url('/rider/deliverOrder/'.$order['id']) ?>" class="btn-deliver">
    <i class="fas fa-check-circle"></i> Complete Delivery
</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="empty-state">
                <i class="fas fa-box-open"></i>
                <p>No active deliveries</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Completed Deliveries Section -->
<div class="card">
    <div class="card-header"><i class="fas fa-check-circle"></i> Completed Deliveries</div>
    <div class="card-body">
        <?php if(!empty($completedDeliveries)): ?>
            <?php foreach($completedDeliveries as $order): ?>
            <div class="order-card">
                <div class="order-header">
                    <span class="order-number"><i class="fas fa-receipt"></i> <?= $order['order_number'] ?></span>
                    <span class="badge-delivered">Delivered</span>
                </div>
                <div class="order-body">
                    <!-- Customer Information - Name and Address Only -->
                    <div class="customer-info" style="background: #e8f5e9; border-left-color: #28a745;">
                        <p><i class="fas fa-user"></i> <strong><?= $order['customer_name'] ?></strong></p>
                        <p><i class="fas fa-map-marker-alt"></i> <?= $order['delivery_address'] ?? 'No address' ?></p>
                    </div>
                    <div class="order-total">
                        <span>Total</span>
                        <span>₱<?= number_format($order['total'], 2) ?></span>
                    </div>
                    <div style="font-size: 0.7rem; color: #6c757d; margin-top: 10px;">
                        <i class="fas fa-calendar"></i> Delivered: <?= date('M d, h:i A', strtotime($order['delivered_at'])) ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="empty-state">
                <i class="fas fa-history"></i>
                <p>No completed deliveries yet</p>
            </div>
        <?php endif; ?>
    </div>
</div>