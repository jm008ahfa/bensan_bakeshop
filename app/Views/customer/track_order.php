<div style="max-width: 1200px; margin: 0 auto; padding: 40px 24px;">
    <h1 style="font-size: 1.8rem; font-weight: 600; margin-bottom: 8px;">Track My Orders</h1>
    <p style="color: #6c757d; margin-bottom: 40px;">View and track your active and completed orders</p>
    
    <!-- Active Orders Tab -->
    <div style="margin-bottom: 40px;">
        <h2 style="font-size: 1.3rem; font-weight: 600; margin-bottom: 20px;">
            <i class="fas fa-truck" style="color: #ff6b35;"></i> Active Orders
        </h2>
        <?php 
        $activeOrders = array_filter($orders, function($o) {
            return !in_array($o['status'] ?? '', ['completed', 'cancelled', 'delivered']);
        });
        ?>
        <?php if(!empty($activeOrders)): ?>
            <?php foreach($activeOrders as $order): ?>
            <div style="background: white; border-radius: 20px; border: 1px solid #eef2f7; padding: 20px; margin-bottom: 16px;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 15px;">
                    <div><strong><?= $order['order_number'] ?></strong></div>
                    <div>₱<?= number_format($order['total'], 2) ?></div>
                </div>
                <div style="margin-bottom: 15px;">
                    <div style="font-size: 0.8rem; color: #6c757d;">Status: 
                        <span style="background: #fff3e0; color: #e65100; padding: 4px 12px; border-radius: 20px;">
                            <?= ucfirst($order['status'] ?? 'Pending') ?>
                        </span>
                    </div>
                    <div style="font-size: 0.8rem; color: #6c757d; margin-top: 5px;">
                        Delivery: 
                        <span style="background: #e3f2fd; color: #1565c0; padding: 4px 12px; border-radius: 20px;">
                            <?= ucfirst($order['delivery_status'] ?? 'Pending') ?>
                        </span>
                    </div>
                    <?php if($order['rider_name']): ?>
                    <div style="font-size: 0.8rem; color: #6c757d; margin-top: 5px;">
                        <i class="fas fa-motorcycle"></i> Rider: <?= $order['rider_name'] ?>
                    </div>
                    <?php endif; ?>
                </div>
                
                <!-- Order Timeline -->
                <div style="margin-top: 15px;">
                    <div style="display: flex; justify-content: space-between;">
                        <div style="text-align: center; flex: 1;">
                            <div style="width: 30px; height: 30px; background: <?= $order['status'] != 'pending' ? '#28a745' : '#e9ecef' ?>; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center;">
                                <i class="fas fa-clipboard-list" style="color: white; font-size: 12px;"></i>
                            </div>
                            <div style="font-size: 0.7rem;">Order Placed</div>
                        </div>
                        <div style="text-align: center; flex: 1;">
                            <div style="width: 30px; height: 30px; background: <?= in_array($order['status'], ['preparing', 'ready']) ? '#ff6b35' : '#e9ecef' ?>; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center;">
                                <i class="fas fa-cog" style="color: white; font-size: 12px;"></i>
                            </div>
                            <div style="font-size: 0.7rem;">Preparing</div>
                        </div>
                        <div style="text-align: center; flex: 1;">
                            <div style="width: 30px; height: 30px; background: <?= $order['delivery_status'] == 'assigned' ? '#ff6b35' : '#e9ecef' ?>; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center;">
                                <i class="fas fa-truck" style="color: white; font-size: 12px;"></i>
                            </div>
                            <div style="font-size: 0.7rem;">On the Way</div>
                        </div>
                        <div style="text-align: center; flex: 1;">
                            <div style="width: 30px; height: 30px; background: <?= $order['delivery_status'] == 'delivered' ? '#28a745' : '#e9ecef' ?>; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center;">
                                <i class="fas fa-check-circle" style="color: white; font-size: 12px;"></i>
                            </div>
                            <div style="font-size: 0.7rem;">Delivered</div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div style="background: white; border-radius: 20px; border: 1px solid #eef2f7; padding: 40px; text-align: center;">
                <i class="fas fa-shopping-bag" style="font-size: 48px; color: #dee2e6; margin-bottom: 16px;"></i>
                <p>No active orders</p>
            </div>
        <?php endif; ?>
    </div>
    
    <!-- Completed Orders Tab (Separate) -->
    <div>
        <h2 style="font-size: 1.3rem; font-weight: 600; margin-bottom: 20px;">
            <i class="fas fa-history" style="color: #28a745;"></i> Completed Orders
        </h2>
        <?php 
        $completedOrders = array_filter($orders, function($o) {
            return in_array($o['status'] ?? '', ['completed', 'delivered']);
        });
        ?>
        <?php if(!empty($completedOrders)): ?>
            <?php foreach($completedOrders as $order): ?>
            <div style="background: white; border-radius: 20px; border: 1px solid #eef2f7; padding: 20px; margin-bottom: 16px;">
                <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
                    <div>
                        <div><strong><?= $order['order_number'] ?></strong></div>
                        <div style="font-size: 0.7rem; color: #6c757d;"><?= date('F d, Y', strtotime($order['order_date'])) ?></div>
                    </div>
                    <div>₱<?= number_format($order['total'], 2) ?></div>
                    <div>
                        <span style="background: #e8f5e9; color: #2e7d32; padding: 4px 12px; border-radius: 20px; font-size: 0.7rem;">
                            <i class="fas fa-check-circle"></i> Completed
                        </span>
                    </div>
                    <a href="<?= base_url('/customer/order/'.$order['order_number']) ?>" style="color: #ff6b35; text-decoration: none; font-size: 0.8rem;">View Details →</a>
                </div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div style="background: white; border-radius: 20px; border: 1px solid #eef2f7; padding: 40px; text-align: center;">
                <i class="fas fa-inbox" style="font-size: 48px; color: #dee2e6; margin-bottom: 16px;"></i>
                <p>No completed orders yet</p>
            </div>
        <?php endif; ?>
    </div>
</div>