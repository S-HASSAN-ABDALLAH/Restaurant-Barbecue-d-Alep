<?php

define('IS_PRODUCTION', $_SERVER['HTTP_HOST'] !== 'localhost');

// Configuration selon l'environnement
if (IS_PRODUCTION) {

    $host = "bbqdalx131.mysql.db";
    $dbname = "bbqdalx131";
    $username = "bbqdalx131";
    $password = "Shadaovh123";

    // Désactiver l'affichage des erreurs en production
    ini_set('display_errors', 0);
    error_reporting(0);
    
} else {
    // Configuration locale (développement)
    $host = "localhost";
    $dbname = "restaurant";
    $username = "root";
    $password = "";
    
    // Activer les erreurs en développement
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
}

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
        ]
    );
    
} catch(PDOException $e) {
    // En production : message générique
    if (IS_PRODUCTION) {
        error_log("Erreur de connexion BDD : " . $e->getMessage());
        die("Une erreur technique est survenue. Veuillez contacter l'administrateur.");
    } else {
        // En développement : afficher l'erreur complète
        die('Erreur de connexion : ' . $e->getMessage());
    }
}

// Nettoyer les variables sensibles
unset($host, $username, $password);
?>

