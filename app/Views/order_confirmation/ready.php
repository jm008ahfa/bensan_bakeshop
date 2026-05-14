<div class="card">
    <div class="card-header">
        <h4><i class="fas fa-check-circle"></i> Ready Orders</h4>
        <p class="text-muted mb-0">Orders ready for pickup/delivery</p>
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
                            <th>Delivery Status</th>
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
                                <?php if($order['delivery_status'] == 'ready'): ?>
                                    <span class="badge bg-success">Ready for Rider</span>
                                <?php elseif($order['delivery_status'] == 'assigned'): ?>
                                    <span class="badge bg-info">Assigned to Rider</span>
                                <?php elseif($order['delivery_status'] == 'delivered'): ?>
                                    <span class="badge bg-secondary">Delivered</span>
                                <?php else: ?>
                                    <span class="badge bg-warning">Pending</span>
                                <?php endif; ?>
                             </div>
                            </td>
                            <td>
                                <?php if($order['delivery_status'] != 'assigned' && $order['delivery_status'] != 'delivered'): ?>
                                    <a href="<?= base_url('/order-confirmation/markReadyForRider/'.$order['id']) ?>" class="btn btn-sm btn-success" onclick="return confirm('Mark this order as ready for rider pickup?')">
                                        <i class="fas fa-motorcycle"></i> Ready for Rider
                                    </a>
                                <?php endif; ?>
                                <a href="<?= base_url('/order-confirmation/view/'.$order['id']) ?>" class="btn btn-sm btn-info">View</a>
                             </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-info text-center">No ready orders.</div>
        <?php endif; ?>
    </div>
</div>