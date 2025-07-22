<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Kontrol Kontrak RS</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-form {
            width: 100%;
            max-width: 400px;
            padding: 15px;
            margin: auto;
        }
        .login-form .form-control {
            position: relative;
            box-sizing: border-box;
            height: auto;
            padding: 10px;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <div class="login-form">
        <form action="<?= BASE_URL ?>/authenticate" method="POST" class="bg-white p-5 rounded shadow">
            <div class="text-center mb-4">
                <i class="bi bi-hospital" style="font-size: 3rem; color: #007bff;"></i>
                <h1 class="h3 mb-3 font-weight-normal">Sistem Kontrol Kontrak RS</h1>
            </div>
            
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger">
                    <?= $_SESSION['error'] ?>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>
            
            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success">
                    <?= $_SESSION['success'] ?>
                </div>
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>
            
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" required autofocus>
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            
            <button class="btn btn-lg btn-primary btn-block" type="submit">
                <i class="bi bi-box-arrow-in-right"></i> Login
            </button>
            
            <p class="mt-3 mb-3 text-muted text-center">© 2024</p>
        </form>
    </div>
</body>
</html>