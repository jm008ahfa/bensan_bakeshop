<div class="container-fluid">
    
    <!-- Stats Cards -->
    <div class="row">
        <div class="col-md-3 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Today's Sales</h6>
                            <h2 class="mb-0">₱<?= number_format($todaySales, 2) ?></h2>
                            <small class="<?= $dailyGrowth >= 0 ? 'text-success' : 'text-danger' ?>">
                                <i class="fas fa-arrow-<?= $dailyGrowth >= 0 ? 'up' : 'down' ?>"></i> <?= abs($dailyGrowth) ?>% vs yesterday
                            </small>
                        </div>
                        <div class="bg-primary bg-opacity-10 p-3 rounded">
                            <i class="fas fa-chart-line fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">This Month</h6>
                            <h2 class="mb-0">₱<?= number_format($monthSales, 2) ?></h2>
                            <small class="<?= $monthlyGrowth >= 0 ? 'text-success' : 'text-danger' ?>">
                                <i class="fas fa-arrow-<?= $monthlyGrowth >= 0 ? 'up' : 'down' ?>"></i> <?= abs($monthlyGrowth) ?>% vs last month
                            </small>
                        </div>
                        <div class="bg-success bg-opacity-10 p-3 rounded">
                            <i class="fas fa-calendar-alt fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Total Orders</h6>
                            <h2 class="mb-0"><?= $totalOrders ?></h2>
                            <small class="text-success"><?= $completedOrders ?> completed</small>
                        </div>
                        <div class="bg-warning bg-opacity-10 p-3 rounded">
                            <i class="fas fa-shopping-cart fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Total Customers</h6>
                            <h2 class="mb-0"><?= $totalCustomers ?></h2>
                            <small class="text-muted">Active accounts</small>
                        </div>
                        <div class="bg-info bg-opacity-10 p-3 rounded">
                            <i class="fas fa-users fa-2x text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Quick Links -->
    <div class="row">
        <div class="col-md-3 mb-4">
            <a href="<?= base_url('/reports/sales') ?>" class="text-decoration-none">
                <div class="card border-0 shadow-sm text-center">
                    <div class="card-body">
                        <i class="fas fa-chart-line fa-3x text-primary mb-2"></i>
                        <h5 class="mb-0">Sales Report</h5>
                        <small class="text-muted">View sales analytics</small>
                    </div>
                </div>
            </a>
        </div>
        
        <div class="col-md-3 mb-4">
            <a href="<?= base_url('/reports/products') ?>" class="text-decoration-none">
                <div class="card border-0 shadow-sm text-center">
                    <div class="card-body">
                        <i class="fas fa-box fa-3x text-success mb-2"></i>
                        <h5 class="mb-0">Product Report</h5>
                        <small class="text-muted">Top sellers & low stock</small>
                    </div>
                </div>
            </a>
        </div>
        
        <div class="col-md-3 mb-4">
            <a href="<?= base_url('/reports/customers') ?>" class="text-decoration-none">
                <div class="card border-0 shadow-sm text-center">
                    <div class="card-body">
                        <i class="fas fa-users fa-3x text-info mb-2"></i>
                        <h5 class="mb-0">Customer Report</h5>
                        <small class="text-muted">Top spenders</small>
                    </div>
                </div>
            </a>
        </div>
        
        <div class="col-md-3 mb-4">
            <a href="<?= base_url('/reports/riders') ?>" class="text-decoration-none">
                <div class="card border-0 shadow-sm text-center">
                    <div class="card-body">
                        <i class="fas fa-motorcycle fa-3x text-warning mb-2"></i>
                        <h5 class="mb-0">Rider Report</h5>
                        <small class="text-muted">Performance analytics</small>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>

<style>
.card {
    transition: transform 0.2s;
}
.card:hover {
    transform: translateY(-5px);
}
</style>