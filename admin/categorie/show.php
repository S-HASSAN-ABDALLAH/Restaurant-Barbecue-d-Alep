<?php 
require_once "../include/auth.php";  
requireLogin();    

require_once(__DIR__ . "/../config/database.php");


if (isset($_GET["action"]) && $_GET["action"] === "supprimer" && isset($_GET["id"])) {
    $id = (int) $_GET["id"];
    $stmt = $pdo->prepare("DELETE FROM categories WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: show.php?message=deleted");
    exit;
}


$stmt = $pdo->query("SELECT * FROM categories ORDER BY display_order ASC");
$categories = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Catégories</title>
</head>
<body>
    <?php include "../include/sidebar.php"; ?>

<div class="main-content">
    
    <div class="container py-5">
        <h1>Gestion des catégories</h1>
        
        <?php if (isset($_GET["message"])): ?>
<script>
    Swal.fire({
        icon: 'success',
        title: 'Succès!',
        text: '<?php 
            if ($_GET["message"] === "deleted") echo "Catégorie supprimée avec succès!";
            elseif ($_GET["message"] === "success") echo "Catégorie ajoutée avec succès!";
            elseif ($_GET["message"] === "updated") echo "Catégorie modifiée avec succès!";
        ?>',
        confirmButtonColor: '#D4A853'
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

                        <button type="button" 
                         class="btn btn-sm btn-danger btn-delete" 
                        data-id="<?= $categorie["id"] ?>"
                        data-name="<?= htmlspecialchars($categorie["name"]) ?>">
                        <i class="fas fa-trash"></i> Supprimer
                        </button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    </div><!-- end main-content -->

    <script>
// SweetAlert Delete Confirmation
document.querySelectorAll('.btn-delete').forEach(button => {
    button.addEventListener('click', function() {
        const id = this.dataset.id;
        const name = this.dataset.name;
        
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
                window.location.href = `show.php?action=supprimer&id=${id}`;
            }
        });
    });
});
</script>
</body>
</html>
