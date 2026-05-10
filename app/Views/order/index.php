<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4><i class="fas fa-shopping-cart"></i> Order List</h4>
        <a href="<?= base_url('/order/create') ?>" class="btn btn-primary">
            <i class="fas fa-plus"></i> New Order
        </a>
    </div>
    <div class="card-body">
        <?php if(isset($orders) && !empty($orders)): ?>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Order #</th>
                            <th>Customer</th>
                            <th>Type</th>
                            <th>Product(s)</th>
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
                            <td>
                                <?php if($order['order_type'] == 'walk_in'): ?>
                                    <span class="badge bg-info">Walk-in</span>
                                <?php else: ?>
                                    <span class="badge bg-primary">Online</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php 
                                // Display product summary
                                if(isset($order['product_summary']) && $order['product_summary']):
                                    echo $order['product_summary'];
                                elseif(isset($order['items']) && !empty($order['items'])):
                                    $names = array_column($order['items'], 'product_name');
                                    echo implode(', ', $names);
                                else:
                                    echo '—';
                                endif;
                                ?>
                            </td>
                            <td>
                                <?= $order['item_count'] ?? (isset($order['items']) ? count($order['items']) : 0) ?> item(s)
                            </td>
                            <td><strong class="text-success">₱<?= number_format($order['total'] ?? 0, 2) ?></strong></td>
                            <td><?= date('m/d/Y h:i A', strtotime($order['order_date'])) ?></td>
                            <td>
                                <a href="<?= base_url('/order/view/'.$order['id']) ?>" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i> View
                                </a>
                                <a href="<?= base_url('/order/delete/'.$order['id']) ?>" class="btn btn-sm btn-danger" 
                                   onclick="return confirm('Delete this order? This will restore product stock.')">
                                    <i class="fas fa-trash"></i> Delete
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-info text-center">
                <i class="fas fa-info-circle"></i> No orders yet.
                <a href="<?= base_url('/order/create') ?>">Click here to create your first order</a>
            </div>
        <?php endif; ?>
    </div>
</div>