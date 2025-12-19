<?php
/**
 * Système d'authentification sécurisé
 * VERSION PRODUCTION - Optimisée pour OVH
 * CORRIGÉ : Chemin database + colonnes users
 */

// Démarrer la session avec paramètres de sécurité
if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.cookie_httponly', 1);
    ini_set('session.cookie_secure', isset($_SERVER['HTTPS']) ? 1 : 0);
    ini_set('session.use_strict_mode', 1);
    session_start();
}

require_once(__DIR__ . "/../config/database.php");

// ===== Configuration dynamique de l'URL Admin =====
function getAdminUrl() {
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'];
    
    // Détection automatique du chemin
    $scriptPath = dirname(dirname($_SERVER['SCRIPT_NAME'])); // Remonte de 2 niveaux
    $scriptPath = str_replace('\\', '/', $scriptPath); // Windows compatibility
    
    return $protocol . '://' . $host . $scriptPath;
}

define('ADMIN_URL', getAdminUrl());

// ===== Protection contre les attaques par force brute =====
function checkLoginAttempts($email) {
    if (!isset($_SESSION['login_attempts'])) {
        $_SESSION['login_attempts'] = [];
    }
    
    // Nettoyer les anciennes tentatives (plus de 15 minutes)
    $currentTime = time();
    foreach ($_SESSION['login_attempts'] as $attempt_email => $data) {
        if ($currentTime - $data['time'] > 900) { // 15 minutes
            unset($_SESSION['login_attempts'][$attempt_email]);
        }
    }
    
    // Vérifier le nombre de tentatives
    if (isset($_SESSION['login_attempts'][$email])) {
        $attempts = $_SESSION['login_attempts'][$email];
        if ($attempts['count'] >= 5 && ($currentTime - $attempts['time']) < 900) {
            return false; // Trop de tentatives
        }
    }
    
    return true;
}

function recordLoginAttempt($email, $success = false) {
    if ($success) {
        // Réinitialiser en cas de succès
        unset($_SESSION['login_attempts'][$email]);
    } else {
        // Incrémenter le compteur
        if (!isset($_SESSION['login_attempts'][$email])) {
            $_SESSION['login_attempts'][$email] = [
                'count' => 1,
                'time' => time()
            ];
        } else {
            $_SESSION['login_attempts'][$email]['count']++;
            $_SESSION['login_attempts'][$email]['time'] = time();
        }
    }
}

// ===== Fonction de connexion sécurisée =====
function login($email, $password) {
    global $pdo;
    
    // Validation de base
    if (empty($email) || empty($password)) {
        return false;
    }
    
    // Vérifier les tentatives de connexion
    if (!checkLoginAttempts($email)) {
        return 'RATE_LIMITED'; // Message spécial pour trop de tentatives
    }
    
    try {
        // Recherche de l'utilisateur (requête préparée)
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        
        // Vérification du mot de passe
        if ($user && password_verify($password, $user['password'])) {
            // CONNEXION RÉUSSIE
            
            // Régénérer l'ID de session (protection contre le vol de session)
            session_regenerate_id(true);
            
            
            // Enregistrer les informations dans la session
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_id'] = $user['id'];
            $_SESSION['admin_email'] = $user['email'];
            $_SESSION['admin_name'] = explode('@', $user['email'])[0]; // Utiliser la partie avant @
            $_SESSION['login_time'] = time();
            $_SESSION['last_activity'] = time();
            
            // Réinitialiser les tentatives
            recordLoginAttempt($email, true);
            
            // Log de connexion (optionnel, pour traçabilité)
            try {
                $logStmt = $pdo->prepare("INSERT INTO login_logs (user_id, ip_address, user_agent, login_time) VALUES (?, ?, ?, NOW())");
                $logStmt->execute([
                    $user['id'],
                    $_SERVER['REMOTE_ADDR'] ?? 'Unknown',
                    $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown'
                ]);
            } catch (PDOException $e) {
                // Si la table login_logs n'existe pas, ignorer l'erreur
                error_log("Login log error: " . $e->getMessage());
            }
            
            return true;
        }
        

        recordLoginAttempt($email, false);
        return false;
        
    } catch (PDOException $e) {
        error_log("Login error: " . $e->getMessage());
        return false;
    }
}

// ===== Vérifier si l'utilisateur est connecté =====
function isLoggedIn() {
    if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
        return false;
    }
    
    // Timeout de session (30 minutes d'inactivité)
    $timeout = 1800; // 30 minutes
    if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $timeout) {
        logout();
        return false;
    }
    
    // Mettre à jour le dernier temps d'activité
    $_SESSION['last_activity'] = time();
    
    return true;
}

// ===== Protection des pages admin =====
function requireLogin() {
    if (!isLoggedIn()) {
        // Sauvegarder l'URL demandée pour rediriger après connexion
        $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
        
        header('Location: ' . ADMIN_URL . '/login.php');
        exit;
    }
}

// ===== Déconnexion sécurisée =====
function logout() {
    // Détruire toutes les variables de session
    $_SESSION = array();
    
    // Détruire le cookie de session
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time() - 3600, '/');
    }
    
    // Détruire la session
    session_destroy();
    
    // Redirection
    header('Location: ' . ADMIN_URL . '/login.php');
    exit;
}

// ===== Obtenir les informations de l'admin connecté =====
function getAdminInfo() {
    if (!isLoggedIn()) {
        return null;
    }
    
    return [
        'id' => $_SESSION['admin_id'] ?? null,
        'email' => $_SESSION['admin_email'] ?? null,
        'name' => $_SESSION['admin_name'] ?? 'Admin',
        'login_time' => $_SESSION['login_time'] ?? null
    ];
}

// ===== Génération de token CSRF =====
function generateCsrfToken() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

// ===== Vérification du token CSRF =====
function verifyCsrfToken($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}
?>
