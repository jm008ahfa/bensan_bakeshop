<div class="card">
    <div class="card-header">
        <h4><i class="fas fa-check-circle"></i> Completed Orders</h4>
        <p class="text-muted mb-0">Successfully delivered orders</p>
    </div>
    <div class="card-body">
        <?php if(isset($orders) && !empty($orders)): ?>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Order #</th>
                            <th>Customer</th>
                            <th>Rider</th>
                            <th>Items</th>
                            <th>Total</th>
                            <th>Order Date</th>
                            <th>Delivered At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($orders as $order): ?>
                        <tr>
                            <td><strong><?= $order['order_number'] ?></strong></td>
                            <td><?= $order['customer_name'] ?></td>
                            <td>
                                <?php if(isset($order['rider_name']) && $order['rider_name']): ?>
                                    <span class="badge bg-info">
                                        <i class="fas fa-motorcycle"></i> <?= $order['rider_name'] ?>
                                    </span>
                                <?php else: ?>
                                    <span class="text-muted">—</span>
                                <?php endif; ?>
                             </div>
                            </td>
                            <td><?= $order['item_count'] ?? 0 ?> item(s)</td>
                            <td class="text-success">₱<?= number_format($order['total'], 2) ?></td>
                            <td><?= date('M d, Y', strtotime($order['order_date'])) ?></td>
                            <td>
                                <?php if(isset($order['delivered_at']) && $order['delivered_at']): ?>
                                    <?= date('M d, h:i A', strtotime($order['delivered_at'])) ?>
                                <?php else: ?>
                                    —
                                <?php endif; ?>
                             </div>
                            </td>
                            <td>
                                <a href="<?= base_url('/order-confirmation/view/'.$order['id']) ?>" class="btn btn-sm btn-info">View</a>
                             </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-info text-center">
                <i class="fas fa-info-circle"></i> No completed orders yet.
            </div>
        <?php endif; ?>
    </div>
</div>