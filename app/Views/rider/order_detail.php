<div class="container" style="max-width: 800px; margin: 0 auto;">
    <div class="card">
        <div class="card-header" style="background: #ff6b35; color: white;">
            <h4><i class="fas fa-receipt"></i> Order Details</h4>
        </div>
        <div class="card-body">
            
            <!-- Order Information -->
            <div style="margin-bottom: 20px;">
                <h5>Order Information</h5>
                <table style="width: 100%; border-collapse: collapse;">
                    <tr><td style="padding: 8px; border-bottom: 1px solid #eef2f7;"><strong>Order Number</strong></td><td style="padding: 8px; border-bottom: 1px solid #eef2f7;"><?= $order['order_number'] ?></td></tr>
                    <tr><td style="padding: 8px; border-bottom: 1px solid #eef2f7;"><strong>Order Date</strong></td><td style="padding: 8px; border-bottom: 1px solid #eef2f7;"><?= date('F d, Y h:i A', strtotime($order['order_date'])) ?></td></tr>
                    <tr><td style="padding: 8px; border-bottom: 1px solid #eef2f7;"><strong>Status</strong></td><td style="padding: 8px; border-bottom: 1px solid #eef2f7;"><?= ucfirst($order['status']) ?></td></tr>
                </table>
            </div>
            
            <!-- Customer Information - Name, Phone, Address Only -->
            <div style="margin-bottom: 20px;">
                <h5>Customer Information</h5>
                <table style="width: 100%; border-collapse: collapse;">
                    <tr><td style="padding: 8px; border-bottom: 1px solid #eef2f7;"><strong>Name</strong></td><td style="padding: 8px; border-bottom: 1px solid #eef2f7;"><?= $order['customer_name'] ?></td></tr>
                    <tr><td style="padding: 8px; border-bottom: 1px solid #eef2f7;"><strong>Phone</strong></td><td style="padding: 8px; border-bottom: 1px solid #eef2f7;"><?= $order['customer_phone'] ?? 'N/A' ?></td></tr>
                    <tr><td style="padding: 8px; border-bottom: 1px solid #eef2f7;"><strong>Delivery Address</strong></td><td style="padding: 8px; border-bottom: 1px solid #eef2f7;"><?= $order['delivery_address'] ?? 'No address' ?></td></tr>
                </table>
            </div>
            
            <!-- Order Items -->
            <div style="margin-bottom: 20px;">
                <h5>Order Items</h5>
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background: #f8f9fa;">
                            <th style="padding: 10px; text-align: left;">Product</th>
                            <th style="padding: 10px; text-align: center;">Quantity</th>
                            <th style="padding: 10px; text-align: right;">Price</th>
                            <th style="padding: 10px; text-align: right;">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($items as $item): ?>
                        <tr>
                            <td style="padding: 8px; border-bottom: 1px solid #eef2f7;"><?= $item['product_name'] ?></td>
                            <td style="padding: 8px; border-bottom: 1px solid #eef2f7; text-align: center;"><?= $item['quantity'] ?></td>
                            <td style="padding: 8px; border-bottom: 1px solid #eef2f7; text-align: right;">₱<?= number_format($item['price'], 2) ?></td>
                            <td style="padding: 8px; border-bottom: 1px solid #eef2f7; text-align: right;">₱<?= number_format($item['price'] * $item['quantity'], 2) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr style="background: #f8f9fa;">
                            <th colspan="3" style="padding: 12px; text-align: right;">Total:</th>
                            <th style="padding: 12px; text-align: right;">₱<?= number_format($order['total'], 2) ?></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            
            <div style="display: flex; gap: 10px; margin-top: 20px;">
                <a href="<?= base_url('/rider/dashboard') ?>" class="btn btn-secondary" style="padding: 10px 20px; background: #6c757d; color: white; text-decoration: none; border-radius: 8px;">Back to Dashboard</a>
                <?php if($order['delivery_status'] == 'ready'): ?>
                <a href="<?= base_url('/rider/acceptOrder/'.$order['id']) ?>" class="btn btn-success" style="padding: 10px 20px; background: #28a745; color: white; text-decoration: none; border-radius: 8px;">Accept Delivery</a>
                <?php elseif($order['delivery_status'] == 'assigned' && $order['rider_id'] == session()->get('rider_id')): ?>
                <a href="<?= base_url('/rider/confirmDelivery/'.$order['id']) ?>" class="btn btn-primary" style="padding: 10px 20px; background: #ff6b35; color: white; text-decoration: none; border-radius: 8px;">Confirm Delivery</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>