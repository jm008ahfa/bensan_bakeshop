<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bensan Bakeshop - <?= $title ?? 'System' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .sidebar {
            min-height: 100vh;
            background-color: #343a40;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            display: block;
        }
        .sidebar a:hover {
            background-color: #495057;
        }
        .sidebar a.active {
            background-color: #007bff;
        }
        .content {
            padding: 20px;
        }
        .navbar-brand {
            font-weight: bold;
        }
    </style>
</head>
<body>

<?php if(session()->get('logged_in')): ?>
<nav class="navbar navbar-dark bg-dark sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?= base_url('/dashboard') ?>">
            🥖 Bensan Bakeshop
        </a>
        <div class="text-white">
            Welcome, <?= session()->get('fullname') ?> 
            <a href="<?= base_url('/logout') ?>" class="btn btn-sm btn-danger ms-2">Logout</a>
        </div>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-2 sidebar p-0">
            <div class="pt-3">
                <a href="<?= base_url('/dashboard') ?>">📊 Dashboard</a>
                <a href="<?= base_url('/products') ?>">🥖 Products</a>
                <a href="<?= base_url('/orders') ?>">📦 Orders</a>
                <a href="<?= base_url('/order/create') ?>">➕ New Order</a>
                
                <hr class="text-white">
                <a href="<?= base_url('/logout') ?>" class="text-danger">🚪 Logout</a>
            </div>
        </div>
        <div class="col-md-10 content">
<?php endif; ?>

            <?php if(session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
            
            <?php if(session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
            
            <h2 class="mb-4"><?= $title ?? 'Dashboard' ?></h2>
            
            <?= $content ?>

<?php if(session()->get('logged_in')): ?>
        </div>
    </div>
</div>
<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>