<div class="card">
    <div class="card-header">
        <h4><i class="fas fa-clock"></i> Pending Orders</h4>
        <p class="text-muted mb-0">Online orders waiting for confirmation</p>
    </div>
    <div class="card-body">
        <?php if(isset($orders) && !empty($orders)): ?>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>Order #</th>
                            <th>Customer</th>
                            <th>Items</th>
                            <th>Total</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($orders as $order): ?>
                        <tr>
                            <td><strong><?= $order['order_number'] ?></strong></td>
                            <td><?= $order['customer_name'] ?></td>
                            <td><?= $order['item_count'] ?? 0 ?> item(s)</td>
                            <td class="text-success">₱<?= number_format($order['total'], 2) ?></td>
                            <td><?= date('M d, h:i A', strtotime($order['order_date'])) ?></td>
                            <td>
                                <a href="<?= base_url('/order-confirmation/view/'.$order['id']) ?>" class="btn btn-sm btn-info">View</a>
                                <a href="<?= base_url('/order-confirmation/confirm/'.$order['id']) ?>" class="btn btn-sm btn-success" onclick="return confirm('Confirm this order?')">Confirm</a>
                                <a href="<?= base_url('/order-confirmation/cancel/'.$order['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Cancel this order?')">Cancel</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-success text-center">No pending orders!</div>
        <?php endif; ?>
    </div>
</div>