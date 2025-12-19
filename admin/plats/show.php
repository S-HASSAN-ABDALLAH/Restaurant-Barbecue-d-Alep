<?php
require_once "../include/auth.php";
requireLogin();
require_once(__DIR__ . "/../config/database.php");

// ===== MESSAGES FLASH =====
$flashMessage = $_SESSION['flash_message'] ?? '';
$flashType = $_SESSION['flash_type'] ?? 'info';
unset($_SESSION['flash_message'], $_SESSION['flash_type']);

// ===== RECHERCHE & FILTRAGE =====
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$filterCategory = isset($_GET['category']) ? (int)$_GET['category'] : 0;

// Récupérer toutes les catégories pour le filtre
$stmtCategories = $pdo->query("SELECT * FROM categories ORDER BY display_order ASC");
$allCategories = $stmtCategories->fetchAll();

// ===== PAGINATION =====
$perPage = 10;
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;

// Construction de la requête avec filtres
$whereClause = "WHERE 1=1";
$params = [];

if (!empty($search)) {
    $whereClause .= " AND items.name LIKE :search";
    $params[':search'] = "%$search%";
}

if ($filterCategory > 0) {
    $whereClause .= " AND items.id_categorie = :category";
    $params[':category'] = $filterCategory;
}

// Compter le total d'éléments
$sqlCount = "SELECT COUNT(*) FROM items JOIN categories ON items.id_categorie = categories.id $whereClause";
$stmtCount = $pdo->prepare($sqlCount);
$stmtCount->execute($params);
$totalItems = $stmtCount->fetchColumn();
$totalPages = ceil($totalItems / $perPage);

// Calculer l'offset
$offset = ($page - 1) * $perPage;

// Récupérer les plats
$sql = "
    SELECT items.*, categories.name AS category_name 
    FROM items 
    JOIN categories ON items.id_categorie = categories.id 
    $whereClause
    ORDER BY categories.display_order, items.display_order ASC
    LIMIT :limit OFFSET :offset
";
$stmt = $pdo->prepare($sql);
foreach ($params as $key => $value) {
    $stmt->bindValue($key, $value);
}
$stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$plats = $stmt->fetchAll();

// Construire l'URL de base pour la pagination - CORRECTION ICI
$queryParams = [];
if (!empty($search)) $queryParams['search'] = $search;
if ($filterCategory > 0) $queryParams['category'] = $filterCategory;

// Fonction pour générer les URLs de pagination
function buildPaginationUrl($page, $queryParams) {
    $params = $queryParams;
    $params['page'] = $page;
    return '?' . http_build_query($params);
}

// Générer token CSRF pour les formulaires de suppression
$csrfToken = generateCsrfToken();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Gestion des plats - Barbecue d'Alep</title>
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
        .pagination-info {
            color: #666;
            font-size: 0.9rem;
        }
        .page-link {
            color: #D4A853;
        }
        .page-link:hover {
            color: #c49a4a;
            background-color: #f8f9fa;
        }
        .page-item.active .page-link {
            background-color: #D4A853;
            border-color: #D4A853;
            color: white;
        }
        .search-box {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        .btn-reset {
            background-color: #6c757d;
            border-color: #6c757d;
            color: white;
        }
        .dish-image {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <?php include "../include/sidebar.php"; ?>

    <div class="main-content">
        <div class="container py-5">
            <h1 class="mb-4">Gestion des plats</h1>
            
            <?php if ($flashMessage): ?>
                <script>
                    Swal.fire({
                        icon: '<?= $flashType === 'success' ? 'success' : 'error' ?>',
                        title: '<?= $flashType === 'success' ? 'Succès!' : 'Erreur' ?>',
                        text: '<?= htmlspecialchars($flashMessage, ENT_QUOTES) ?>',
                        confirmButtonColor: '#D4A853',
                        timer: 3000
                    });
                </script>
            <?php endif; ?>
            
            <a href="ajouter.php" class="btn btn-primary mb-3">
                <i class="fas fa-plus"></i> Ajouter un plat
            </a>
            
            <!-- RECHERCHE & FILTRES -->
            <div class="search-box">
                <form method="GET" action="show.php" class="row g-3 align-items-end">
                    <div class="col-md-5">
                        <label for="search" class="form-label">
                            <i class="fas fa-search"></i> Rechercher par nom
                        </label>
                        <input type="text" class="form-control" id="search" name="search"
                               placeholder="Nom du plat..." value="<?= htmlspecialchars($search) ?>">
                    </div>
                    
                    <div class="col-md-4">
                        <label for="category" class="form-label">
                            <i class="fas fa-filter"></i> Filtrer par catégorie
                        </label>
                        <select class="form-select" id="category" name="category">
                            <option value="0">Toutes les catégories</option>
                            <?php foreach ($allCategories as $cat): ?>
                                <option value="<?= $cat['id'] ?>" <?= $filterCategory === (int)$cat['id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($cat['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Rechercher
                        </button>
                        <a href="show.php" class="btn btn-reset">
                            <i class="fas fa-undo"></i> Réinitialiser
                        </a>
                    </div>
                </form>
            </div>
            
            <!-- INFO PAGINATION -->
            <p class="pagination-info mb-3">
                <?php if ($totalItems > 0): ?>
                    Affichage de <?= $offset + 1 ?> à <?= min($offset + $perPage, $totalItems) ?> sur <?= $totalItems ?> plats
                    <?php if (!empty($search) || $filterCategory > 0): ?>
                        <span class="text-muted">
                            (filtré<?= !empty($search) ? " par \"$search\"" : "" ?>)
                        </span>
                    <?php endif; ?>
                <?php else: ?>
                    Aucun plat trouvé
                <?php endif; ?>
            </p>
            
            <!-- TABLE -->
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Nom</th>
                            <th>Catégorie</th>
                            <th>Prix</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($plats) > 0): ?>
                            <?php foreach($plats as $plat): ?>
                            <tr>
                                <td><?= $plat["id"] ?></td>
                                <td>
                                    <?php if (!empty($plat["picture"])): ?>
                                        <img src="/uploads/<?= htmlspecialchars($plat["picture"]) ?>"
                                             alt="<?= htmlspecialchars($plat["name"]) ?>"
                                             class="dish-image">
                                    <?php else: ?>
                                        <span class="text-muted"><i class="fas fa-image"></i></span>
                                    <?php endif; ?>
                                </td>
                                <td><?= htmlspecialchars($plat["name"]) ?></td>
                                <td>
                                    <span class="badge bg-secondary">
                                        <?= htmlspecialchars($plat["category_name"]) ?>
                                    </span>
                                </td>
                                <td><strong><?= number_format($plat["price"], 2) ?> €</strong></td>
                                <td>
                                    <a href="modifier.php?id=<?= $plat["id"] ?>"
                                       class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i> Modifier
                                    </a>
                                    
                                    <!-- Formulaire de suppression caché -->
                                    <form method="POST" action="delete.php"
                                          class="d-inline delete-form"
                                          data-name="<?= htmlspecialchars($plat["name"]) ?>">
                                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
                                        <input type="hidden" name="id" value="<?= $plat["id"] ?>">
                                        <button type="button" class="btn btn-sm btn-danger btn-delete">
                                            <i class="fas fa-trash"></i> Supprimer
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    <i class="fas fa-search fa-2x mb-3"></i>
                                    <p>Aucun plat trouvé</p>
                                    <?php if (!empty($search) || $filterCategory > 0): ?>
                                        <a href="show.php" class="btn btn-sm btn-primary">Réinitialiser les filtres</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            
            <!-- PAGINATION - CORRECTION ICI -->
            <?php if ($totalPages > 1): ?>
            <nav aria-label="Pagination des plats">
                <ul class="pagination justify-content-center">
                    <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                        <a class="page-link" href="<?= buildPaginationUrl($page - 1, $queryParams) ?>">Précédent</a>
                    </li>
                    
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <li class="page-item <?= $i === $page ? 'active' : '' ?>">
                            <a class="page-link" href="<?= buildPaginationUrl($i, $queryParams) ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>
                    
                    <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
                        <a class="page-link" href="<?= buildPaginationUrl($page + 1, $queryParams) ?>">Suivant</a>
                    </li>
                </ul>
            </nav>
            <?php endif; ?>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Confirmation de suppression sécurisée
        document.querySelectorAll('.btn-delete').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const form = this.closest('.delete-form');
                const platName = form.dataset.name;
                
                Swal.fire({
                    title: 'Êtes-vous sûr?',
                    text: `Voulez-vous supprimer "${platName}"?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Oui, supprimer!',
                    cancelButtonText: 'Annuler'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
</body>
</html>
