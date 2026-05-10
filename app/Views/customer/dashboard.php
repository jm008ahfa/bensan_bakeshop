<div style="max-width: 1200px; margin: 0 auto; padding: 60px 24px;">
    <div style="background: white; border-radius: 24px; padding: 40px; border: 1px solid #eef2f7;">
        <div style="display: flex; align-items: center; gap: 20px; margin-bottom: 32px;">
            <div style="width: 80px; height: 80px; background: #ff6b35; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-user" style="font-size: 40px; color: white;"></i>
            </div>
            <div>
                <h1 style="font-size: 1.8rem; margin-bottom: 8px;">Welcome, <?= session()->get('customer_name') ?>!</h1>
                <p style="color: #6c757d;"><?= session()->get('customer_email') ?></p>
            </div>
        </div>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 40px;">
            <div style="background: #f8f9fa; border-radius: 16px; padding: 24px; text-align: center;">
                <i class="fas fa-shopping-bag" style="font-size: 32px; color: #ff6b35; margin-bottom: 12px;"></i>
                <h3 style="font-size: 28px;"><?= count($orders) ?></h3>
                <p>Total Orders</p>
            </div>
            <div style="background: #f8f9fa; border-radius: 16px; padding: 24px; text-align: center;">
                <i class="fas fa-clock" style="font-size: 32px; color: #ffc107; margin-bottom: 12px;"></i>
                <h3 style="font-size: 28px;"><?= count(array_filter($orders, fn($o) => ($o['status'] ?? 'pending') == 'pending')) ?></h3>
                <p>Pending</p>
            </div>
            <div style="background: #f8f9fa; border-radius: 16px; padding: 24px; text-align: center;">
                <i class="fas fa-check-circle" style="font-size: 32px; color: #28a745; margin-bottom: 12px;"></i>
                <h3 style="font-size: 28px;"><?= count(array_filter($orders, fn($o) => ($o['status'] ?? '') == 'completed')) ?></h3>
                <p>Completed</p>
            </div>
        </div>
        
        <h2 style="font-size: 1.3rem; margin-bottom: 20px;">Recent Orders</h2>
        
        <?php if(!empty($orders)): ?>
            <div style="border: 1px solid #eef2f7; border-radius: 16px; overflow: hidden;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead style="background: #f8f9fa;">
                        <tr>
                            <th style="padding: 14px; text-align: left;">Order #</th>
                            <th style="padding: 14px; text-align: left;">Date</th>
                            <th style="padding: 14px; text-align: left;">Total</th>
                            <th style="padding: 14px; text-align: left;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach(array_slice($orders, 0, 10) as $order): ?>
                        <tr style="border-top: 1px solid #eef2f7;">
                            <td style="padding: 14px;"><?= $order['order_number'] ?></td>
                            <td style="padding: 14px;"><?= date('M d, Y', strtotime($order['order_date'])) ?></td>
                            <td style="padding: 14px;">₱<?= number_format($order['total'], 2) ?></td>
                            <td style="padding: 14px;">
                                <span style="background: #fff3e0; color: #e65100; padding: 4px 12px; border-radius: 20px; font-size: 0.7rem;">
                                    <?= ucfirst($order['status'] ?? 'Pending') ?>
                                </span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div style="text-align: center; padding: 60px; background: #f8f9fa; border-radius: 16px;">
                <i class="fas fa-shopping-bag" style="font-size: 48px; color: #dee2e6; margin-bottom: 16px;"></i>
                <p>You haven't placed any orders yet.</p>
                <a href="<?= base_url('/customer/store') ?>" style="display: inline-block; margin-top: 16px; padding: 10px 24px; background: #ff6b35; color: white; text-decoration: none; border-radius: 30px;">Start Shopping →</a>
            </div>
        <?php endif; ?>
    </div>
</div>