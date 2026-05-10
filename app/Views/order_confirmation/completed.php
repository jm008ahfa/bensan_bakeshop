<div class="card">
    <div class="card-header">
        <h4><i class="fas fa-history"></i> Completed Orders</h4>
        <p class="text-muted mb-0">Last 50 completed orders</p>
    </div>
    <div class="card-body">
        <?php if(isset($orders) && !empty($orders)): ?>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Order #</th>
                            <th>Customer</th>
                            <th>Items</th>
                            <th>Total</th>
                            <th>Order Date</th>
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
                            <td><?= date('M d, Y', strtotime($order['order_date'])) ?></td>
                            <td>
                                <a href="<?= base_url('/order-confirmation/view/'.$order['id']) ?>" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i> View
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-info text-center">
                <p>No completed orders yet.</p>
            </div>
        <?php endif; ?>
    </div>
</div>