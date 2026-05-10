<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Login - Bensan Bakeshop</title>
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
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            overflow-x: hidden;
        }

        /* Animated Background */
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 20% 80%, rgba(255,255,255,0.15) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255,255,255,0.1) 0%, transparent 50%),
                repeating-linear-gradient(45deg, rgba(255,255,255,0.03) 0px, rgba(255,255,255,0.03) 2px, transparent 2px, transparent 8px);
            pointer-events: none;
        }

        /* Floating Baked Goods Decoration */
        .floating-icon {
            position: absolute;
            font-size: 60px;
            opacity: 0.12;
            animation: float 6s ease-in-out infinite;
            pointer-events: none;
            color: white;
            filter: drop-shadow(0 5px 15px rgba(0,0,0,0.1));
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-25px) rotate(8deg); }
        }

        @keyframes floatReverse {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(25px) rotate(-8deg); }
        }

        .icon-1 { top: 10%; left: 5%; animation-delay: 0s; font-size: 70px; }
        .icon-2 { top: 80%; left: 8%; animation-delay: 1s; font-size: 90px; animation-name: floatReverse; }
        .icon-3 { top: 15%; right: 8%; animation-delay: 2s; font-size: 55px; }
        .icon-4 { bottom: 12%; right: 10%; animation-delay: 1.5s; font-size: 80px; animation-name: floatReverse; }
        .icon-5 { top: 45%; left: 90%; animation-delay: 0.5s; font-size: 50px; }
        .icon-6 { bottom: 35%; left: 12%; animation-delay: 2.5s; font-size: 65px; }
        .icon-7 { top: 60%; right: 15%; animation-delay: 3s; font-size: 45px; }
        .icon-8 { bottom: 50%; left: 85%; animation-delay: 1.8s; font-size: 55px; animation-name: floatReverse; }

        .login-container {
            max-width: 460px;
            width: 100%;
            background: rgba(255, 255, 255, 0.98);
            border-radius: 40px;
            padding: 50px 42px;
            box-shadow: 0 30px 60px -20px rgba(0,0,0,0.3);
            animation: fadeInUp 0.6s ease;
            position: relative;
            z-index: 10;
            backdrop-filter: blur(2px);
            border: 1px solid rgba(255,255,255,0.2);
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Decorative corners */
        .login-container::before {
            content: '';
            position: absolute;
            top: 20px;
            left: 20px;
            width: 80px;
            height: 80px;
            border-top: 3px solid #ff6b35;
            border-left: 3px solid #ff6b35;
            border-radius: 20px 0 0 0;
            pointer-events: none;
            opacity: 0.4;
        }

        .login-container::after {
            content: '';
            position: absolute;
            bottom: 20px;
            right: 20px;
            width: 80px;
            height: 80px;
            border-bottom: 3px solid #ff6b35;
            border-right: 3px solid #ff6b35;
            border-radius: 0 0 20px 0;
            pointer-events: none;
            opacity: 0.4;
        }

        .logo {
            text-align: center;
            margin-bottom: 35px;
        }

        .logo-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #ff6b35, #ff8c42);
            border-radius: 28px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            box-shadow: 0 15px 30px rgba(255,107,53,0.3);
            transition: transform 0.3s;
        }

        .logo-icon:hover {
            transform: scale(1.05);
        }

        .logo-icon i {
            font-size: 42px;
            color: white;
        }

        .logo h1 {
            font-size: 2rem;
            font-weight: 800;
            background: linear-gradient(135deg, #1a1a2e, #2d2d44);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 8px;
        }

        .logo p {
            color: #6c757d;
            font-size: 0.9rem;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-group label {
            display: block;
            font-size: 0.8rem;
            font-weight: 600;
            margin-bottom: 8px;
            color: #1a1a2e;
            letter-spacing: 0.3px;
        }

        .input-wrapper {
            position: relative;
            transition: all 0.2s;
        }

        .input-wrapper i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #adb5bd;
            font-size: 18px;
            transition: all 0.2s;
            z-index: 1;
        }

        .input-wrapper input {
            width: 100%;
            padding: 16px 18px 16px 48px;
            border: 2px solid #e9ecef;
            border-radius: 16px;
            font-size: 0.95rem;
            font-family: 'Inter', sans-serif;
            transition: all 0.2s;
            background: #f8f9fa;
        }

        .input-wrapper input:hover {
            border-color: #dee2e6;
            background: white;
        }

        .input-wrapper input:focus {
            outline: none;
            border-color: #ff6b35;
            background: white;
            box-shadow: 0 0 0 4px rgba(255,107,53,0.1);
        }

        .input-wrapper input:focus + i {
            color: #ff6b35;
        }

        .btn-login {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, #ff6b35, #ff8c42);
            color: white;
            border: none;
            border-radius: 16px;
            font-size: 1rem;
            font-weight: 700;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 10px;
            box-shadow: 0 8px 20px rgba(255,107,53,0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(255,107,53,0.4);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .register-link {
            text-align: center;
            margin-top: 32px;
            padding-top: 24px;
            border-top: 1px solid #eef2f7;
        }

        .register-link p {
            font-size: 0.85rem;
            color: #6c757d;
        }

        .register-link a {
            color: #ff6b35;
            text-decoration: none;
            font-weight: 700;
            transition: all 0.2s;
            position: relative;
        }

        .register-link a::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: #ff6b35;
            transition: width 0.2s;
        }

        .register-link a:hover::after {
            width: 100%;
        }

        .alert {
            padding: 14px 18px;
            border-radius: 16px;
            font-size: 0.85rem;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: shake 0.3s ease;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        .alert-success {
            background: #e8f5e9;
            color: #2e7d32;
            border-left: 4px solid #28a745;
        }

        .alert-danger {
            background: #ffebee;
            color: #c62828;
            border-left: 4px solid #dc3545;
        }

        @media (max-width: 480px) {
            .login-container {
                padding: 40px 28px;
                border-radius: 32px;
            }
            .floating-icon {
                display: none;
            }
            .login-container::before,
            .login-container::after {
                width: 50px;
                height: 50px;
            }
        }
    </style>
</head>
<body>

<!-- Decorative Floating Icons -->
<i class="fas fa-bread-slice floating-icon icon-1"></i>
<i class="fas fa-cake floating-icon icon-2"></i>
<i class="fas fa-cookie-bite floating-icon icon-3"></i>
<i class="fas fa-mug-hot floating-icon icon-4"></i>
<i class="fas fa-croissant floating-icon icon-5"></i>
<i class="fas fa-cupcake floating-icon icon-6"></i>
<i class="fas fa-donut floating-icon icon-7"></i>
<i class="fas fa-ice-cream floating-icon icon-8"></i>

<div class="login-container">
    <div class="logo">
        <div class="logo-icon">
            <i class="fas fa-bread-slice"></i>
        </div>
        <h1>Welcome Back!</h1>
        <p>Sign in to continue your sweet journey</p>
    </div>

    <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-circle" style="font-size: 18px;"></i>
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success">
            <i class="fas fa-check-circle" style="font-size: 18px;"></i>
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('/customer/auth/doLogin') ?>" method="post">
        <div class="form-group">
            <label>Email Address</label>
            <div class="input-wrapper">
                <i class="fas fa-envelope"></i>
                <input type="email" name="email" placeholder="Enter your email address" required>
            </div>
        </div>

        <div class="form-group">
            <label>Password</label>
            <div class="input-wrapper">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" placeholder="Enter your password" required>
            </div>
        </div>

        <button type="submit" class="btn-login">
            <span>Sign In</span>
            <i class="fas fa-arrow-right"></i>
        </button>
    </form>

    <div class="register-link">
        <p>Don't have an account? <a href="<?= base_url('/customer/register') ?>">Create an account</a></p>
    </div>
</div>

</body>
</html>