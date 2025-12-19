<?php

require_once __DIR__ . '/include/auth.php';



// إذا كان مسجل دخوله، أرسله للوحة التحكم
if (isLoggedIn()) {
    header('Location: dashboard.php');
    exit;
}

$error = '';

// عند إرسال النموذج
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if (empty($email) || empty($password)) {
        $error = 'Veuillez remplir tous les champs.';
    } else {
        if (login($email, $password)) {
            header('Location: dashboard.php');
            exit;
        } else {
            $error = 'Email ou mot de passe incorrect.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Barbecue d'Alep</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 400px;
            border: 1px solid rgba(212, 168, 83, 0.3);
        }
        .login-card h2 {
            color: #D4A853;
            text-align: center;
            margin-bottom: 30px;
        }
        .form-control {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(212, 168, 83, 0.3);
            color: white;
            padding: 12px;
        }
        .form-control:focus {
            background: rgba(255, 255, 255, 0.15);
            border-color: #D4A853;
            color: white;
            box-shadow: none;
        }
        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }
        .btn-login {
            background: linear-gradient(135deg, #D4A853, #B8860B);
            border: none;
            padding: 12px;
            font-weight: 600;
            width: 100%;
        }
        .btn-login:hover {
            background: linear-gradient(135deg, #e6b85a, #D4A853);
        }
        .form-label {
            color: white;
        }
        .alert-danger {
            background: rgba(220, 53, 69, 0.2);
            border: 1px solid rgba(220, 53, 69, 0.5);
            color: #ff6b6b;
        }
        .forgot-link {
            text-align: center;
            margin-top: 20px;
        }
        .forgot-link a {
            color: #D4A853;
            text-decoration: none;
        }
        .forgot-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <h2>🔐 Connexion Admin</h2>
        
        <?php if ($error): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" placeholder="admin@barbecue-alep.fr" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Mot de passe</label>
                <input type="password" name="password" class="form-control" placeholder="••••••••" required>
            </div>
            
            <button type="submit" class="btn btn-login text-dark">Se connecter</button>
        </form>
        
        <!-- رابط نسيت كلمة المرور -->
        <div class="forgot-link">
            <a href="forgot-password.php">Mot de passe oublié?</a>
        </div>
    </div>
</body>
</html>
