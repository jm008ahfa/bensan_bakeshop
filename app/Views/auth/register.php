<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Bensan Bakeshop</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
        }

        .register-container {
            max-width: 450px;
            width: 100%;
            background: white;
            border-radius: 32px;
            padding: 48px 42px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .logo {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #28a745, #20c997);
            border-radius: 28px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            box-shadow: 0 15px 30px rgba(40,167,69,0.3);
        }

        .logo-icon i {
            font-size: 42px;
            color: white;
        }

        .logo h1 {
            font-size: 2rem;
            font-weight: 800;
            color: #1a1a2e;
            margin-bottom: 8px;
        }

        .logo p {
            color: #6c757d;
            font-size: 0.9rem;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 0.8rem;
            color: #1a1a2e;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #adb5bd;
        }

        .input-wrapper input {
            width: 100%;
            padding: 14px 18px 14px 48px;
            border: 2px solid #e9ecef;
            border-radius: 16px;
            font-size: 0.95rem;
            font-family: 'Inter', sans-serif;
            transition: all 0.2s;
            background: #f8f9fa;
        }

        .input-wrapper input:focus {
            outline: none;
            border-color: #28a745;
            box-shadow: 0 0 0 4px rgba(40,167,69,0.1);
        }

        .btn-register {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            border: none;
            border-radius: 16px;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            margin-top: 10px;
            transition: all 0.2s;
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(40,167,69,0.3);
        }

        .login-link {
            text-align: center;
            margin-top: 28px;
            padding-top: 24px;
            border-top: 1px solid #eef2f7;
        }

        .login-link a {
            color: #28a745;
            text-decoration: none;
            font-weight: 700;
        }

        .alert {
            padding: 12px 16px;
            border-radius: 12px;
            font-size: 0.8rem;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .alert-danger {
            background: #ffebee;
            color: #c62828;
            border-left: 4px solid #dc3545;
        }

        .alert-success {
            background: #e8f5e9;
            color: #2e7d32;
            border-left: 4px solid #28a745;
        }

        @media (max-width: 480px) {
            .register-container {
                padding: 32px 24px;
            }
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="logo">
            <div class="logo-icon">
                <i class="fas fa-user-plus"></i>
            </div>
            <h1>Create Account</h1>
            <p>Join Bensan Bakeshop management</p>
        </div>

        <?php if(session()->getFlashdata('error')): ?>
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i> <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <?php if(session()->getFlashdata('success')): ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('/auth/doRegister') ?>" method="post">
            <div class="form-group">
                <label>Full Name</label>
                <div class="input-wrapper">
                    <i class="fas fa-user"></i>
                    <input type="text" name="fullname" placeholder="Enter your full name" required>
                </div>
            </div>

            <div class="form-group">
                <label>Username</label>
                <div class="input-wrapper">
                    <i class="fas fa-user-circle"></i>
                    <input type="text" name="username" placeholder="Choose a username" required>
                </div>
            </div>

            <div class="form-group">
                <label>Password</label>
                <div class="input-wrapper">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" placeholder="Create a password (min 6 characters)" required>
                </div>
            </div>

            <button type="submit" class="btn-register">
                <i class="fas fa-check"></i> Create Account
            </button>
        </form>

        <div class="login-link">
            <a href="<?= base_url('/login') ?>">Already have an account? Sign in</a>
        </div>
    </div>
</body>
</html>