<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rider Dashboard - Bensan Bakeshop</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: #f5f7fa; }
        .navbar { background: white; padding: 15px 0; border-bottom: 1px solid #eef2f7; }
        .container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }
        .navbar .container { display: flex; justify-content: space-between; align-items: center; }
        .logo { font-size: 1.3rem; font-weight: 700; color: #ff6b35; text-decoration: none; }
        .nav-links a { margin-left: 20px; text-decoration: none; color: #4a5568; }
        .content { padding: 30px 0; }
        .card { background: white; border-radius: 16px; border: 1px solid #eef2f7; margin-bottom: 24px; overflow: hidden; }
        .card-header { padding: 16px 20px; border-bottom: 1px solid #eef2f7; font-weight: 600; font-size: 1.1rem; }
        .card-body { padding: 20px; }
        .btn { padding: 8px 16px; border-radius: 8px; border: none; cursor: pointer; text-decoration: none; display: inline-block; font-weight: 500; }
        .btn-success { background: #28a745; color: white; }
        .btn-primary { background: #ff6b35; color: white; }
        .badge { padding: 4px 12px; border-radius: 20px; font-size: 0.7rem; font-weight: 600; }
        .badge-ready { background: #fff3e0; color: #e65100; }
        .badge-assigned { background: #e3f2fd; color: #1565c0; }
        .badge-delivered { background: #e8f5e9; color: #2e7d32; }
        .stats { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 30px; }
        .stat-card { background: white; border-radius: 16px; padding: 20px; text-align: center; border: 1px solid #eef2f7; }
        .stat-number { font-size: 2rem; font-weight: 700; color: #ff6b35; }
        .stat-label { color: #6c757d; font-size: 0.85rem; }
        @media (max-width: 768px) { .stats { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <a href="<?= base_url('/rider/dashboard') ?>" class="logo"><i class="fas fa-motorcycle"></i> Bensan Rider</a>
            <div class="nav-links">
                <span>Welcome, <?= session()->get('rider_name') ?></span>
                <a href="<?= base_url('/rider/logout') ?>" style="color: #dc3545;">Logout</a>
            </div>
        </div>
    </nav>
    <div class="container content">
        <?= $content ?>
    </div>
</body>
</html>