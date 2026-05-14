<div class="row">
    <!-- Top Customers -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h4><i class="fas fa-trophy text-warning"></i> Top Spending Customers</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>Customer</th>
                                <th>Email</th>
                                <th>Orders</th>
                                <th>Total Spent</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($topCustomers as $customer): ?>
                            <tr>
                                <td><strong><?= $customer['customer_name'] ?></strong></td>
                                <td><?= $customer['customer_email'] ?></td>
                                <td><?= $customer['order_count'] ?> orders</td>
                                <td class="text-success">₱<?= number_format($customer['total_spent'], 2) ?></td>
                            </tr>
                            <?php endforeach; ?>
                            <?php if(empty($topCustomers)): ?>
                            <tr><td colspan="4" class="text-center">No data available</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <!-- New Customers -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h4><i class="fas fa-user-plus text-success"></i> New Customers This Month</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Joined</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($newCustomers as $customer): ?>
                            <tr>
                                <td><?= $customer['name'] ?></td>
                                <td><?= $customer['email'] ?></td>
                                <td><?= $customer['phone'] ?? 'N/A' ?></td>
                                <td><?= date('M d, Y', strtotime($customer['created_at'])) ?></td>
                            </tr>
                            <?php endforeach; ?>
                            <?php if(empty($newCustomers)): ?>
                            <tr><td colspan="4" class="text-center">No new customers this month</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>