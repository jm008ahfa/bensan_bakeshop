<div class="card">
    <div class="card-header bg-primary text-white">
        <h4 class="mb-0"><i class="fas fa-receipt"></i> Order Details</h4>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <table class="table table-bordered">
                    <tr>
                        <th width="40%">Order Number</th>
                        <td><strong><?= $order['order_number'] ?></strong></td>
                    </tr>
                    <tr>
                        <th>Customer Name</th>
                        <td><?= $order['customer_name'] ?></td>
                    </tr>
                    <tr>
                        <th>Order Type</th>
                        <td>
                            <?php if($order['order_type'] == 'walk_in'): ?>
                                🏪 Walk-in Customer
                            <?php else: ?>
                                📱 Online Order
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            <?php
                            $status = $order['status'] ?? 'completed';
                            $statusColors = [
                                'pending' => 'warning',
                                'preparing' => 'info',
                                'ready' => 'primary',
                                'completed' => 'success',
                                'cancelled' => 'danger'
                            ];
                            $color = $statusColors[$status] ?? 'success';
                            ?>
                            <span class="badge bg-<?= $color ?>"><?= ucfirst($status) ?></span>
                        </td>
                    </tr>
                    <tr>
                        <th>Total Amount</th>
                        <td><h4 class="text-success mb-0">₱<?= number_format($order['total'], 2) ?></h4></td>
                    </tr>
                    <tr>
                        <th>Order Date</th>
                        <td><?= date('F d, Y h:i A', strtotime($order['order_date'])) ?></td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <div class="card bg-light">
                    <div class="card-body text-center">
                        <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                        <h5>Order Confirmed!</h5>
                        <p>Thank you for ordering from<br><strong>Bensan Bakeshop!</strong></p>
                        <hr>
                        <small class="text-muted">For inquiries, please contact the bakeshop.</small>
                    </div>
                </div>
            </div>
        </div>
        
        <?php if(isset($items) && !empty($items)): ?>
        <div class="mt-4">
            <h5><i class="fas fa-box"></i> Items Ordered</h5>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Unit Price</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($items as $item): ?>
                        <tr>
                            <td><?= $item['product_name'] ?></td>
                            <td><?= $item['quantity'] ?> pcs</td>
                            <td>₱<?= number_format($item['price'], 2) ?></td>
                            <td>₱<?= number_format($item['price'] * $item['quantity'], 2) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr class="table-active">
                            <th colspan="3" class="text-end">Total:</th>
                            <th class="text-success">₱<?= number_format($order['total'], 2) ?></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <?php endif; ?>
        
        <div class="mt-3">
            <a href="<?= base_url('/orders') ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Orders
            </a>
            <a href="<?= base_url('/order/create') ?>" class="btn btn-primary">
                <i class="fas fa-plus"></i> New Order
            </a>
        </div>
    </div>
</div>