<style>
    .order-card {
        background: white;
        border-radius: 12px;
        border: 1px solid #eef2f7;
        margin-bottom: 16px;
        overflow: hidden;
        transition: all 0.2s;
    }
    .order-card:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }
    .order-header {
        padding: 14px 16px;
        background: #f8f9fa;
        border-bottom: 1px solid #eef2f7;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
    }
    .order-number {
        font-weight: 700;
        font-size: 0.9rem;
    }
    .badge-ready { background: #fff3e0; color: #e65100; padding: 4px 12px; border-radius: 20px; font-size: 0.7rem; font-weight: 600; }
    .badge-assigned { background: #e3f2fd; color: #1565c0; padding: 4px 12px; border-radius: 20px; font-size: 0.7rem; font-weight: 600; }
    .badge-delivered { background: #e8f5e9; color: #2e7d32; padding: 4px 12px; border-radius: 20px; font-size: 0.7rem; font-weight: 600; }
    .order-body {
        padding: 16px;
    }
    .customer-info {
        background: #f0f9ff;
        border-radius: 10px;
        padding: 12px;
        margin-bottom: 12px;
        border-left: 3px solid #ff6b35;
    }
    .customer-info p {
        font-size: 0.8rem;
        margin-bottom: 5px;
    }
    .customer-info i {
        width: 22px;
        color: #ff6b35;
    }
    .order-items {
        margin-top: 10px;
    }
    .item-row {
        display: flex;
        justify-content: space-between;
        padding: 6px 0;
        border-bottom: 1px dashed #eef2f7;
        font-size: 0.8rem;
    }
    .order-total {
        margin-top: 12px;
        padding-top: 10px;
        border-top: 2px solid #eef2f7;
        display: flex;
        justify-content: space-between;
        font-weight: 700;
    }
    .btn-accept {
        width: 100%;
        padding: 10px;
        background: #28a745;
        color: white;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        margin-top: 12px;
    }
    .btn-deliver {
        width: 100%;
        padding: 10px;
        background: #ff6b35;
        color: white;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        margin-top: 12px;
    }
    .btn-view {
        width: 100%;
        padding: 8px;
        background: #6c757d;
        color: white;
        border: none;
        border-radius: 8px;
        font-weight: 500;
        cursor: pointer;
        margin-top: 12px;
        text-decoration: none;
        display: block;
        text-align: center;
        font-size: 0.8rem;
    }
    .empty-state {
        text-align: center;
        padding: 40px;
        color: #adb5bd;
    }
    .empty-state i {
        font-size: 48px;
        margin-bottom: 16px;
        opacity: 0.5;
    }
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        margin-bottom: 30px;
    }
    .stat-card {
        background: white;
        border-radius: 16px;
        padding: 20px;
        text-align: center;
        border: 1px solid #eef2f7;
    }
    .stat-number {
        font-size: 28px;
        font-weight: 700;
        color: #ff6b35;
    }
    .stat-label {
        font-size: 0.8rem;
        color: #6c757d;
        margin-top: 5px;
    }
    .section-title {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 16px;
        padding-bottom: 8px;
        border-bottom: 2px solid #ff6b35;
        display: inline-block;
    }
</style>

<!-- Stats Cards -->
<div class="stats-grid">
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

<!-- ============================================ -->
<!-- SECTION 1: READY FOR PICKUP -->
<!-- ============================================ -->
<div id="ready">
    <h3 class="section-title"><i class="fas fa-clock"></i> Ready for Pickup</h3>
    
    <?php if(!empty($readyOrders)): ?>
        <?php foreach($readyOrders as $order): ?>
        <div class="order-card">
            <div class="order-header">
                <span class="order-number"><i class="fas fa-receipt"></i> <?= $order['order_number'] ?></span>
                <span class="badge-ready">Ready for Pickup</span>
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
                <a href="<?= base_url('/rider/acceptOrder/'.$order['id']) ?>" class="btn-accept" onclick="return confirm('Accept this delivery?')">
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
</div>

<!-- ============================================ -->
<!-- SECTION 2: MY DELIVERIES (IN PROGRESS) -->
<!-- ============================================ -->
<div id="assigned" style="margin-top: 40px;">
    <h3 class="section-title"><i class="fas fa-truck"></i> My Deliveries (In Progress)</h3>
    
    <?php if(!empty($myDeliveries)): ?>
        <?php foreach($myDeliveries as $order): ?>
        <div class="order-card">
            <div class="order-header">
                <span class="order-number"><i class="fas fa-receipt"></i> <?= $order['order_number'] ?></span>
                <span class="badge-assigned">Assigned to You</span>
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
                <a href="<?= base_url('/rider/deliverOrder/'.$order['id']) ?>" class="btn-deliver" onclick="return confirm('Complete this delivery?')">
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
</div>

<!-- ============================================ -->
<!-- SECTION 3: COMPLETED DELIVERIES -->
<!-- ============================================ -->
<div id="completed" style="margin-top: 40px;">
    <h3 class="section-title"><i class="fas fa-check-circle"></i> Completed Deliveries</h3>
    
    <?php if(!empty($completedDeliveries)): ?>
        <?php foreach($completedDeliveries as $order): ?>
        <div class="order-card">
            <div class="order-header">
                <span class="order-number"><i class="fas fa-receipt"></i> <?= $order['order_number'] ?></span>
                <span class="badge-delivered">Delivered</span>
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
                <a href="<?= base_url('/rider/order/'.$order['id']) ?>" class="btn-view">
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
</div>