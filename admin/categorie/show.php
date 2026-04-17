<?php 
require_once "../include/auth.php";  
requireLogin();    
require_once(__DIR__ . "/../../config/database.php");

// Suppression sécurisée via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'supprimer') {
    // Vérification du token CSRF
    if (!isset($_POST['csrf_token']) || !verifyCsrfToken($_POST['csrf_token'])) {
        $_SESSION['flash_message'] = "Token de sécurité invalide";
        $_SESSION['flash_type'] = "danger";
    } else {
        $id = (int) $_POST["id"];
        try {
            $stmt = $pdo->prepare("DELETE FROM categories WHERE id = ?");
            $stmt->execute([$id]);
            $_SESSION['flash_message'] = "Catégorie supprimée avec succès";
            $_SESSION['flash_type'] = "success";
        } catch (PDOException $e) {
            error_log("Erreur suppression catégorie : " . $e->getMessage());
            $_SESSION['flash_message'] = "Erreur lors de la suppression";
            $_SESSION['flash_type'] = "danger";
        }
    }
    header("Location: show.php");
    exit;
}

// Récupérer les catégories
$stmt = $pdo->query("SELECT * FROM categories ORDER BY display_order ASC");
$categories = $stmt->fetchAll();

// Token CSRF
$csrfToken = generateCsrfToken();

// Messages flash
$flashMessage = $_SESSION['flash_message'] ?? '';
$flashType = $_SESSION['flash_type'] ?? 'info';
unset($_SESSION['flash_message'], $_SESSION['flash_type']);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Catégories</title>
</head>
<body>
    <?php include "../include/sidebar.php"; ?>

<div class="main-content">
    
    <div class="container py-5">
        <h1>Gestion des catégories</h1>
        
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

        <?php if (isset($_GET["message"])): ?>
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Succès!',
                    text: '<?php 
                        if ($_GET["message"] === "success") echo "Catégorie ajoutée avec succès!";
                        elseif ($_GET["message"] === "updated") echo "Catégorie modifiée avec succès!";
                    ?>',
                    confirmButtonColor: '#D4A853',
                    timer: 3000
                });
            </script>
        <?php endif; ?>
        
        <a href="ajouter.php" class="btn btn-primary mb-3">
            <i class="fas fa-plus"></i> Ajouter une catégorie
        </a>
        
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nom</th>
                    <th>Date de création</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($categories as $categorie): ?>
                <tr>
                    <td><?= $categorie["id"] ?></td>
                    <td><?= htmlspecialchars($categorie["name"]) ?></td>
                    <td><?= date("d/m/Y", strtotime($categorie["created_at"])) ?></td>
                    <td>
                        <a href="modifier.php?id=<?= $categorie["id"] ?>" class="btn btn-sm btn-warning">
                            <i class="fas fa-edit"></i> Modifier
                        </a>

                        <form method="POST" class="d-inline delete-form" data-name="<?= htmlspecialchars($categorie["name"]) ?>">
                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
                            <input type="hidden" name="action" value="supprimer">
                            <input type="hidden" name="id" value="<?= $categorie["id"] ?>">
                            <button type="button" class="btn btn-sm btn-danger btn-delete">
                                <i class="fas fa-trash"></i> Supprimer
                            </button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</div>

<script>
// Confirmation de suppression sécurisée
document.querySelectorAll('.btn-delete').forEach(button => {
    button.addEventListener('click', function() {
        const form = this.closest('.delete-form');
        const name = form.dataset.name;
        
        Swal.fire({
            title: 'Êtes-vous sûr?',
            text: `Voulez-vous supprimer la catégorie "${name}"?`,
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