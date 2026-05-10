<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rider Login - Bensan Bakeshop</title>
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
        }
        .login-container {
            background: white;
            padding: 40px;
            border-radius: 24px;
            width: 400px;
            max-width: 90%;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        }
        .logo { text-align: center; margin-bottom: 30px; }
        .logo-icon { width: 70px; height: 70px; background: #ff6b35; border-radius: 20px; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 15px; }
        .logo-icon i { font-size: 35px; color: white; }
        .logo h1 { font-size: 1.5rem; }
        .logo p { color: #6c757d; font-size: 0.8rem; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; font-weight: 600; margin-bottom: 8px; }
        .input-wrapper { position: relative; }
        .input-wrapper i { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #adb5bd; }
        .input-wrapper input { width: 100%; padding: 12px 16px 12px 44px; border: 1px solid #ddd; border-radius: 12px; font-size: 0.9rem; }
        .btn-login { width: 100%; padding: 12px; background: #ff6b35; color: white; border: none; border-radius: 12px; font-weight: 600; cursor: pointer; font-size: 1rem; }
        .alert { padding: 12px; border-radius: 12px; margin-bottom: 20px; background: #ffebee; color: #c62828; }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="logo">
            <div class="logo-icon"><i class="fas fa-motorcycle"></i></div>
            <h1>Rider Portal</h1>
            <p>Bensan Bakeshop Delivery</p>
        </div>
        <?php if(session()->getFlashdata('error')): ?>
            <div class="alert"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>
        <form action="<?= base_url('/rider/doLogin') ?>" method="post">
            <div class="form-group">
                <label>Email</label>
                <div class="input-wrapper">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" placeholder="Enter your email" required>
                </div>
            </div>
            <div class="form-group">
                <label>Password</label>
                <div class="input-wrapper">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" placeholder="Enter your password" required>
                </div>


                <div class="register-link" style="text-align: center; margin-top: 20px; padding-top: 20px; border-top: 1px solid #eef2f7;">
    <p>Don't have an account? <a href="<?= base_url('/rider/register') ?>" style="color: #ff6b35; text-decoration: none; font-weight: 600;">Register as Rider</a></p>
</div>
            </div>
            <button type="submit" class="btn-login">Sign In</button>
        </form>
    </div>
</body>
</html>