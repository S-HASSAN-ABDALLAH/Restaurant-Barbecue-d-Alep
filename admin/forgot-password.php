<?php
session_start();
require_once(__DIR__ . "/../config/database.php");

$error = "";
$success = "";
$step = 1; // 1 = email, 2 = question, 3 = new password
$question = "";
$email = "";

// Step 1: التحقق من الإيميل
if (isset($_POST['check_email'])) {
    $email = trim($_POST['email']);
    
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    
    if ($user && $user['security_question']) {
        $step = 2;
        $question = $user['security_question'];
        $_SESSION['reset_user_id'] = $user['id'];
        $_SESSION['reset_email'] = $email;
    } else {
        $error = "Email introuvable ou pas de question de sécurité.";
    }
}

// Step 2: التحقق من الجواب
if (isset($_POST['check_answer'])) {
    $answer = strtolower(trim($_POST['answer']));
    $user_id = $_SESSION['reset_user_id'] ?? 0;
    
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch();
    
    if ($user && strtolower($user['security_answer']) === $answer) {
        $step = 3;
        $_SESSION['reset_verified'] = true;
    } else {
        $step = 2;
        $question = $user['security_question'];
        $error = "Réponse incorrecte.";
    }
}

// Step 3: تغيير كلمة المرور
if (isset($_POST['reset_password'])) {
    if (!isset($_SESSION['reset_verified']) || !$_SESSION['reset_verified']) {
        $error = "Session expirée. Veuillez recommencer.";
        $step = 1;
    } else {
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];
        $user_id = $_SESSION['reset_user_id'];
        
        if (strlen($new_password) < 6) {
            $error = "Le mot de passe doit contenir au moins 6 caractères.";
            $step = 3;
        } elseif ($new_password !== $confirm_password) {
            $error = "Les mots de passe ne correspondent pas.";
            $step = 3;
        } else {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
            $stmt->execute([$hashed_password, $user_id]);
            
            // مسح الـ session
            unset($_SESSION['reset_user_id']);
            unset($_SESSION['reset_email']);
            unset($_SESSION['reset_verified']);
            
            $success = "Mot de passe modifié avec succès!";
            $step = 1;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mot de passe oublié - Barbecue d'Alep</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .reset-card {
            background: white;
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            max-width: 450px;
            width: 100%;
        }
        .reset-card h2 {
            color: #1a1a2e;
            margin-bottom: 30px;
            text-align: center;
        }
        .btn-gold {
            background-color: #D4A853;
            border-color: #D4A853;
            color: #1a1a2e;
            font-weight: 600;
        }
        .btn-gold:hover {
            background-color: #c49a4a;
            border-color: #c49a4a;
            color: #1a1a2e;
        }
        .back-link {
            text-align: center;
            margin-top: 20px;
        }
        .back-link a {
            color: #D4A853;
        }
        .step-indicator {
            text-align: center;
            margin-bottom: 20px;
            color: #666;
        }
        .question-box {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #D4A853;
        }
    </style>
</head>
<body>
    <div class="reset-card">
        <h2>🔐 Mot de passe oublié</h2>
        
        <?php if ($error): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
            <div class="back-link">
                <a href="login.php">← Retour à la connexion</a>
            </div>
        <?php else: ?>
        
            <?php if ($step === 1): ?>
            <!-- Step 1: الإيميل -->
            <p class="step-indicator">Étape 1/3 : Entrez votre email</p>
            <form method="POST">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required autofocus>
                </div>
                <button type="submit" name="check_email" class="btn btn-gold w-100">
                    Continuer
                </button>
            </form>
            
            <?php elseif ($step === 2): ?>
            <!-- Step 2: السؤال السري -->
            <p class="step-indicator">Étape 2/3 : Répondez à la question de sécurité</p>
            <div class="question-box">
                <strong>❓ <?= htmlspecialchars($question) ?></strong>
            </div>
            <form method="POST">
                <div class="mb-3">
                    <label for="answer" class="form-label">Votre réponse</label>
                    <input type="text" class="form-control" id="answer" name="answer" required autofocus>
                </div>
                <button type="submit" name="check_answer" class="btn btn-gold w-100">
                    Vérifier
                </button>
            </form>
            
            <?php elseif ($step === 3): ?>
            <!-- Step 3: كلمة مرور جديدة -->
            <p class="step-indicator">Étape 3/3 : Créez un nouveau mot de passe</p>
            <form method="POST">
                <div class="mb-3">
                    <label for="new_password" class="form-label">Nouveau mot de passe</label>
                    <input type="password" class="form-control" id="new_password" name="new_password" required minlength="6">
                    <small class="text-muted">Minimum 6 caractères</small>
                </div>
                <div class="mb-3">
                    <label for="confirm_password" class="form-label">Confirmer le mot de passe</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                </div>
                <button type="submit" name="reset_password" class="btn btn-gold w-100">
                    Réinitialiser
                </button>
            </form>
            <?php endif; ?>
            
            <div class="back-link">
                <a href="login.php">← Retour à la connexion</a>
            </div>
        
        <?php endif; ?>
    </div>
</body>
</html>
