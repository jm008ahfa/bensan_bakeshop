<div style="max-width: 1200px; margin: 0 auto; padding: 40px 24px;">
    <h1 style="font-size: 1.8rem; font-weight: 600; margin-bottom: 8px;">Track My Orders</h1>
    <p style="color: #6c757d; margin-bottom: 40px;">View and track your order status</p>
    
    <?php if(!empty($orders)): ?>
        <div style="display: flex; flex-direction: column; gap: 20px;">
            <?php foreach($orders as $order): ?>
            <div style="background: white; border-radius: 20px; border: 1px solid #eef2f7; overflow: hidden;">
                <!-- Order Header -->
                <div style="padding: 20px 24px; background: #f8f9fa; border-bottom: 1px solid #eef2f7; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
                    <div>
                        <h3 style="font-weight: 600; margin-bottom: 4px;"><?= $order['order_number'] ?></h3>
                        <p style="font-size: 0.75rem; color: #6c757d;"><?= date('F d, Y h:i A', strtotime($order['order_date'])) ?></p>
                    </div>
                    <div>
                        <?php
                        $status = $order['delivery_status'] ?? $order['status'] ?? 'pending';
                        $statusConfig = [
                            'pending' => ['color' => '#e65100', 'bg' => '#fff3e0', 'icon' => 'clock', 'text' => 'Pending'],
                            'preparing' => ['color' => '#1565c0', 'bg' => '#e3f2fd', 'icon' => 'cog', 'text' => 'Preparing'],
                            'ready' => ['color' => '#2e7d32', 'bg' => '#e8f5e9', 'icon' => 'box', 'text' => 'Ready for Pickup'],
                            'assigned' => ['color' => '#1565c0', 'bg' => '#e3f2fd', 'icon' => 'motorcycle', 'text' => 'Rider Assigned'],
                            'delivered' => ['color' => '#2e7d32', 'bg' => '#e8f5e9', 'icon' => 'check-double', 'text' => 'Delivered'],
                            'completed' => ['color' => '#2e7d32', 'bg' => '#e8f5e9', 'icon' => 'check-circle', 'text' => 'Completed'],
                            'cancelled' => ['color' => '#c62828', 'bg' => '#ffebee', 'icon' => 'times-circle', 'text' => 'Cancelled']
                        ];
                        $config = $statusConfig[$status] ?? $statusConfig['pending'];
                        ?>
                        <span style="background: <?= $config['bg'] ?>; color: <?= $config['color'] ?>; padding: 6px 14px; border-radius: 30px; font-size: 0.75rem; font-weight: 600;">
                            <i class="fas fa-<?= $config['icon'] ?>"></i> <?= $config['text'] ?>
                        </span>
                    </div>
                </div>
                
                <!-- Order Body -->
                <div style="padding: 20px 24px;">
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 20px;">
                        <div>
                            <div style="font-size: 0.7rem; color: #6c757d;">Total Amount</div>
                            <div style="font-size: 1.2rem; font-weight: 700; color: #ff6b35;">₱<?= number_format($order['total'], 2) ?></div>
                        </div>
                        <div>
                            <div style="font-size: 0.7rem; color: #6c757d;">Payment Method</div>
                            <div style="font-size: 0.85rem;"><?= strtoupper($order['payment_method'] ?? 'COD') ?></div>
                        </div>
                        <div>
                            <div style="font-size: 0.7rem; color: #6c757d;">Delivery Address</div>
                            <div style="font-size: 0.85rem;"><?= $order['delivery_address'] ?? 'No address' ?></div>
                        </div>
                    </div>
                    
                    <!-- RIDER INFORMATION - SHOW WHEN ASSIGNED -->
                    <?php if(isset($order['rider_name']) && $order['rider_name'] && $order['delivery_status'] == 'assigned'): ?>
                    <div style="background: linear-gradient(135deg, #e8f5e9, #c8e6c9); border-radius: 16px; padding: 16px; margin-bottom: 20px; border-left: 4px solid #28a745;">
                        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 10px;">
                            <i class="fas fa-motorcycle" style="font-size: 24px; color: #ff6b35;"></i>
                            <h4 style="margin: 0; font-weight: 600;">Your Delivery Rider</h4>
                        </div>
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 12px;">
                            <div>
                                <span style="font-size: 0.7rem; color: #6c757d;">Rider Name</span>
                                <div style="font-weight: 600;"><?= $order['rider_name'] ?></div>
                            </div>
                            <div>
                                <span style="font-size: 0.7rem; color: #6c757d;">Contact Number</span>
                                <div><i class="fas fa-phone"></i> <?= $order['rider_phone'] ?? 'N/A' ?></div>
                            </div>
                            <?php if(isset($order['estimated_delivery_time'])): ?>
                            <div>
                                <span style="font-size: 0.7rem; color: #6c757d;">Estimated Delivery</span>
                                <div><i class="fas fa-clock"></i> <?= date('h:i A', strtotime($order['estimated_delivery_time'])) ?></div>
                            </div>
                            <?php endif; ?>
                        </div>
                        <div style="margin-top: 12px; font-size: 0.75rem; color: #2e7d32;">
                            <i class="fas fa-check-circle"></i> Your order is on the way!
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <!-- Order Timeline -->
                    <div style="margin-top: 20px;">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 12px;">
                            <?php
                            $steps = ['pending' => 'Order Placed', 'preparing' => 'Preparing', 'ready' => 'Ready', 'assigned' => 'Rider Assigned', 'delivered' => 'Delivered'];
                            $stepIndex = array_search($status, array_keys($steps));
                            if($stepIndex === false) $stepIndex = -1;
                            ?>
                            <?php foreach($steps as $key => $label): ?>
                            <?php $isActive = array_search($key, array_keys($steps)) <= $stepIndex; ?>
                            <div style="text-align: center; flex: 1;">
                                <div style="width: 36px; height: 36px; background: <?= $isActive ? '#ff6b35' : '#e9ecef' ?>; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 8px;">
                                    <i class="fas fa-<?= $key == 'pending' ? 'clipboard-list' : ($key == 'preparing' ? 'cog' : ($key == 'ready' ? 'box' : ($key == 'assigned' ? 'motorcycle' : 'flag-checkered'))) ?>" style="color: <?= $isActive ? 'white' : '#adb5bd' ?>; font-size: 14px;"></i>
                                </div>
                                <div style="font-size: 0.7rem; color: <?= $isActive ? '#1a1a2e' : '#adb5bd' ?>; font-weight: <?= $isActive ? '600' : '400' ?>;"><?= $label ?></div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <div style="height: 4px; background: #eef2f7; border-radius: 2px; margin: 0 20px;">
                            <div style="width: <?= ($stepIndex + 1) * 20 ?>%; height: 100%; background: #ff6b35; border-radius: 2px;"></div>
                        </div>
                    </div>
                    
                    <div style="margin-top: 20px;">
                        <a href="<?= base_url('/customer/order/'.$order['order_number']) ?>" style="display: inline-flex; align-items: center; gap: 8px; color: #ff6b35; text-decoration: none; font-size: 0.85rem; font-weight: 500;">
                            View Order Details <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div style="background: white; border-radius: 20px; border: 1px solid #eef2f7; text-align: center; padding: 60px 20px;">
            <i class="fas fa-shopping-bag" style="font-size: 48px; color: #dee2e6; margin-bottom: 16px;"></i>
            <p style="color: #6c757d; margin-bottom: 20px;">You haven't placed any orders yet.</p>
            <a href="<?= base_url('/customer/store') ?>" style="display: inline-block; padding: 12px 28px; background: #ff6b35; color: white; text-decoration: none; border-radius: 40px; font-weight: 600;">
                Start Shopping <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    <?php endif; ?>
</div>