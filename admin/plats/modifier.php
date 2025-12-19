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


$stmt = $pdo->prepare("SELECT * FROM items WHERE id = ?");
$stmt->execute([$id]);
$plat = $stmt->fetch();


if (!$plat) {
    header("Location: show.php?message=not_found");
    exit;
}


$stmt = $pdo->query("SELECT * FROM categories ORDER BY display_order ASC");
$categories = $stmt->fetchAll();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nom = trim($_POST["name"]);
    $description = trim($_POST["description"]);
    $price = $_POST["price"];
    $id_categorie = $_POST["id_categorie"];
    $subcategory = trim($_POST["subcategory"]);
    
    if (empty($nom)) {
        $erreurs[] = "Le nom est obligatoire";
    }
    if (empty($price) || $price <= 0) {
        $erreurs[] = "Le prix est obligatoire et doit être supérieur à 0";
    }
    if (empty($id_categorie)) {
        $erreurs[] = "La catégorie est obligatoire";
    }
    
    $picture = $plat["picture"];
    if (isset($_FILES["picture"]) && $_FILES["picture"]["error"] === 0) {
        $allowed = ["jpg", "jpeg", "png", "webp"];
        $filename = $_FILES["picture"]["name"];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        
        if (in_array($ext, $allowed)) {
            $newFilename = uniqid() . "." . $ext;
            $destination = "../../uploads/" . $newFilename;
            
            if (move_uploaded_file($_FILES["picture"]["tmp_name"], $destination)) {
                if (!empty($plat["picture"]) && file_exists("../../uploads/" . $plat["picture"])) {
                    unlink("../../uploads/" . $plat["picture"]);
                }
                $picture = $newFilename;
            } else {
                $erreurs[] = "Erreur lors de l'upload de l'image";
            }
        } else {
            $erreurs[] = "Format d'image non autorisé (jpg, jpeg, png, webp)";
        }
    }
    
    if (empty($erreurs)) {
        try {
            $stmt = $pdo->prepare("UPDATE items SET name = ?, description = ?, price = ?, picture = ?, id_categorie = ?, subcategory = ? WHERE id = ?");
            $stmt->execute([$nom, $description, $price, $picture, $id_categorie, $subcategory, $id]);
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
    <title>Modifier un plat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include "../include/sidebar.php"; ?>

<div class="main-content">
    
    <div class="container py-5">
        <h1>Modifier le plat</h1>
        
        <?php if (!empty($erreurs)): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach ($erreurs as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        
        <form method="POST" enctype="multipart/form-data">
            <!-- Nom -->
            <div class="mb-3">
                <label for="name" class="form-label">Nom du plat *</label>
                <input type="text" class="form-control" id="name" name="name" 
                       value="<?= htmlspecialchars($_POST['name'] ?? $plat['name']) ?>" required>
            </div>
            
            <!-- Description -->
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3"><?= htmlspecialchars($_POST['description'] ?? $plat['description']) ?></textarea>
            </div>
            
            <!-- Prix -->
            <div class="mb-3">
                <label for="price" class="form-label">Prix (€) *</label>
                <input type="number" class="form-control" id="price" name="price" step="0.01" min="0"
                       value="<?= htmlspecialchars($_POST['price'] ?? $plat['price']) ?>" required>
            </div>
            
            <!-- Catégorie -->
            <div class="mb-3">
                <label for="id_categorie" class="form-label">Catégorie *</label>
                <select class="form-select" id="id_categorie" name="id_categorie" required>
                    <option value="">-- Choisir une catégorie --</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat['id'] ?>" <?= (($_POST['id_categorie'] ?? $plat['id_categorie']) == $cat['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($cat['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
        
            <div class="mb-3">
                <label for="subcategory" class="form-label">Sous-catégorie</label>
                <select class="form-select" id="subcategory" name="subcategory">
                    <option value="">-- Aucune --</option>
                    <option value="Desserts" <?= (($_POST['subcategory'] ?? $plat['subcategory']) == 'Desserts') ? 'selected' : '' ?>>Desserts</option>
                    <option value="Boissons" <?= (($_POST['subcategory'] ?? $plat['subcategory']) == 'Boissons') ? 'selected' : '' ?>>Boissons</option>
                    <option value="Boissons Chaudes" <?= (($_POST['subcategory'] ?? $plat['subcategory']) == 'Boissons Chaudes') ? 'selected' : '' ?>>Boissons Chaudes</option>
                </select>
                <small class="text-muted">Uniquement pour la catégorie "Desserts & Boissons"</small>
            </div>
            
            <!-- Image actuelle -->
            <?php if (!empty($plat["picture"])): ?>
            <div class="mb-3">
                <label class="form-label">Image actuelle</label>
                <div>
                    <img src="../../uploads/<?= htmlspecialchars($plat["picture"]) ?>" 
                         alt="<?= htmlspecialchars($plat["name"]) ?>" 
                         style="width: 100px; height: 100px; object-fit: cover; border-radius: 5px;">
                </div>
            </div>
            <?php endif; ?>
            
            <!-- Nouvelle image -->
            <div class="mb-3">
                <label for="picture" class="form-label">Nouvelle image (optionnel)</label>
                <input type="file" class="form-control" id="picture" name="picture" accept="image/*">
                <small class="text-muted">Laissez vide pour garder l'image actuelle</small>
            </div>
            
            <button type="submit" class="btn btn-primary">Modifier</button>
            <a href="show.php" class="btn btn-secondary">Annuler</a>
        </form>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    </div>
</body>
</html>
