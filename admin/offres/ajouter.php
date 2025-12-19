<?php 
require_once "../include/auth.php";  
requireLogin();    

require_once(__DIR__ . "/../config/database.php");
$erreurs = [];

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
            $stmt = $pdo->prepare("INSERT INTO special_offers (title, description, price, savings, is_active) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$title, $description, $price, $savings, $is_active]);
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
    <title>Ajouter une offre spéciale</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include "../include/sidebar.php"; ?>

<div class="main-content">
    
    <div class="container py-5">
        <h1>Ajouter une offre spéciale</h1>
        
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
                       value="<?= htmlspecialchars($_POST['title'] ?? '') ?>" required>
                <small class="text-muted">Ex: SANDWICH + FRITES + BOISSON</small>
            </div>
            
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="2"><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>
            </div>
            
            <div class="mb-3">
                <label for="price" class="form-label">Prix (€) *</label>
                <input type="number" class="form-control" id="price" name="price" step="0.01" min="0"
                       value="<?= htmlspecialchars($_POST['price'] ?? '') ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="savings" class="form-label">Économie</label>
                <input type="text" class="form-control" id="savings" name="savings" 
                       value="<?= htmlspecialchars($_POST['savings'] ?? '') ?>">
                <small class="text-muted">Ex: Économisez 2€</small>
            </div>
            
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="is_active" name="is_active" 
                       <?= (isset($_POST['is_active']) || !isset($_POST['title'])) ? 'checked' : '' ?>>
                <label class="form-check-label" for="is_active">Offre active</label>
            </div>
            
            <button type="submit" class="btn btn-primary">Ajouter</button>
            <a href="show.php" class="btn btn-secondary">Annuler</a>
        </form>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
 </div>   
</body>
</html>
