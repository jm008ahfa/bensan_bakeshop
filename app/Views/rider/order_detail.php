<div style="max-width: 800px; margin: 0 auto;">
    <div class="card">
        <div class="card-header" style="background: #ff6b35; color: white;">
            <h4><i class="fas fa-receipt"></i> Order Details</h4>
        </div>
        <div class="card-body">
            
            <div style="margin-bottom: 20px;">
                <h5>Order Information</h5>
                <table style="width: 100%;">
                    <tr><td style="padding: 8px;"><strong>Order Number</strong></td><td><?= $order['order_number'] ?></td></tr>
                    <tr><td style="padding: 8px;"><strong>Order Date</strong></td><td><?= date('F d, Y h:i A', strtotime($order['order_date'])) ?></td></tr>
                    <tr><td style="padding: 8px;"><strong>Status</strong></td><td><?= ucfirst($order['status']) ?></td></tr>
                </table>
            </div>
            
            <div style="margin-bottom: 20px;">
                <h5>Customer Information</h5>
                <table style="width: 100%;">
                    <tr><td style="padding: 8px;"><strong>Name</strong></td><td><?= $order['customer_name'] ?></td></tr>
                    <tr><td style="padding: 8px;"><strong>Phone</strong></td><td><?= $order['customer_phone'] ?? 'N/A' ?></td></tr>
                    <tr><td style="padding: 8px;"><strong>Address</strong></td><td><?= $order['delivery_address'] ?? 'No address' ?></td></tr>
                </table>
            </div>
            
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
                            <td style="padding: 8px;"><?= $item['product_name'] ?></td>
                            <td style="padding: 8px; text-align: center;"><?= $item['quantity'] ?></td>
                            <td style="padding: 8px; text-align: right;">₱<?= number_format($item['price'], 2) ?></td>
                            <td style="padding: 8px; text-align: right;">₱<?= number_format($item['price'] * $item['quantity'], 2) ?></td>
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
                <a href="<?= base_url('/rider/assigned') ?>" class="btn btn-view" style="background: #6c757d; color: white; padding: 10px 20px; text-decoration: none; border-radius: 8px;">Back</a>
            </div>
        </div>
    </div>
</div>