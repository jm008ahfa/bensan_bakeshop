<div class="card">
    <div class="card-header">
        <h4><i class="fas fa-motorcycle"></i> Rider Performance Report</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Rider Name</th>
                        <th>Deliveries</th>
                        <th>Total Amount</th>
                        <th>Avg. Delivery Time</th>
                        <th>Rating</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($riderPerformance as $rider): ?>
                    <tr>
                        <td><strong><i class="fas fa-motorcycle text-warning"></i> <?= $rider['rider_name'] ?></strong></td>
                        <td><?= $rider['deliveries'] ?> deliveries</td>
                        <td class="text-success">₱<?= number_format($rider['total_amount'], 2) ?></td>
                        <td><?= round($rider['avg_delivery_time'] ?? 0) ?> minutes</td>
                        <td>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star-half-alt text-warning"></i>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if(empty($riderPerformance)): ?>
                    <tr><td colspan="5" class="text-center">No delivery data available</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>