<?php 
require_once "../include/auth.php";  

requireLogin();    
require_once(__DIR__ . "/../config/database.php");
$erreurs = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $size = trim($_POST["size"]);
    $price = $_POST["price"];
    $display_order = $_POST["display_order"];
    
    if (empty($size)) {
        $erreurs[] = "La taille est obligatoire";
    }
    if (empty($price) || $price <= 0) {
        $erreurs[] = "Le prix est obligatoire";
    }
    
    if (empty($erreurs)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO frites_options (size, price, display_order) VALUES (?, ?, ?)");
            $stmt->execute([$size, $price, $display_order]);
            header("Location: show.php?message=success");
            exit;
        } catch(PDOException $e) {
            $erreurs[] = "Erreur : " . $e->getMessage();  
        } 
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une option frites</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include "../include/sidebar.php"; ?>

<div class="main-content">
    
    <div class="container py-5">
        <h1>Ajouter une option frites</h1>
        
        <?php if (!empty($erreurs)): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach ($erreurs as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="mb-3">
                <label for="size" class="form-label">Taille *</label>
                <input type="text" class="form-control" id="size" name="size" 
                       value="<?= htmlspecialchars($_POST['size'] ?? '') ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="price" class="form-label">Prix (€) *</label>
                <input type="number" class="form-control" id="price" name="price" step="0.01" min="0"
                       value="<?= htmlspecialchars($_POST['price'] ?? '') ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="display_order" class="form-label">Ordre d'affichage</label>
                <input type="number" class="form-control" id="display_order" name="display_order" 
                       value="<?= htmlspecialchars($_POST['display_order'] ?? '0') ?>">
            </div>
            
            <button type="submit" class="btn btn-primary">Ajouter</button>
            <a href="show.php" class="btn btn-secondary">Annuler</a>
        </form>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    </div>
</body>
</html>
