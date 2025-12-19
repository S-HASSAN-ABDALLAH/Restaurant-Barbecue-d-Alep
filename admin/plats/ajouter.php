<?php 
require_once "../include/auth.php";  
requireLogin();
require_once(__DIR__ . "/../config/database.php");

$erreurs = [];

// Définir le chemin uploads de manière absolue
define('UPLOAD_DIR', dirname(dirname(__DIR__)) . '/uploads/');
define('UPLOAD_URL', '/uploads/');

// Récupérer les catégories
$stmt = $pdo->query("SELECT * FROM categories ORDER BY display_order ASC");
$categories = $stmt->fetchAll();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    // Vérification du token CSRF
    if (!isset($_POST['csrf_token']) || !verifyCsrfToken($_POST['csrf_token'])) {
        $erreurs[] = "Token de sécurité invalide. Veuillez réessayer.";
    } else {
        // Récupération et nettoyage des données
        $nom = trim($_POST["name"] ?? '');
        $description = trim($_POST["description"] ?? '');
        $price = $_POST["price"] ?? 0;
        $id_categorie = $_POST["id_categorie"] ?? 0;
        $subcategory = trim($_POST["subcategory"] ?? '');
        
        // Validation
        if (empty($nom)) {
            $erreurs[] = "Le nom du plat est obligatoire";
        } elseif (strlen($nom) < 2 || strlen($nom) > 255) {
            $erreurs[] = "Le nom doit contenir entre 2 et 255 caractères";
        }
        
        if (empty($price) || $price <= 0) {
            $erreurs[] = "Le prix doit être supérieur à 0";
        }
        
        if (empty($id_categorie)) {
            $erreurs[] = "La catégorie est obligatoire";
        }
        
        // ===== TRAITEMENT SÉCURISÉ DE L'IMAGE =====
        $picture = "";
        if (isset($_FILES["picture"]) && $_FILES["picture"]["error"] === UPLOAD_ERR_OK) {
            
            // Vérifier la taille (max 5MB)
            $maxSize = 5 * 1024 * 1024; // 5MB
            if ($_FILES["picture"]["size"] > $maxSize) {
                $erreurs[] = "L'image ne doit pas dépasser 5 MB";
            }
            
            // Vérifier le type MIME réel du fichier
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mimeType = finfo_file($finfo, $_FILES["picture"]["tmp_name"]);
            finfo_close($finfo);
            
            $allowedMimes = ['image/jpeg', 'image/png', 'image/webp', 'image/jpg'];
            if (!in_array($mimeType, $allowedMimes)) {
                $erreurs[] = "Format d'image non autorisé. Utilisez JPG, PNG ou WebP uniquement";
            }
            
            // Vérifier l'extension
            $ext = strtolower(pathinfo($_FILES["picture"]["name"], PATHINFO_EXTENSION));
            $allowedExts = ['jpg', 'jpeg', 'png', 'webp'];
            if (!in_array($ext, $allowedExts)) {
                $erreurs[] = "Extension de fichier non autorisée";
            }
            
            // Si pas d'erreurs, traiter l'upload
            if (empty($erreurs)) {
                // Générer un nom unique et sécurisé
                $newFilename = uniqid('plat_', true) . '.' . $ext;
                $destination = UPLOAD_DIR . $newFilename;
                
                // Créer le dossier uploads s'il n'existe pas
                if (!is_dir(UPLOAD_DIR)) {
                    mkdir(UPLOAD_DIR, 0755, true);
                }
                
                // Déplacer le fichier
                if (move_uploaded_file($_FILES["picture"]["tmp_name"], $destination)) {
                    // Redimensionner l'image pour optimiser (optionnel mais recommandé)
                    // resizeImage($destination, 800, 600); // Fonction à créer si besoin
                    
                    $picture = $newFilename;
                } else {
                    $erreurs[] = "Erreur lors de l'upload de l'image";
                }
            }
        }
        
        // Insertion dans la base de données
        if (empty($erreurs)) {
            try {
                $stmt = $pdo->prepare(
                    "INSERT INTO items (name, description, price, picture, id_categorie, subcategory, created_at) 
                     VALUES (?, ?, ?, ?, ?, ?, NOW())"
                );
                $stmt->execute([$nom, $description, $price, $picture, $id_categorie, $subcategory]);
                
                $_SESSION['flash_message'] = "Plat ajouté avec succès !";
                $_SESSION['flash_type'] = "success";
                header("Location: show.php");
                exit;
                
            } catch(PDOException $e) {
                error_log("Erreur création plat : " . $e->getMessage());
                $erreurs[] = "Erreur lors de la création du plat";
            }
        }
    }
}

$csrfToken = generateCsrfToken();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un plat - Barbecue d'Alep</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include "../include/sidebar.php"; ?>

    <div class="main-content">
        <div class="container py-5">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h1>Ajouter un plat</h1>
                        <a href="show.php" class="btn btn-outline-secondary">← Retour</a>
                    </div>
                    
                    <?php if (!empty($erreurs)): ?>
                        <div class="alert alert-danger alert-dismissible fade show">
                            <strong>Erreur !</strong>
                            <ul class="mb-0 mt-2">
                                <?php foreach ($erreurs as $error): ?>
                                    <li><?= htmlspecialchars($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>
                    
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <form method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
                                
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nom du plat <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="name" name="name" 
                                           value="<?= htmlspecialchars($_POST['name'] ?? '') ?>" 
                                           maxlength="255" required autofocus>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control" id="description" name="description" 
                                              rows="3" maxlength="1000"><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>
                                    <div class="form-text">Maximum 1000 caractères</div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="price" class="form-label">Prix (€) <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="price" name="price" 
                                               step="0.01" min="0" max="9999.99"
                                               value="<?= htmlspecialchars($_POST['price'] ?? '') ?>" required>
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="id_categorie" class="form-label">Catégorie <span class="text-danger">*</span></label>
                                        <select class="form-select" id="id_categorie" name="id_categorie" required>
                                            <option value="">-- Choisir --</option>
                                            <?php foreach ($categories as $cat): ?>
                                                <option value="<?= $cat['id'] ?>" 
                                                        <?= (isset($_POST['id_categorie']) && $_POST['id_categorie'] == $cat['id']) ? 'selected' : '' ?>>
                                                    <?= htmlspecialchars($cat['name']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="subcategory" class="form-label">Sous-catégorie (optionnel)</label>
                                    <select class="form-select" id="subcategory" name="subcategory">
                                        <option value="">-- Aucune --</option>
                                        <option value="Desserts" <?= (isset($_POST['subcategory']) && $_POST['subcategory'] == 'Desserts') ? 'selected' : '' ?>>Desserts</option>
                                        <option value="Boissons" <?= (isset($_POST['subcategory']) && $_POST['subcategory'] == 'Boissons') ? 'selected' : '' ?>>Boissons</option>
                                        <option value="Boissons Chaudes" <?= (isset($_POST['subcategory']) && $_POST['subcategory'] == 'Boissons Chaudes') ? 'selected' : '' ?>>Boissons Chaudes</option>
                                    </select>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="picture" class="form-label">Image du plat</label>
                                    <input type="file" class="form-control" id="picture" name="picture" 
                                           accept="image/jpeg,image/png,image/webp">
                                    <div class="form-text">
                                        Formats : JPG, PNG, WebP | Taille max : 5 MB
                                    </div>
                                </div>
                                
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        ✓ Ajouter le plat
                                    </button>
                                    <a href="show.php" class="btn btn-secondary">Annuler</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
