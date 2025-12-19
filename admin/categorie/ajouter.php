<?php 
require_once "../include/auth.php";  
requireLogin();
require_once(__DIR__ . "/../config/database.php");

$erreurs = [];
$success = false;

// Traitement du formulaire
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    // Vérification du token CSRF
    if (!isset($_POST['csrf_token']) || !verifyCsrfToken($_POST['csrf_token'])) {
        $erreurs[] = "Token de sécurité invalide. Veuillez réessayer.";
    } else {
        $nom = trim($_POST["name"] ?? '');
        
        // Validation
        if (empty($nom)) {
            $erreurs[] = "Le nom de la catégorie est obligatoire";
        } elseif (strlen($nom) < 2) {
            $erreurs[] = "Le nom doit contenir au moins 2 caractères";
        } elseif (strlen($nom) > 100) {
            $erreurs[] = "Le nom ne peut pas dépasser 100 caractères";
        }
        
        // Vérifier si la catégorie existe déjà
        if (empty($erreurs)) {
            try {
                $checkStmt = $pdo->prepare("SELECT COUNT(*) FROM categories WHERE name = ?");
                $checkStmt->execute([$nom]);
                if ($checkStmt->fetchColumn() > 0) {
                    $erreurs[] = "Cette catégorie existe déjà";
                }
            } catch(PDOException $e) {
                error_log("Erreur vérification catégorie : " . $e->getMessage());
                $erreurs[] = "Erreur lors de la vérification";
            }
        }
        
        // Insertion si pas d'erreurs
        if (empty($erreurs)) {
            try {
                $stmt = $pdo->prepare("INSERT INTO categories (name, created_at) VALUES (?, NOW())");
                $stmt->execute([$nom]);
                
                // Redirection avec message de succès
                $_SESSION['flash_message'] = "Catégorie ajoutée avec succès !";
                $_SESSION['flash_type'] = "success";
                header("Location: show.php");
                exit;
                
            } catch(PDOException $e) {
                error_log("Erreur création catégorie : " . $e->getMessage());
                $erreurs[] = "Erreur lors de la création de la catégorie";
            }
        }
    }
}

// Générer un nouveau token CSRF
$csrfToken = generateCsrfToken();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une catégorie - Barbecue d'Alep</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }
        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <?php include "../include/sidebar.php"; ?>
    
    <div class="main-content">
        <div class="container py-5">
            <div class="row">
                <div class="col-md-8 col-lg-6 mx-auto">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h1>Ajouter une catégorie</h1>
                        <a href="show.php" class="btn btn-outline-secondary">← Retour</a>
                    </div>
                    
                    <?php if (!empty($erreurs)): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
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
                            <form method="POST" action="">
                                <!-- Token CSRF -->
                                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
                                
                                <div class="mb-3">
                                    <label for="name" class="form-label">
                                        Nom de la catégorie <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control <?= !empty($erreurs) ? 'is-invalid' : '' ?>" 
                                           id="name" 
                                           name="name" 
                                           placeholder="Ex: Grillades, Entrées, Desserts..."
                                           maxlength="100"
                                           value="<?= htmlspecialchars($_POST['name'] ?? '') ?>"
                                           required
                                           autofocus>
                                    <div class="form-text">
                                        2 à 100 caractères
                                    </div>
                                </div>
                                
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        ✓ Créer la catégorie
                                    </button>
                                    <a href="show.php" class="btn btn-secondary">
                                        Annuler
                                    </a>
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
