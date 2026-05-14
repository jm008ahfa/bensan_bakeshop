<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bensan Bakeshop - <?= $title ?? 'Dashboard' ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #f5f7fa;
            color: #1a1a2e;
        }

        .sidebar {
            width: 260px;
            background: white;
            position: fixed;
            height: 100vh;
            left: 0;
            top: 0;
            border-right: 1px solid #eef2f7;
            transition: left 0.3s ease;
            z-index: 1000;
            overflow-y: auto;
        }

        .sidebar.collapsed {
            left: -260px;
        }

        .sidebar-header {
            padding: 24px 20px;
            border-bottom: 1px solid #eef2f7;
        }

        .sidebar-header h3 {
            font-size: 18px;
            font-weight: 700;
            margin: 0;
            color: #ff6b35;
        }

        .sidebar-header p {
            font-size: 11px;
            color: #6c757d;
            margin: 6px 0 0;
        }

        .sidebar-menu {
            padding: 20px 0;
        }

        .sidebar-menu .menu-group {
            margin-bottom: 20px;
        }

        .sidebar-menu .menu-label {
            padding: 8px 20px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #adb5bd;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 10px 20px;
            color: #4a5568;
            text-decoration: none;
            transition: all 0.2s;
            gap: 12px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
        }

        .sidebar-menu a:hover {
            background: #f8f9fa;
            color: #ff6b35;
        }

        .sidebar-menu a.active {
            background: #fff5f0;
            color: #ff6b35;
            border-right: 3px solid #ff6b35;
        }

        .sidebar-menu i {
            width: 20px;
            font-size: 16px;
        }

        hr {
            margin: 10px 20px;
            border-color: #eef2f7;
        }

        .main-content {
            margin-left: 260px;
            min-height: 100vh;
            transition: margin-left 0.3s ease;
        }

        .main-content.expanded {
            margin-left: 0;
        }

        .top-bar {
            background: white;
            padding: 16px 32px;
            border-bottom: 1px solid #eef2f7;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .menu-toggle {
            background: none;
            border: none;
            font-size: 20px;
            cursor: pointer;
            color: #4a5568;
            padding: 8px;
            border-radius: 8px;
            transition: all 0.2s;
        }

        .menu-toggle:hover {
            background: #f8f9fa;
            color: #ff6b35;
        }

        .page-title h2 {
            font-size: 20px;
            font-weight: 600;
            margin: 0;
        }

        .page-title p {
            font-size: 13px;
            color: #6c757d;
            margin: 4px 0 0;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .user-info span {
            font-size: 13px;
            font-weight: 500;
            color: #1a1a2e;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            background: #ff6b35;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 16px;
        }

        .content-area {
            padding: 32px;
        }

        .card {
            background: white;
            border-radius: 16px;
            border: 1px solid #eef2f7;
            overflow: hidden;
            margin-bottom: 24px;
        }

        .card-header {
            padding: 16px 24px;
            border-bottom: 1px solid #eef2f7;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-header h4 {
            font-size: 16px;
            font-weight: 600;
            margin: 0;
        }

        .card-body {
            padding: 20px 24px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 24px;
            margin-bottom: 32px;
        }

        .stat-card {
            background: white;
            border: 1px solid #eef2f7;
            border-radius: 16px;
            padding: 20px;
            transition: all 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }

        .stat-title {
            font-size: 13px;
            font-weight: 500;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 12px;
        }

        .stat-value {
            font-size: 32px;
            font-weight: 700;
            color: #1a1a2e;
        }

        .table-responsive {
            overflow-x: auto;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th {
            text-align: left;
            padding: 12px 0;
            font-size: 12px;
            font-weight: 600;
            color: #6c757d;
            border-bottom: 1px solid #eef2f7;
        }

        .table td {
            padding: 12px 0;
            font-size: 14px;
            border-bottom: 1px solid #eef2f7;
        }

        .btn {
            padding: 8px 16px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 500;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary {
            background: #ff6b35;
            color: white;
        }

        .btn-primary:hover {
            background: #e55a2b;
        }

        .btn-sm {
            padding: 6px 12px;
            font-size: 12px;
        }

        .badge {
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 500;
        }

        .badge-success {
            background: #e8f5e9;
            color: #2e7d32;
        }

        .badge-warning {
            background: #fff3e0;
            color: #e65100;
        }

        .alert {
            padding: 12px 16px;
            border-radius: 12px;
            font-size: 13px;
            margin-bottom: 24px;
        }

        .alert-success {
            background: #e8f5e9;
            color: #2e7d32;
            border: 1px solid #c8e6c9;
        }

        .alert-warning {
            background: #fff3e0;
            color: #e65100;
            border: 1px solid #ffe0b2;
        }

        .toast {
            position: fixed;
            bottom: 24px;
            right: 24px;
            padding: 10px 20px;
            border-radius: 10px;
            color: white;
            z-index: 2100;
            display: none;
        }

        @media (max-width: 768px) {
            .sidebar {
                left: -260px;
            }
            .main-content {
                margin-left: 0;
            }
            .stats-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <h3>Bensan Bakeshop</h3>
        <p>Ordering System</p>
    </div>
    <div class="sidebar-menu">
        
        <?php if(session()->get('role') == 'admin'): ?>
        <div class="menu-group">
            <div class="menu-label">Main</div>
            <a href="<?= base_url('/dashboard') ?>" class="nav-link <?= ($active_menu ?? '') == 'dashboard' ? 'active' : '' ?>">
                <i class="fas fa-chart-line"></i> Dashboard
            </a>
            <a href="<?= base_url('/pos') ?>" class="nav-link <?= ($active_menu ?? '') == 'pos' ? 'active' : '' ?>">
                <i class="fas fa-cash-register"></i> Point of Sale
            </a>
        </div>

        <div class="menu-group">
            <div class="menu-label">Management</div>
            <a href="<?= base_url('/products') ?>" class="nav-link <?= ($active_menu ?? '') == 'products' ? 'active' : '' ?>">
                <i class="fas fa-box"></i> Products
            </a>
            <a href="<?= base_url('/categories') ?>" class="nav-link <?= ($active_menu ?? '') == 'categories' ? 'active' : '' ?>">
                <i class="fas fa-tags"></i> Categories
            </a>
            <a href="<?= base_url('/orders') ?>" class="nav-link <?= ($active_menu ?? '') == 'orders' ? 'active' : '' ?>">
                <i class="fas fa-shopping-cart"></i> All Orders
            </a>
        </div>

        <div class="menu-group">
            <div class="menu-label">Reports</div>
            <a href="<?= base_url('/reports') ?>" class="nav-link <?= ($active_menu ?? '') == 'reports' ? 'active' : '' ?>">
                <i class="fas fa-chart-pie"></i> Analytics
            </a>
        </div>
        <?php endif; ?>

        <!-- POS and Online Orders - Visible to Both -->
        <div class="menu-group">
            <div class="menu-label">Sales</div>
            <a href="<?= base_url('/pos') ?>" class="nav-link <?= ($active_menu ?? '') == 'pos' ? 'active' : '' ?>">
                <i class="fas fa-cash-register"></i> Point of Sale
            </a>
        </div>

        <div class="menu-group">
            <div class="menu-label">Online Orders</div>
            <a href="<?= base_url('/order-confirmation/pending') ?>" class="nav-link <?= ($active_menu ?? '') == 'pending_orders' ? 'active' : '' ?>">
                <i class="fas fa-clock"></i> Pending
            </a>
            <a href="<?= base_url('/order-confirmation/preparing') ?>" class="nav-link <?= ($active_menu ?? '') == 'preparing_orders' ? 'active' : '' ?>">
                <i class="fas fa-cog"></i> Preparing
            </a>
            <a href="<?= base_url('/order-confirmation/ready') ?>" class="nav-link <?= ($active_menu ?? '') == 'ready_orders' ? 'active' : '' ?>">
                <i class="fas fa-check-circle"></i> Ready
            </a>
            <a href="<?= base_url('/order-confirmation/completed') ?>" class="nav-link <?= ($active_menu ?? '') == 'completed_orders' ? 'active' : '' ?>">
                <i class="fas fa-check-double"></i> Completed
            </a>
        </div>

        <hr>
        <div class="menu-group">
            <a href="<?= base_url('/logout') ?>" class="nav-link">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="main-content" id="mainContent">
    <div class="top-bar">
        <div style="display: flex; align-items: center; gap: 16px;">
            <button class="menu-toggle" id="sidebarToggle" onclick="toggleSidebar()">
                <i class="fas fa-bars"></i>
            </button>
            <div class="page-title">
                <h2 id="pageTitle"><?= $title ?? 'Dashboard' ?></h2>
                <p>Welcome back, <?= session()->get('fullname') ?></p>
            </div>
        </div>
        <div class="user-info">
            <span><?= session()->get('role') ?? 'Admin' ?></span>
            <div class="user-avatar">
                <?= substr(session()->get('fullname'), 0, 1) ?>
            </div>
        </div>
    </div>

    <div class="content-area" id="dynamicContent">
        <?= $content ?>
    </div>
</div>

<div id="toast" class="toast"></div>

<script>
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('mainContent');
    sidebar.classList.toggle('collapsed');
    mainContent.classList.toggle('expanded');
}

function showMessage(msg, type) {
    const toast = document.getElementById('toast');
    toast.style.background = type === 'success' ? '#28a745' : '#dc3545';
    toast.innerHTML = `<i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i> ${msg}`;
    toast.style.display = 'block';
    setTimeout(() => {
        toast.style.display = 'none';
    }, 2000);
}
</script>

</body>
</html>