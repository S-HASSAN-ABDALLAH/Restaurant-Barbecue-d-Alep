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


$stmt = $pdo->prepare("SELECT * FROM categories WHERE id = ?");
$stmt->execute([$id]);
$categorie = $stmt->fetch();


if (!$categorie) {
    header("Location: show.php?message=not_found");
    exit;
}


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nom = trim($_POST["name"]);
    
    if (empty($nom)) {
        $erreurs[] = "Le nom est obligatoire";
    }
    
    if (empty($erreurs)) {
        try {
            $stmt = $pdo->prepare("UPDATE categories SET name = ? WHERE id = ?");
            $stmt->execute([$nom, $id]);
            header("Location: show.php?message=updated");
            exit;
        } catch(PDOException $e) {
            $erreurs[] = "Erreur lors de la modification : " . $e->getMessage();  
        } 
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier une catégorie</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include "../include/sidebar.php"; ?>

<div class="main-content">
    
    <div class="container py-5">
        <h1>Modifier la catégorie</h1>
        
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
                <label for="name" class="form-label">Nom de la catégorie</label>
                <input type="text" 
                       class="form-control" 
                       id="name" 
                       name="name" 
                       value="<?= htmlspecialchars($_POST['name'] ?? $categorie['name']) ?>">
            </div>
            <button type="submit" class="btn btn-primary">Modifier</button>
            <a href="show.php" class="btn btn-secondary">Annuler</a>
        </form>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    </div>
</body>
</html>
