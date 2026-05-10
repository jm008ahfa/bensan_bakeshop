<div style="max-width: 800px; margin: 0 auto; padding: 40px 24px;">
    
    <div style="background: white; border-radius: 24px; border: 1px solid #eef2f7; overflow: hidden;">
        
        <!-- Header -->
        <div style="padding: 24px; background: #1a1a2e; color: white;">
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
                <div>
                    <h2 style="font-size: 1.3rem; margin-bottom: 4px;">Order <?= $order['order_number'] ?></h2>
                    <p style="font-size: 0.8rem; opacity: 0.8;">Placed on <?= date('F d, Y h:i A', strtotime($order['order_date'])) ?></p>
                </div>
                <?php
                $status = $order['status'] ?? 'pending';
                $statusConfig = [
                    'pending' => ['bg' => '#fff3e0', 'color' => '#e65100', 'text' => 'Pending'],
                    'preparing' => ['bg' => '#e3f2fd', 'color' => '#1565c0', 'text' => 'Preparing'],
                    'ready' => ['bg' => '#e8f5e9', 'color' => '#2e7d32', 'text' => 'Ready for Pickup'],
                    'completed' => ['bg' => '#e8f5e9', 'color' => '#2e7d32', 'text' => 'Completed']
                ];
                $config = $statusConfig[$status] ?? $statusConfig['pending'];
                ?>
                <span style="background: <?= $config['bg'] ?>; color: <?= $config['color'] ?>; padding: 6px 14px; border-radius: 30px; font-size: 0.75rem; font-weight: 600;">
                    <?= $config['text'] ?>
                </span>
            </div>
        </div>
        
        <!-- Status Timeline -->
        <div style="padding: 24px; border-bottom: 1px solid #eef2f7; background: #fafbfc;">
            <div style="display: flex; justify-content: space-between; margin-bottom: 16px;">
                <?php
                $steps = [
                    'pending' => ['label' => 'Order Placed', 'icon' => 'clipboard-list'],
                    'preparing' => ['label' => 'Preparing', 'icon' => 'cog'],
                    'ready' => ['label' => 'Ready', 'icon' => 'box'],
                    'completed' => ['label' => 'Delivered', 'icon' => 'flag-checkered']
                ];
                $currentStep = $status;
                $stepIndex = array_search($currentStep, array_keys($steps));
                ?>
                <?php foreach($steps as $key => $step): ?>
                <div style="text-align: center; flex: 1;">
                    <?php $isActive = array_search($key, array_keys($steps)) <= $stepIndex; ?>
                    <div style="width: 40px; height: 40px; background: <?= $isActive ? '#ff6b35' : '#e9ecef' ?>; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 8px;">
                        <i class="fas fa-<?= $step['icon'] ?>" style="color: <?= $isActive ? 'white' : '#adb5bd' ?>;"></i>
                    </div>
                    <div style="font-size: 0.75rem; font-weight: <?= $isActive ? '600' : '400' ?>; color: <?= $isActive ? '#1a1a2e' : '#adb5bd' ?>;">
                        <?= $step['label'] ?>
                    </div>
                    <div style="font-size: 0.7rem; color: <?= $isActive ? '#ff6b35' : '#adb5bd' ?>; margin-top: 4px;">
                        <?php if($isActive && $key == $currentStep): ?>Current<?php elseif($isActive): ?>Completed<?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        
        <!-- Order Items -->
        <div style="padding: 24px; border-bottom: 1px solid #eef2f7;">
            <h3 style="font-size: 1rem; font-weight: 600; margin-bottom: 16px;">Order Items</h3>
            <div style="display: flex; flex-direction: column; gap: 12px;">
                <?php foreach($order['items'] as $item): ?>
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 12px 0; border-bottom: 1px solid #eef2f7;">
                    <div>
                        <div style="font-weight: 500;"><?= $item['product_name'] ?></div>
                        <div style="font-size: 0.7rem; color: #6c757d;">₱<?= number_format($item['price'], 2) ?> x <?= $item['quantity'] ?></div>
                    </div>
                    <div style="font-weight: 600;">₱<?= number_format($item['price'] * $item['quantity'], 2) ?></div>
                </div>
                <?php endforeach; ?>
            </div>
            
            <div style="margin-top: 20px; padding-top: 16px; border-top: 2px solid #eef2f7;">
                <div style="display: flex; justify-content: space-between; font-size: 1.1rem; font-weight: 700;">
                    <span>Total</span>
                    <span style="color: #ff6b35;">₱<?= number_format($order['total'], 2) ?></span>
                </div>
            </div>
        </div>
        
        <!-- Delivery Information -->
        <div style="padding: 24px; background: #fafbfc;">
            <h3 style="font-size: 1rem; font-weight: 600; margin-bottom: 16px;">Delivery Information</h3>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px;">
                <div>
                    <div style="font-size: 0.7rem; color: #6c757d;">Customer Name</div>
                    <div style="font-size: 0.85rem; font-weight: 500;"><?= $order['customer_name'] ?></div>
                </div>
                <div>
                    <div style="font-size: 0.7rem; color: #6c757d;">Email</div>
                    <div style="font-size: 0.85rem;"><?= $order['customer_email'] ?></div>
                </div>
                <div>
                    <div style="font-size: 0.7rem; color: #6c757d;">Phone</div>
                    <div style="font-size: 0.85rem;"><?= $order['customer_phone'] ?></div>
                </div>
                <div>
                    <div style="font-size: 0.7rem; color: #6c757d;">Delivery Address</div>
                    <div style="font-size: 0.85rem;"><?= $order['delivery_address'] ?></div>
                </div>
                <div>
                    <div style="font-size: 0.7rem; color: #6c757d;">Payment Method</div>
                    <div style="font-size: 0.85rem;">Cash on Delivery</div>
                </div>
            </div>
        </div>
        
        <!-- Actions -->
        <div style="padding: 20px 24px; display: flex; gap: 16px; border-top: 1px solid #eef2f7;">
            <a href="<?= base_url('/customer/track-order') ?>" style="padding: 10px 20px; background: #e9ecef; color: #4a5568; text-decoration: none; border-radius: 30px; font-size: 0.85rem;">
                <i class="fas fa-arrow-left"></i> Back to Orders
            </a>
            <a href="<?= base_url('/customer/store') ?>" style="padding: 10px 20px; background: #ff6b35; color: white; text-decoration: none; border-radius: 30px; font-size: 0.85rem;">
                <i class="fas fa-shopping-cart"></i> Continue Shopping
            </a>
        </div>
        
    </div>
</div>