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

$stmt = $pdo->prepare("SELECT * FROM special_offers WHERE id = ?");
$stmt->execute([$id]);
$offer = $stmt->fetch();

if (!$offer) {
    header("Location: show.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = trim($_POST["title"]);
    $description = trim($_POST["description"]);
    $price = $_POST["price"];
    $savings = trim($_POST["savings"]);
    $is_active = isset($_POST["is_active"]) ? 1 : 0;
    
    if (empty($title)) {
        $erreurs[] = "Le titre est obligatoire";
    }
    if (empty($price) || $price <= 0) {
        $erreurs[] = "Le prix est obligatoire";
    }
    
    if (empty($erreurs)) {
        try {
            $stmt = $pdo->prepare("UPDATE special_offers SET title = ?, description = ?, price = ?, savings = ?, is_active = ? WHERE id = ?");
            $stmt->execute([$title, $description, $price, $savings, $is_active, $id]);
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
    <title>Modifier offre spéciale</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
   <?php include "../include/sidebar.php"; ?>

<div class="main-content">
    
    <div class="container py-5">
        <h1>Modifier l'offre spéciale</h1>
        
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
                <label for="title" class="form-label">Titre *</label>
                <input type="text" class="form-control" id="title" name="title" 
                       value="<?= htmlspecialchars($_POST['title'] ?? $offer['title']) ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="2"><?= htmlspecialchars($_POST['description'] ?? $offer['description']) ?></textarea>
            </div>
            
            <div class="mb-3">
                <label for="price" class="form-label">Prix (€) *</label>
                <input type="number" class="form-control" id="price" name="price" step="0.01" min="0"
                       value="<?= htmlspecialchars($_POST['price'] ?? $offer['price']) ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="savings" class="form-label">Économie</label>
                <input type="text" class="form-control" id="savings" name="savings" 
                       value="<?= htmlspecialchars($_POST['savings'] ?? $offer['savings']) ?>">
            </div>
            
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="is_active" name="is_active" 
                       <?= ($_POST['is_active'] ?? $offer['is_active']) ? 'checked' : '' ?>>
                <label class="form-check-label" for="is_active">Offre active</label>
            </div>
            
            <button type="submit" class="btn btn-primary">Modifier</button>
            <a href="show.php" class="btn btn-secondary">Annuler</a>
        </form>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    </div>
</body>
</html>
