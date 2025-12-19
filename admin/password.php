<?php
require_once 'include/auth.php';
require_once(__DIR__ . "/../config/database.php");
requireLogin();

$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $currentPassword = $_POST['current_password'] ?? '';
    $newPassword = $_POST['new_password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';
    
    // التحقق من الحقول
    if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
        $error = 'Veuillez remplir tous les champs.';
    } 
    elseif ($newPassword !== $confirmPassword) {
        $error = 'Les nouveaux mots de passe ne correspondent pas.';
    }
    elseif (strlen($newPassword) < 6) {
        $error = 'Le mot de passe doit contenir au moins 6 caractères.';
    }
    else {
        // جلب كلمة المرور الحالية من قاعدة البيانات
        $stmt = $pdo->prepare("SELECT password FROM users WHERE id = ?");
        $stmt->execute([$_SESSION['admin_id']]);
        $user = $stmt->fetch();
        
        // التحقق من كلمة المرور الحالية
        if (!password_verify($currentPassword, $user['password'])) {
            $error = 'Mot de passe actuel incorrect.';
        } else {
            // تشفير وحفظ كلمة المرور الجديدة
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
            $stmt->execute([$hashedPassword, $_SESSION['admin_id']]);
            
            $message = 'Mot de passe modifié avec succès!';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Changer mot de passe - Barbecue d'Alep</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'include/sidebar.php'; ?>
    
    <div class="main-content">
        <h1 class="mb-4">🔐 Changer le mot de passe</h1>
        
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        
                        <?php if ($message): ?>
                            <div class="alert alert-success"><?= htmlspecialchars($message) ?></div>
                        <?php endif; ?>
                        
                        <?php if ($error): ?>
                            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                        <?php endif; ?>
                        
                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label">Mot de passe actuel</label>
                                <input type="password" name="current_password" class="form-control" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Nouveau mot de passe</label>
                                <input type="password" name="new_password" class="form-control" required>
                                <small class="text-muted">Minimum 6 caractères</small>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Confirmer le nouveau mot de passe</label>
                                <input type="password" name="confirm_password" class="form-control" required>
                            </div>
                            
                            <button type="submit" class="btn btn-primary">Modifier</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
