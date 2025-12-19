<?php
require_once 'include/auth.php';
require_once(__DIR__ . "/../config/database.php");
requireLogin();

// إحصائيات
$catCount = $pdo->query("SELECT COUNT(*) FROM categories")->fetchColumn();
$platCount = $pdo->query("SELECT COUNT(*) FROM items")->fetchColumn();
$offreCount = $pdo->query("SELECT COUNT(*) FROM special_offers")->fetchColumn();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Barbecue d'Alep</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'include/sidebar.php'; ?>
    
    <div class="main-content">
        <h1 class="mb-4"><i class="fas fa-chart-line"></i> Dashboard</h1>
        
        <div class="row">
            <!-- Catégories -->
            <div class="col-md-4 mb-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h1 class="display-4 text-primary"><?= $catCount ?></h1>
                        <h5><i class="fas fa-folder"></i> Catégories</h5>
                        <a href="categorie/show.php" class="btn btn-outline-primary btn-sm">Voir</a>
                    </div>
                </div>
            </div>
            
            <!-- Plats -->
            <div class="col-md-4 mb-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h1 class="display-4 text-success"><?= $platCount ?></h1>
                        <h5><i class="fas fa-utensils"></i> Plats</h5>
                        <a href="plats/show.php" class="btn btn-outline-success btn-sm">Voir</a>
                    </div>
                </div>
            </div>
            
            <!-- Offres -->
            <div class="col-md-4 mb-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h1 class="display-4 text-warning"><?= $offreCount ?></h1>
                        <h5><i class="fas fa-tags"></i> Offres</h5>
                        <a href="offres/show.php" class="btn btn-outline-warning btn-sm">Voir</a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Bienvenue -->
        <div class="card mt-4">
            <div class="card-body">
                <h5><i class="fas fa-hand-wave"></i> Bienvenue, <?= htmlspecialchars($_SESSION['admin_email']) ?>!</h5>
                <p class="text-muted mb-0">Vous êtes connecté à l'espace d'administration.</p>
            </div>
        </div>
    </div>
</body>
</html>
