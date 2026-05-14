<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bensan Rider - <?= $title ?? 'Dashboard' ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: #f5f7fa; color: #1a1a2e; }

        /* Sidebar */
        .sidebar {
            width: 280px;
            background: linear-gradient(180deg, #1a1a2e 0%, #16213e 100%);
            color: white;
            position: fixed;
            height: 100vh;
            left: 0;
            top: 0;
            transition: left 0.3s ease;
            z-index: 1000;
            overflow-y: auto;
        }
        .sidebar.collapsed { left: -280px; }
        .sidebar-header { padding: 24px 20px; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .sidebar-header h3 { font-size: 18px; font-weight: 700; color: #ff6b35; }
        .sidebar-header p { font-size: 11px; color: rgba(255,255,255,0.6); margin-top: 6px; }
        .sidebar-menu { padding: 20px 0; }
        .sidebar-menu .menu-group { margin-bottom: 20px; }
        .sidebar-menu .menu-label { padding: 8px 20px; font-size: 11px; font-weight: 600; text-transform: uppercase; color: rgba(255,255,255,0.4); }
        .sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 10px 20px;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            gap: 12px;
            font-size: 14px;
            font-weight: 500;
        }
        .sidebar-menu a:hover { background: rgba(255,255,255,0.1); color: white; }
        .sidebar-menu a.active { background: rgba(255,107,53,0.2); color: #ff6b35; border-right: 3px solid #ff6b35; }
        .sidebar-menu i { width: 20px; }
        hr { margin: 10px 20px; border-color: rgba(255,255,255,0.1); }

        /* Main Content */
        .main-content { margin-left: 280px; min-height: 100vh; transition: margin-left 0.3s ease; }
        .main-content.expanded { margin-left: 0; }

        /* Top Bar */
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
        .menu-toggle { background: none; border: none; font-size: 20px; cursor: pointer; color: #4a5568; padding: 8px; border-radius: 8px; }
        .menu-toggle:hover { background: #f8f9fa; color: #ff6b35; }
        .page-title h2 { font-size: 20px; font-weight: 600; }
        .page-title p { font-size: 13px; color: #6c757d; margin-top: 4px; }
        .user-info { display: flex; align-items: center; gap: 16px; }
        .user-avatar { width: 40px; height: 40px; background: #ff6b35; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; }

        /* Content Area */
        .content-area { padding: 32px; }

        /* Cards */
        .card { background: white; border-radius: 16px; border: 1px solid #eef2f7; overflow: hidden; margin-bottom: 24px; }
        .card-header { padding: 16px 24px; border-bottom: 1px solid #eef2f7; display: flex; justify-content: space-between; align-items: center; }
        .card-header h4 { font-size: 16px; font-weight: 600; }
        .card-body { padding: 20px 24px; }

        .stats-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; margin-bottom: 32px; }
        .stat-card { background: white; border: 1px solid #eef2f7; border-radius: 16px; padding: 24px; text-align: center; }
        .stat-number { font-size: 32px; font-weight: 700; color: #ff6b35; }
        .stat-label { font-size: 13px; color: #6c757d; margin-top: 8px; }

        .order-card { background: white; border-radius: 12px; border: 1px solid #eef2f7; margin-bottom: 16px; overflow: hidden; }
        .order-header { padding: 14px 16px; background: #f8f9fa; border-bottom: 1px solid #eef2f7; display: flex; justify-content: space-between; align-items: center; }
        .order-number { font-weight: 700; }
        .badge { padding: 4px 12px; border-radius: 20px; font-size: 0.7rem; font-weight: 600; }
        .badge-ready { background: #fff3e0; color: #e65100; }
        .badge-assigned { background: #e3f2fd; color: #1565c0; }
        .badge-delivered { background: #e8f5e9; color: #2e7d32; }
        .order-body { padding: 16px; }
        .customer-info { background: #f0f9ff; border-radius: 10px; padding: 12px; margin-bottom: 12px; border-left: 3px solid #ff6b35; }
        .customer-info p { font-size: 0.8rem; margin-bottom: 5px; }
        .customer-info i { width: 22px; color: #ff6b35; }
        .order-items { margin-top: 10px; }
        .item-row { display: flex; justify-content: space-between; padding: 6px 0; border-bottom: 1px dashed #eef2f7; font-size: 0.8rem; }
        .order-total { margin-top: 12px; padding-top: 10px; border-top: 2px solid #eef2f7; display: flex; justify-content: space-between; font-weight: 700; }
        .btn { width: 100%; padding: 10px; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; margin-top: 12px; text-align: center; display: block; text-decoration: none; }
        .btn-accept { background: #28a745; color: white; }
        .btn-deliver { background: #ff6b35; color: white; }
        .btn-view { background: #6c757d; color: white; font-size: 0.8rem; }
        .empty-state { text-align: center; padding: 60px; color: #adb5bd; }
        .empty-state i { font-size: 48px; margin-bottom: 16px; opacity: 0.5; }
        .toast { position: fixed; bottom: 24px; right: 24px; padding: 12px 20px; border-radius: 10px; color: white; z-index: 2100; display: none; }

        @media (max-width: 768px) {
            .sidebar { left: -280px; }
            .main-content { margin-left: 0; }
            .stats-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <h3><i class="fas fa-motorcycle"></i> Bensan Rider</h3>
        <p>Delivery Management</p>
    </div>
    <div class="sidebar-menu">
        <div class="menu-group">
            <div class="menu-label">Dashboard</div>
            <a href="<?= base_url('/rider/dashboard') ?>" class="nav-link <?= ($active_menu == 'dashboard') ? 'active' : '' ?>">
                <i class="fas fa-tachometer-alt"></i> Overview
            </a>
        </div>

        <div class="menu-group">
            <div class="menu-label">Deliveries</div>
            <a href="<?= base_url('/rider/ready') ?>" class="nav-link <?= ($active_menu == 'ready') ? 'active' : '' ?>">
                <i class="fas fa-clock"></i> Ready for Pickup
            </a>
            <a href="<?= base_url('/rider/assigned') ?>" class="nav-link <?= ($active_menu == 'assigned') ? 'active' : '' ?>">
                <i class="fas fa-truck"></i> My Deliveries
            </a>
            <a href="<?= base_url('/rider/completed') ?>" class="nav-link <?= ($active_menu == 'completed') ? 'active' : '' ?>">
                <i class="fas fa-check-circle"></i> Completed
            </a>
        </div>

        <hr>
        <div class="menu-group">
            <a href="<?= base_url('/rider/logout') ?>" class="nav-link">
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
                <h2><?= $title ?? 'Rider Dashboard' ?></h2>
                <p>Welcome back, <?= session()->get('rider_name') ?></p>
            </div>
        </div>
        <div class="user-info">
            <span><i class="fas fa-motorcycle"></i> Rider</span>
            <div class="user-avatar">
                <?= substr(session()->get('rider_name'), 0, 1) ?>
            </div>
        </div>
    </div>

    <div class="content-area">
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
    setTimeout(() => { toast.style.display = 'none'; }, 2000);
}
</script>
</body>
</html>