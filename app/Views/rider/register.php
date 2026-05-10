<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rider Registration - Bensan Bakeshop</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #1a1a2e, #16213e);
            padding: 20px;
        }
        .register-container {
            background: white;
            padding: 40px;
            border-radius: 24px;
            width: 500px;
            max-width: 100%;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        }
        .logo { text-align: center; margin-bottom: 30px; }
        .logo-icon { width: 70px; height: 70px; background: #ff6b35; border-radius: 20px; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 15px; }
        .logo-icon i { font-size: 35px; color: white; }
        .logo h1 { font-size: 1.5rem; }
        .logo p { color: #6c757d; font-size: 0.8rem; }
        .form-group { margin-bottom: 18px; }
        .form-group label { display: block; font-weight: 600; margin-bottom: 6px; font-size: 0.8rem; }
        .input-wrapper { position: relative; }
        .input-wrapper i { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #adb5bd; }
        .input-wrapper input, .input-wrapper select { width: 100%; padding: 12px 16px 12px 44px; border: 1px solid #ddd; border-radius: 12px; font-size: 0.9rem; font-family: 'Inter', sans-serif; }
        .btn-register { width: 100%; padding: 14px; background: #ff6b35; color: white; border: none; border-radius: 12px; font-weight: 600; cursor: pointer; font-size: 1rem; margin-top: 10px; }
        .login-link { text-align: center; margin-top: 20px; padding-top: 20px; border-top: 1px solid #eef2f7; }
        .login-link a { color: #ff6b35; text-decoration: none; font-weight: 600; }
        .alert { padding: 12px; border-radius: 12px; margin-bottom: 20px; font-size: 0.8rem; }
        .alert-danger { background: #ffebee; color: #c62828; }
        .alert-success { background: #e8f5e9; color: #2e7d32; }
        .alert-errors { background: #fff3e0; color: #e65100; }
        .alert-errors ul { margin-left: 20px; }
    </style>
</head>
<body>
<div class="register-container">
    <div class="logo">
        <div class="logo-icon"><i class="fas fa-motorcycle"></i></div>
        <h1>Become a Rider</h1>
        <p>Join our delivery team</p>
    </div>

    <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <?php if(session()->getFlashdata('errors')): ?>
        <div class="alert alert-errors">
            Please fix the following errors:
            <ul>
                <?php foreach(session()->getFlashdata('errors') as $error): ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('/rider/doRegister') ?>" method="post">
        <div class="form-group">
            <label>Full Name</label>
            <div class="input-wrapper">
                <i class="fas fa-user"></i>
                <input type="text" name="name" value="<?= old('name') ?>" required>
            </div>
        </div>
        <div class="form-group">
            <label>Email</label>
            <div class="input-wrapper">
                <i class="fas fa-envelope"></i>
                <input type="email" name="email" value="<?= old('email') ?>" required>
            </div>
        </div>
        <div class="form-group">
            <label>Phone</label>
            <div class="input-wrapper">
                <i class="fas fa-phone"></i>
                <input type="tel" name="phone" value="<?= old('phone') ?>" required>
            </div>
        </div>
        <div class="form-group">
            <label>Vehicle Type</label>
            <div class="input-wrapper">
                <i class="fas fa-motorcycle"></i>
                <select name="vehicle_type" required>
                    <option value="">Select</option>
                    <option value="motorcycle">Motorcycle</option>
                    <option value="scooter">Scooter</option>
                    <option value="bicycle">Bicycle</option>
                    <option value="car">Car</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label>Plate Number</label>
            <div class="input-wrapper">
                <i class="fas fa-id-card"></i>
                <input type="text" name="plate_number" value="<?= old('plate_number') ?>" required>
            </div>
        </div>
        <div class="form-group">
            <label>Password</label>
            <div class="input-wrapper">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" required>
            </div>
        </div>
        <div class="form-group">
            <label>Confirm Password</label>
            <div class="input-wrapper">
                <i class="fas fa-check-circle"></i>
                <input type="password" name="confirm_password" required>
            </div>
        </div>
        <button type="submit" class="btn-register">Register as Rider</button>
    </form>
    <div class="login-link">
        <p>Already have an account? <a href="<?= base_url('/rider/login') ?>">Sign in</a></p>
    </div>
</div>
</body>
</html>