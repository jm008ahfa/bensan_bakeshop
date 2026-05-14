<style>
    /* Dashboard Container - Full height without scroll */
    .dashboard-container {
        height: calc(100vh - 120px);
        overflow-y: auto;
        padding-right: 5px;
    }
    
    /* Hide scrollbar but keep functionality */
    .dashboard-container::-webkit-scrollbar {
        width: 5px;
    }
    
    .dashboard-container::-webkit-scrollbar-track {
        background: #eef2f7;
        border-radius: 10px;
    }
    
    .dashboard-container::-webkit-scrollbar-thumb {
        background: #ff6b35;
        border-radius: 10px;
    }
    
    /* Stats Cards */
    .stats-container {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 24px;
    }
    
    .stat-card {
        background: white;
        border-radius: 16px;
        padding: 20px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        border: 1px solid #eef2f7;
        transition: all 0.2s;
    }
    
    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }
    
    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 12px;
    }
    
    .stat-icon.primary { background: rgba(255,107,53,0.1); color: #ff6b35; }
    .stat-icon.success { background: rgba(40,167,69,0.1); color: #28a745; }
    .stat-icon.info { background: rgba(23,162,184,0.1); color: #17a2b8; }
    .stat-icon.warning { background: rgba(255,193,7,0.1); color: #ffc107; }
    
    .stat-value {
        font-size: 28px;
        font-weight: 700;
        color: #1a1a2e;
        margin-bottom: 4px;
    }
    
    .stat-label {
        font-size: 13px;
        color: #6c757d;
        font-weight: 500;
    }
    
    /* Main Content Grid */
    .dashboard-grid {
        display: grid;
        grid-template-columns: 1fr 380px;
        gap: 24px;
    }
    
    /* Recent Orders Table */
    .recent-orders {
        background: white;
        border-radius: 16px;
        border: 1px solid #eef2f7;
        overflow: hidden;
    }
    
    .section-header {
        padding: 16px 20px;
        border-bottom: 1px solid #eef2f7;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .section-header h4 {
        font-size: 16px;
        font-weight: 600;
        margin: 0;
    }
    
    .orders-table {
        width: 100%;
    }
    
    .orders-table th {
        padding: 12px 20px;
        text-align: left;
        font-size: 12px;
        font-weight: 600;
        color: #6c757d;
        border-bottom: 1px solid #eef2f7;
        background: #fafbfc;
    }
    
    .orders-table td {
        padding: 12px 20px;
        font-size: 13px;
        border-bottom: 1px solid #eef2f7;
    }
    
    /* Quick Actions Sidebar */
    .quick-actions {
        background: white;
        border-radius: 16px;
        border: 1px solid #eef2f7;
        overflow: hidden;
    }
    
    .action-item {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 14px 20px;
        border-bottom: 1px solid #eef2f7;
        text-decoration: none;
        transition: all 0.2s;
        cursor: pointer;
    }
    
    .action-item:hover {
        background: #f8f9fa;
        transform: translateX(5px);
    }
    
    .action-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f8f9fa;
    }
    
    .action-icon i {
        font-size: 18px;
    }
    
    .action-info h6 {
        font-size: 14px;
        font-weight: 600;
        margin: 0 0 2px 0;
        color: #1a1a2e;
    }
    
    .action-info p {
        font-size: 11px;
        color: #6c757d;
        margin: 0;
    }
    
    /* Low Stock Alert */
    .low-stock-alert {
        background: #fff3e0;
        border-left: 4px solid #ffc107;
        padding: 12px 16px;
        border-radius: 12px;
        margin-bottom: 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .low-stock-alert .alert-content {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .low-stock-alert i {
        font-size: 20px;
        color: #e65100;
    }
    
    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: #adb5bd;
    }
    
    /* Responsive */
    @media (max-width: 1024px) {
        .dashboard-grid {
            grid-template-columns: 1fr;
        }
        .stats-container {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    
    @media (max-width: 640px) {
        .stats-container {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="dashboard-container">
    
    <!-- Stats Cards Row -->
    <div class="stats-container">
        <div class="stat-card">
            <div class="stat-icon primary">
                <i class="fas fa-cake fa-2x"></i>
            </div>
            <div class="stat-value"><?= $total_products ?? 0 ?></div>
            <div class="stat-label">Total Products</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon success">
                <i class="fas fa-warehouse fa-2x"></i>
            </div>
            <div class="stat-value"><?= $total_stock ?? 0 ?></div>
            <div class="stat-label">Total Stock</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon info">
                <i class="fas fa-shopping-cart fa-2x"></i>
            </div>
            <div class="stat-value"><?= $total_orders ?? 0 ?></div>
            <div class="stat-label">Total Orders</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon warning">
                <i class="fas fa-exclamation-triangle fa-2x"></i>
            </div>
            <div class="stat-value"><?= $low_stock_count ?? 0 ?></div>
            <div class="stat-label">Low Stock</div>
        </div>
    </div>
    
    <!-- Low Stock Alert (if any) -->
    <?php if(($low_stock_count ?? 0) > 0): ?>
    <div class="low-stock-alert">
        <div class="alert-content">
            <i class="fas fa-exclamation-triangle"></i>
            <span><strong>Low Stock Alert:</strong> <?= $low_stock_count ?> product(s) need reordering.</span>
        </div>
        <a href="<?= base_url('/products') ?>" style="color: #e65100; font-size: 13px;">View Products →</a>
    </div>
    <?php endif; ?>
    
    <!-- Main Dashboard Grid -->
    <div class="dashboard-grid">
        
        <!-- Left Column: Recent Orders -->
        <div class="recent-orders">
            <div class="section-header">
                <h4><i class="fas fa-history"></i> Recent Transactions</h4>
                <a href="<?= base_url('/orders') ?>" class="btn btn-sm btn-primary" style="padding: 4px 12px; font-size: 11px;">View All</a>
            </div>
            <div style="overflow-x: auto;">
                <table class="orders-table">
                    <thead>
                        <tr>
                            <th>Order #</th>
                            <th>Customer</th>
                            <th>Total</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(isset($recent_orders) && !empty($recent_orders)): ?>
                            <?php foreach($recent_orders as $order): ?>
                            <tr>
                                <td style="font-weight: 500;"><?= $order['order_number'] ?></td>
                                <td><?= $order['customer_name'] ?></td>
                                <td style="color: #28a745; font-weight: 600;">₱<?= number_format($order['total'], 2) ?></td>
                                <td><?= date('M d', strtotime($order['order_date'])) ?></td>
                                <td><span class="badge bg-success">Completed</span></td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="empty-state">No recent transactions</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Right Column: Quick Actions -->
        <div class="quick-actions">
            <div class="section-header">
                <h4><i class="fas fa-bolt"></i> Quick Actions</h4>
            </div>
            
            <a href="<?= base_url('/pos') ?>" class="action-item" data-ajax="true">
                <div class="action-icon" style="background: rgba(255,107,53,0.1);">
                    <i class="fas fa-cash-register" style="color: #ff6b35;"></i>
                </div>
                <div class="action-info">
                    <h6>Point of Sale</h6>
                    <p>Process new walk-in orders</p>
                </div>
                <i class="fas fa-chevron-right" style="margin-left: auto; color: #adb5bd; font-size: 12px;"></i>
            </a>
            
            <a href="<?= base_url('/product/add') ?>" class="action-item" data-ajax="true">
                <div class="action-icon" style="background: rgba(40,167,69,0.1);">
                    <i class="fas fa-plus-circle" style="color: #28a745;"></i>
                </div>
                <div class="action-info">
                    <h6>Add New Product</h6>
                    <p>Expand your product catalog</p>
                </div>
                <i class="fas fa-chevron-right" style="margin-left: auto; color: #adb5bd; font-size: 12px;"></i>
            </a>
            
            <a href="<?= base_url('/order-confirmation/pending') ?>" class="action-item" data-ajax="true">
                <div class="action-icon" style="background: rgba(23,162,184,0.1);">
                    <i class="fas fa-clock" style="color: #17a2b8;"></i>
                </div>
                <div class="action-info">
                    <h6>Pending Orders</h6>
                    <p>Confirm online orders</p>
                </div>
                <i class="fas fa-chevron-right" style="margin-left: auto; color: #adb5bd; font-size: 12px;"></i>
            </a>
            
            <a href="<?= base_url('/reports') ?>" class="action-item" data-ajax="true">
                <div class="action-icon" style="background: rgba(111,66,193,0.1);">
                    <i class="fas fa-chart-line" style="color: #6f42c1;"></i>
                </div>
                <div class="action-info">
                    <h6>View Reports</h6>
                    <p>Sales and analytics</p>
                </div>
                <i class="fas fa-chevron-right" style="margin-left: auto; color: #adb5bd; font-size: 12px;"></i>
            </a>
            
            <a href="<?= base_url('/categories') ?>" class="action-item" data-ajax="true">
                <div class="action-icon" style="background: rgba(255,193,7,0.1);">
                    <i class="fas fa-tags" style="color: #ffc107;"></i>
                </div>
                <div class="action-info">
                    <h6>Manage Categories</h6>
                    <p>Organize your products</p>
                </div>
                <i class="fas fa-chevron-right" style="margin-left: auto; color: #adb5bd; font-size: 12px;"></i>
            </a>
        </div>
    </div>
    
</div>