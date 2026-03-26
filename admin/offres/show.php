<?php 
require_once "../include/auth.php";  
requireLogin();  

require_once(__DIR__ . "/../config/database.php");

// Suppression sécurisée via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'supprimer') {
    // Vérification du token CSRF
    if (!isset($_POST['csrf_token']) || !verifyCsrfToken($_POST['csrf_token'])) {
        $_SESSION['flash_message'] = "Token de sécurité invalide";
        $_SESSION['flash_type'] = "danger";
    } else {
        $id = (int) $_POST["id"];
        try {
            $stmt = $pdo->prepare("DELETE FROM special_offers WHERE id = ?");
            $stmt->execute([$id]);
            $_SESSION['flash_message'] = "Offre supprimée avec succès";
            $_SESSION['flash_type'] = "success";
        } catch (PDOException $e) {
            error_log("Erreur suppression offre : " . $e->getMessage());
            $_SESSION['flash_message'] = "Erreur lors de la suppression";
            $_SESSION['flash_type'] = "danger";
        }
    }
    header("Location: show.php");
    exit;
}

// Récupérer les offres
$stmt = $pdo->query("SELECT * FROM special_offers ORDER BY id ASC");
$offers = $stmt->fetchAll();

// Token CSRF pour les formulaires
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
    <title>Gestion des Offres Spéciales</title>
</head>
<body>
    <?php include "../include/sidebar.php"; ?>

<div class="main-content">
    
    <div class="container py-5">
        <h1>Gestion des Offres Spéciales</h1>
        
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
                        if ($_GET["message"] === "success") echo "Offre ajoutée avec succès!";
                        elseif ($_GET["message"] === "updated") echo "Offre modifiée avec succès!";
                    ?>',
                    confirmButtonColor: '#D4A853',
                    timer: 3000
                });
            </script>
        <?php endif; ?>
        
        <a href="ajouter.php" class="btn btn-primary mb-3">
            <i class="fas fa-plus"></i> Ajouter une offre
        </a>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Titre</th>
                    <th>Prix</th>
                    <th>Économie</th>
                    <th>Actif</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($offers as $offer): ?>
                <tr>
                    <td><?= $offer["id"] ?></td>
                    <td><?= htmlspecialchars($offer["title"]) ?></td>
                    <td><?= number_format($offer["price"], 2) ?> €</td>
                    <td><?= htmlspecialchars($offer["savings"]) ?></td>
                    <td>
                        <?php if ($offer["is_active"]): ?>
                            <span class="badge bg-success">Oui</span>
                        <?php else: ?>
                            <span class="badge bg-secondary">Non</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="modifier.php?id=<?= $offer["id"] ?>" class="btn btn-sm btn-warning">
                            <i class="fas fa-edit"></i> Modifier
                        </a>

                        <form method="POST" class="d-inline delete-form" data-name="<?= htmlspecialchars($offer["title"]) ?>">
                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
                            <input type="hidden" name="action" value="supprimer">
                            <input type="hidden" name="id" value="<?= $offer["id"] ?>">
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
            text: `Voulez-vous supprimer l'offre "${name}"?`,
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