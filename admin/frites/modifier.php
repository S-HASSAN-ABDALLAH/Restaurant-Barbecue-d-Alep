<?php 
require_once "../include/auth.php"; 

requireLogin();    
require_once(__DIR__ . "/../config/database.php");
$erreurs = [];

if (!isset($_GET["id"])) {
    header("Location: show.php");
    exit;
}

$id = (int) $_GET["id"];

$stmt = $pdo->prepare("SELECT * FROM frites_options WHERE id = ?");
$stmt->execute([$id]);
$frite = $stmt->fetch();

if (!$frite) {
    header("Location: show.php");
    exit;
}

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
            $stmt = $pdo->prepare("UPDATE frites_options SET size = ?, price = ?, display_order = ? WHERE id = ?");
            $stmt->execute([$size, $price, $display_order, $id]);
            header("Location: show.php?message=updated");
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
    <title>Modifier option frites</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include "../include/sidebar.php"; ?>

<div class="main-content">
    
    <div class="container py-5">
        <h1>Modifier l'option frites</h1>
        
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
                       value="<?= htmlspecialchars($_POST['size'] ?? $frite['size']) ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="price" class="form-label">Prix (€) *</label>
                <input type="number" class="form-control" id="price" name="price" step="0.01" min="0"
                       value="<?= htmlspecialchars($_POST['price'] ?? $frite['price']) ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="display_order" class="form-label">Ordre d'affichage</label>
                <input type="number" class="form-control" id="display_order" name="display_order" 
                       value="<?= htmlspecialchars($_POST['display_order'] ?? $frite['display_order']) ?>">
            </div>
            
            <button type="submit" class="btn btn-primary">Modifier</button>
            <a href="show.php" class="btn btn-secondary">Annuler</a>
        </form>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    </div>
</body>
</html>
