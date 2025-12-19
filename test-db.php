<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/config/database.php';

echo "<h2>Test de connexion à la base de données</h2>";

try {
    $stmt = $pdo->query("SELECT * FROM users LIMIT 1");
    $user = $stmt->fetch();
    
    echo "✅ Connexion BDD réussie !<br>";
    echo "Nombre de colonnes : " . $stmt->columnCount() . "<br>";
    
    if ($user) {
        echo "✅ Table 'users' existe<br>";
        echo "Colonnes disponibles : " . implode(', ', array_keys($user));
    } else {
        echo "⚠️ Table 'users' vide - Créez un compte admin";
    }
    
} catch (PDOException $e) {
    echo "❌ Erreur : " . $e->getMessage();
}
?>
