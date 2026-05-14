<div class="card">
    <div class="card-header">
        <h4><i class="fas fa-chart-line"></i> Sales Report</h4>
    </div>
    <div class="card-body">
        
        <!-- Filter Form -->
        <form method="GET" action="<?= base_url('/reports/sales') ?>" class="mb-4">
            <div class="row">
                <div class="col-md-3">
                    <select name="filter" class="form-control" onchange="this.form.submit()">
                        <option value="daily" <?= $filter == 'daily' ? 'selected' : '' ?>>Daily</option>
                        <option value="weekly" <?= $filter == 'weekly' ? 'selected' : '' ?>>Weekly</option>
                        <option value="monthly" <?= $filter == 'monthly' ? 'selected' : '' ?>>Monthly</option>
                        <option value="yearly" <?= $filter == 'yearly' ? 'selected' : '' ?>>Yearly</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="date" name="date" class="form-control" value="<?= $date ?>" onchange="this.form.submit()">
                </div>
            </div>
        </form>
        
        <!-- Sales Table -->
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Date</th>
                        <th>Orders</th>
                        <th>Total Sales</th>
                        <th>Average Order</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $totalSales = 0;
                    $totalOrders = 0;
                    ?>
                    <?php foreach($salesData as $sale): ?>
                    <?php 
                    $totalSales += $sale['total'];
                    $totalOrders += $sale['count'];
                    ?>
                    <tr>
                        <td><?= $sale['date'] ?? 'Month ' . $sale['month'] ?></td>
                        <td><?= $sale['count'] ?> orders</td>
                        <td class="text-success fw-bold">₱<?= number_format($sale['total'], 2) ?></td>
                        <td>₱<?= number_format($sale['count'] > 0 ? $sale['total'] / $sale['count'] : 0, 2) ?></td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if(empty($salesData)): ?>
                    <tr>
                        <td colspan="4" class="text-center">No sales data found</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
                <?php if(!empty($salesData)): ?>
                <tfoot class="table-active">
                    <tr>
                        <th>Total</th>
                        <th><?= $totalOrders ?> orders</th>
                        <th class="text-success">₱<?= number_format($totalSales, 2) ?></th>
                        <th>₱<?= number_format($totalOrders > 0 ? $totalSales / $totalOrders : 0, 2) ?></th>
                    </tr>
                </tfoot>
                <?php endif; ?>
            </table>
        </div>
        
        <!-- Export Button -->
        <div class="mt-3">
            <button class="btn btn-success" onclick="exportToCSV()">
                <i class="fas fa-file-excel"></i> Export to CSV
            </button>
        </div>
    </div>
</div>

<script>
function exportToCSV() {
    const table = document.querySelector('table');
    const rows = table.querySelectorAll('tr');
    let csv = [];
    
    rows.forEach(row => {
        const cells = row.querySelectorAll('th, td');
        const rowData = Array.from(cells).map(cell => cell.innerText);
        csv.push(rowData.join(','));
    });
    
    const blob = new Blob([csv.join('\n')], { type: 'text/csv' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'sales_report.csv';
    a.click();
    URL.revokeObjectURL(url);
}
</script>