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
                        <th>Customer Phone</th>
                        <td><?= $order['customer_phone'] ?? 'N/A' ?></td>
                    </tr>
                    <tr>
                        <th>Customer Email</th>
                        <td><?= $order['customer_email'] ?? 'N/A' ?></td>
                    </tr>
                    <tr>
                        <th>Delivery Address</th>
                        <td><?= $order['delivery_address'] ?? 'No address' ?></td>
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
                            $status = $order['status'] ?? 'pending';
                            $statusColors = [
                                'pending' => 'warning',
                                'preparing' => 'info',
                                'ready' => 'primary',
                                'completed' => 'success',
                                'cancelled' => 'danger',
                                'assigned' => 'info'
                            ];
                            $color = $statusColors[$status] ?? 'secondary';
                            ?>
                            <span class="badge bg-<?= $color ?>"><?= ucfirst($status) ?></span>
                        </td>
                    </tr>
                    <tr>
                        <th>Delivery Status</th>
                        <td>
                            <?php
                            $deliveryStatus = $order['delivery_status'] ?? 'pending';
                            $deliveryColors = [
                                'pending' => 'warning',
                                'ready' => 'success',
                                'assigned' => 'info',
                                'delivered' => 'success',
                                'cancelled' => 'danger'
                            ];
                            $dColor = $deliveryColors[$deliveryStatus] ?? 'secondary';
                            ?>
                            <span class="badge bg-<?= $dColor ?>"><?= ucfirst($deliveryStatus) ?></span>
                        </td>
                    </tr>
                    <!-- RIDER INFORMATION - ADDED -->
                    <tr>
                        <th><i class="fas fa-motorcycle"></i> Assigned Rider</th>
                        <td>
                            <?php if(isset($order['rider_name']) && $order['rider_name']): ?>
                                <span class="badge bg-primary" style="font-size: 0.9rem;">
                                    <i class="fas fa-motorcycle"></i> <?= $order['rider_name'] ?>
                                </span>
                            <?php else: ?>
                                <span class="text-muted">No rider assigned yet</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php if(isset($order['rider_id']) && $order['rider_id']): ?>
                    <tr>
                        <th>Rider ID</th>
                        <td>#<?= $order['rider_id'] ?></td>
                    </tr>
                    <?php endif; ?>
                    <?php if(isset($order['confirmed_by_rider_at']) && $order['confirmed_by_rider_at']): ?>
                    <tr>
                        <th>Accepted At</th>
                        <td><?= date('F d, Y h:i A', strtotime($order['confirmed_by_rider_at'])) ?></td>
                    </tr>
                    <?php endif; ?>
                    <?php if(isset($order['estimated_delivery_time']) && $order['estimated_delivery_time']): ?>
                    <tr>
                        <th>Estimated Delivery</th>
                        <td><?= date('F d, Y h:i A', strtotime($order['estimated_delivery_time'])) ?></td>
                    </tr>
                    <?php endif; ?>
                    <?php if(isset($order['delivered_at']) && $order['delivered_at']): ?>
                    <tr>
                        <th>Delivered At</th>
                        <td><?= date('F d, Y h:i A', strtotime($order['delivered_at'])) ?></td>
                    </tr>
                    <?php endif; ?>
                    <?php if(isset($order['delivered_by_name']) && $order['delivered_by_name']): ?>
                    <tr>
                        <th>Delivered By</th>
                        <td><?= $order['delivered_by_name'] ?></td>
                    </tr>
                    <?php endif; ?>
                    <?php if(isset($order['delivery_notes']) && $order['delivery_notes']): ?>
                    <tr>
                        <th>Delivery Notes</th>
                        <td><?= $order['delivery_notes'] ?></td>
                    </tr>
                    <?php endif; ?>
                    <tr>
                        <th>Total Amount</th>
                        <td><h4 class="text-success mb-0">₱<?= number_format($order['total'], 2) ?></h4></td>
                    </tr>
                    <tr>
                        <th>Order Date</th>
                        <td><?= date('F d, Y h:i A', strtotime($order['order_date'])) ?></td>
                    </tr>
                <table>
            </div>
            <div class="col-md-6">
                <div class="card bg-light">
                    <div class="card-body text-center">
                        <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                        <h5>Order Summary</h5>
                        <hr>
                        <?php if(isset($order['rider_name']) && $order['rider_name']): ?>
                        <div class="alert alert-info">
                            <i class="fas fa-motorcycle"></i> 
                            <strong>Rider Assigned:</strong> <?= $order['rider_name'] ?>
                        </div>
                        <?php endif; ?>
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
        
        <!-- Delivery Proof if available -->
        <?php if(isset($order['delivery_photo']) && $order['delivery_photo']): ?>
        <div class="mt-4">
            <h5><i class="fas fa-camera"></i> Delivery Proof</h5>
            <div class="row">
                <div class="col-md-4">
                    <img src="<?= base_url('uploads/delivery_proof/'.$order['delivery_photo']) ?>" class="img-fluid rounded" alt="Delivery Proof" style="max-width: 100%;">
                </div>
            </div>
        </div>
        <?php endif; ?>
        
        <div class="mt-3">
            <a href="<?= base_url('/order-confirmation/ready') ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
            <?php if($order['delivery_status'] == 'ready'): ?>
            <a href="<?= base_url('/order-confirmation/markReadyForRider/'.$order['id']) ?>" class="btn btn-success">
                <i class="fas fa-motorcycle"></i> Ready for Rider
            </a>
            <?php endif; ?>
        </div>
    </div>
</div>