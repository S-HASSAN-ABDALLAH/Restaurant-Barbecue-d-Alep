<?php
/**
 * Gestion sécurisée de la suppression de plats
 * À utiliser à la place de la suppression via GET
 */
require_once "../include/auth.php";
requireLogin();
require_once(__DIR__ . "/../config/database.php");

// Définir le chemin uploads
define('UPLOAD_DIR', dirname(dirname(__DIR__)) . '/uploads/');

// Seules les requêtes POST sont acceptées
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['flash_message'] = "Méthode non autorisée";
    $_SESSION['flash_type'] = "danger";
    header('Location: show.php');
    exit;
}

// Vérification du token CSRF
if (!isset($_POST['csrf_token']) || !verifyCsrfToken($_POST['csrf_token'])) {
    $_SESSION['flash_message'] = "Token de sécurité invalide";
    $_SESSION['flash_type'] = "danger";
    header('Location: show.php');
    exit;
}

// Vérification de l'ID
if (!isset($_POST['id']) || empty($_POST['id'])) {
    $_SESSION['flash_message'] = "ID manquant";
    $_SESSION['flash_type'] = "danger";
    header('Location: show.php');
    exit;
}

$id = (int) $_POST['id'];

try {
    // Récupérer le plat pour obtenir le nom de l'image
    $stmt = $pdo->prepare("SELECT picture FROM items WHERE id = ?");
    $stmt->execute([$id]);
    $plat = $stmt->fetch();
    
    if (!$plat) {
        $_SESSION['flash_message'] = "Plat introuvable";
        $_SESSION['flash_type'] = "danger";
        header('Location: show.php');
        exit;
    }
    
    // Supprimer le plat de la base de données
    $stmt = $pdo->prepare("DELETE FROM items WHERE id = ?");
    $stmt->execute([$id]);
    
    // Supprimer l'image physique si elle existe
    if (!empty($plat['picture'])) {
        $imagePath = UPLOAD_DIR . $plat['picture'];
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
    }
    
    $_SESSION['flash_message'] = "Plat supprimé avec succès";
    $_SESSION['flash_type'] = "success";
    
} catch (PDOException $e) {
    error_log("Erreur suppression plat : " . $e->getMessage());
    $_SESSION['flash_message'] = "Erreur lors de la suppression";
    $_SESSION['flash_type'] = "danger";
}

header('Location: show.php');
exit;
?>
