<div style="max-width: 800px; margin: 0 auto; padding: 40px 24px;">
    
    <div style="background: white; border-radius: 24px; border: 1px solid #eef2f7; overflow: hidden;">
        
        <!-- Header -->
        <div style="padding: 24px; background: #1a1a2e; color: white;">
            <h2 style="font-size: 1.3rem; margin-bottom: 4px;">Order <?= $order['order_number'] ?></h2>
            <p style="font-size: 0.8rem; opacity: 0.8;">Placed on <?= date('F d, Y h:i A', strtotime($order['order_date'])) ?></p>
        </div>
        
        <!-- Rider Information Card -->
        <?php if(isset($order['rider_name']) && $order['rider_name'] && $order['delivery_status'] == 'assigned'): ?>
        <div style="background: linear-gradient(135deg, #e8f5e9, #c8e6c9); padding: 20px 24px; border-bottom: 1px solid #eef2f7;">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 15px;">
                <i class="fas fa-motorcycle" style="font-size: 28px; color: #ff6b35;"></i>
                <h3 style="margin: 0; font-size: 1.1rem;">Delivery Rider Assigned</h3>
            </div>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;">
                <div>
                    <div style="font-size: 0.7rem; color: #6c757d;">Rider Name</div>
                    <div style="font-weight: 600; font-size: 1rem;"><?= $order['rider_name'] ?></div>
                </div>
                <div>
                    <div style="font-size: 0.7rem; color: #6c757d;">Contact Number</div>
                    <div><i class="fas fa-phone"></i> <?= $order['rider_phone'] ?? 'N/A' ?></div>
                </div>
                <?php if(isset($order['rider_vehicle'])): ?>
                <div>
                    <div style="font-size: 0.7rem; color: #6c757d;">Vehicle</div>
                    <div><i class="fas fa-motorcycle"></i> <?= $order['rider_vehicle'] ?> (<?= $order['rider_plate'] ?? 'N/A' ?>)</div>
                </div>
                <?php endif; ?>
                <?php if(isset($order['estimated_delivery_time'])): ?>
                <div>
                    <div style="font-size: 0.7rem; color: #6c757d;">Estimated Delivery</div>
                    <div><i class="fas fa-clock"></i> <?= date('h:i A', strtotime($order['estimated_delivery_time'])) ?></div>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>
        
        <!-- Order Items -->
        <div style="padding: 24px; border-bottom: 1px solid #eef2f7;">
            <h3 style="font-size: 1rem; font-weight: 600; margin-bottom: 16px;">Order Items</h3>
            <?php foreach($order['items'] as $item): ?>
            <div style="display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #eef2f7;">
                <div><?= $item['product_name'] ?> x <?= $item['quantity'] ?></div>
                <div>₱<?= number_format($item['price'] * $item['quantity'], 2) ?></div>
            </div>
            <?php endforeach; ?>
            <div style="display: flex; justify-content: space-between; font-weight: bold; margin-top: 15px; padding-top: 15px; border-top: 2px solid #eef2f7;">
                <span>Total</span>
                <span style="color: #ff6b35;">₱<?= number_format($order['total'], 2) ?></span>
            </div>
        </div>
        
        <!-- Delivery Information -->
        <div style="padding: 24px; background: #fafbfc;">
            <h3 style="font-size: 1rem; font-weight: 600; margin-bottom: 16px;">Delivery Information</h3>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;">
                <div>
                    <div style="font-size: 0.7rem; color: #6c757d;">Customer Name</div>
                    <div><?= $order['customer_name'] ?></div>
                </div>
                <div>
                    <div style="font-size: 0.7rem; color: #6c757d;">Email</div>
                    <div><?= $order['customer_email'] ?></div>
                </div>
                <div>
                    <div style="font-size: 0.7rem; color: #6c757d;">Phone</div>
                    <div><?= $order['customer_phone'] ?></div>
                </div>
                <div>
                    <div style="font-size: 0.7rem; color: #6c757d;">Delivery Address</div>
                    <div><?= $order['delivery_address'] ?></div>
                </div>
                <div>
                    <div style="font-size: 0.7rem; color: #6c757d;">Payment Method</div>
                    <div><?= strtoupper($order['payment_method'] ?? 'COD') ?></div>
                </div>
                <div>
                    <div style="font-size: 0.7rem; color: #6c757d;">Payment Status</div>
                    <div><?= ucfirst($order['payment_status'] ?? 'Pending') ?></div>
                </div>
            </div>
        </div>
        
        <div style="padding: 20px 24px; display: flex; gap: 16px;">
            <a href="<?= base_url('/customer/track-order') ?>" style="padding: 10px 20px; background: #e9ecef; color: #4a5568; text-decoration: none; border-radius: 30px;">← Back to Orders</a>
            <a href="<?= base_url('/customer/store') ?>" style="padding: 10px 20px; background: #ff6b35; color: white; text-decoration: none; border-radius: 30px;">Continue Shopping</a>
        </div>
    </div>
</div>