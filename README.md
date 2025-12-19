# 🍽️ Barbecue d'Alep - Site Web Restaurant

## 📋 Description

**Barbecue d'Alep** est une solution web complète développée pour un restaurant syrien authentique situé à Grenoble. Le projet combine un site vitrine moderne avec un système de gestion de contenu (CMS) intégré, permettant au propriétaire de gérer facilement son menu et son contenu.

### 🌟 Concept Innovant
- **QR Code Menu** : Les clients scannent un QR code pour accéder au menu en ligne actualisé en temps réel
- **Gestion dynamique** : Mise à jour du menu sans intervention technique
- **Expérience utilisateur** moderne et intuitive

---

## 🚀 Fonctionnalités

### 🌐 Site Public
- **Page d'accueil** avec présentation du restaurant
- **Menu dynamique** alimenté par la base de données
- **Page À propos** avec histoire du restaurant
- **Page Contact** avec informations et carte interactive
- **Design responsive** adapté à tous les appareils
- **Optimisation SEO** complète
- **Performance optimisée** (Lighthouse 79/100)

### 🔧 Panel d'Administration
- **Système d'authentification sécurisé** avec rate limiting
- **Gestion des catégories** de plats
- **CRUD complet des plats** avec upload d'images
- **Gestion des options frites**
- **Gestion des offres spéciales**
- **Interface responsive** avec sidebar mobile
- **Logs de connexion** et traçabilité

### 🛡️ Sécurité
- **Protection CSRF** avec tokens
- **Rate limiting** (5 tentatives max, cooldown 15min)
- **Sessions sécurisées** avec timeout automatique
- **Validation serveur stricte**
- **Upload sécurisé** avec validation MIME
- **Requêtes préparées PDO** (anti-SQL injection)

---

## 💻 Technologies Utilisées

### Frontend
- **HTML5** sémantique
- **CSS3** / **SCSS** avec architecture modulaire
- **JavaScript** vanilla pour les interactions
- **Bootstrap 5.3.8** pour la responsivité
- **Font Awesome 6.5.1** pour les icônes
- **Google Fonts** (Playfair Display)

### Backend
- **PHP 8+** avec programmation orientée objet
- **MySQL** avec PDO pour la sécurité
- **Architecture MVC** personnalisée
- **Gestion des sessions** avancée
- **System de logs** intégré

### Outils & Déploiement
- **OVH Cloud** pour l'hébergement
- **FileZilla** pour le déploiement FTP
- **Git** pour le versioning
- **Lighthouse** pour les audits de performance
- **SweetAlert2** pour les notifications

---

## 📊 Performance & SEO

### Scores Lighthouse
- ✅ **SEO** : 100/100
- ✅ **Accessibilité** : 93/100  
- ✅ **Bonnes pratiques** : 73/100
- 🔶 **Performance** : 79/100 (en amélioration continue)

### Optimisations
- Images **WebP** compressées
- **Preload** des ressources critiques  
- **Lazy loading** des images
- **Meta tags** OpenGraph et Twitter Cards
- **Données structurées** pour les moteurs de recherche

---

## 🏗️ Architecture du Projet

```
RESTAURANT/
├── admin/                     # Panel d'administration
│   ├── categorie/            # Gestion catégories
│   ├── plats/                # Gestion plats  
│   ├── frites/               # Gestion options frites
│   ├── offres/               # Gestion offres spéciales
│   ├── include/              # Fichiers partagés admin
│   │   ├── auth.php          # Système authentification
│   │   └── sidebar.php       # Interface admin
│   ├── dashboard.php         # Tableau de bord
│   ├── login.php             # Connexion admin
│   └── logout.php            # Déconnexion
├── assets/                   # Ressources statiques
│   ├── images/               # Images optimisées WebP
│   ├── style.css             # CSS compilé
│   ├── style.scss            # SCSS source
│   └── script.js             # JavaScript
├── config/                   # Configuration
│   └── database.php          # Connexion BDD
├── includes/                 # Composants réutilisables
│   ├── header.php            # Navigation
│   └── footer.php            # Pied de page
├── uploads/                  # Images uploadées
├── index.php                 # Page d'accueil
├── menu.php                  # Menu dynamique
├── a-propos.php              # Page à propos
├── contact.php               # Page contact
└── README.md                 # Documentation
```

---

## ⚙️ Installation & Configuration

### Prérequis
- **PHP 8.0+**
- **MySQL 5.7+**
- **Serveur web** (Apache/Nginx)
- **Extension PHP** : PDO, GD, mbstring

### Installation Locale

1. **Cloner le projet**
```bash
git clone https://github.com/votre-repo/barbecue-alep.git
cd barbecue-alep
```

2. **Configuration base de données**
```php
// config/database.php
$host = "localhost";
$dbname = "restaurant";  
$username = "root";
$password = "";
```

3. **Importer la structure BDD**
```sql
-- Tables principales
CREATE TABLE categories (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    display_order INT DEFAULT 0
);

CREATE TABLE items (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    picture VARCHAR(255),
    id_categorie INT,
    subcategory VARCHAR(100),
    display_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_categorie) REFERENCES categories(id)
);

-- Utilisateur admin par défaut
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    name VARCHAR(255)
);

-- Mot de passe : admin123
INSERT INTO users (email, password, name) VALUES 
('admin@barbecue-alep.fr', '$2y$10$example_hash', 'Administrateur');
```

4. **Démarrer le serveur**
```bash
php -S localhost:8000
```

### Déploiement Production

1. **Upload via FTP/SFTP**
2. **Configurer les variables d'environnement**
3. **Ajuster les permissions** (uploads/ en 755)
4. **Tester les fonctionnalités**

---

## 👤 Utilisation

### Interface Publique
- Accédez au site : `http://votre-domaine.com`
- Scannez le QR code pour le menu mobile
- Navigation intuitive entre les sections

### Panel d'Administration  
- Connexion : `http://votre-domaine.com/admin`
- Email : `admin@barbecue-alep.fr`
- Mot de passe : `admin123` (à changer)

#### Fonctionnalités Admin
1. **Dashboard** : Vue d'ensemble des statistiques
2. **Catégories** : Créer/modifier les sections du menu
3. **Plats** : Ajouter plats avec photos et descriptions
4. **Frites** : Gérer les tailles et prix des barquettes
5. **Offres** : Créer des menus spéciaux

---

## 🌟 Points Forts Techniques

### Architecture
- **Séparation des préoccupations** (MVC)
- **Code modulaire** et réutilisable
- **Gestion d'erreurs** robuste
- **Configuration multi-environnement**

### Sécurité Production
- **Hachage bcrypt** des mots de passe
- **Protection contre CSRF, XSS, SQLi**
- **Validation côté serveur** systématique
- **Logs d'audit** des connexions admin

### Performance
- **Images optimisées** (WebP, compression)
- **Code CSS/JS minifié**
- **Mise en cache** navigateur
- **Lazy loading** des ressources

---

## 🔮 Améliorations Futures

### Fonctionnalités
- [ ] **Commande en ligne** avec panier
- [ ] **Système de réservation** de tables
- [ ] **Notifications** SMS/Email pour commandes
- [ ] **Multi-langues** (FR/AR/EN)
- [ ] **Programme fidélité** client

### Technique  
- [ ] **API REST** pour applications mobiles
- [ ] **Cache Redis** pour performances
- [ ] **CDN** pour distribution géographique
- [ ] **Tests automatisés** (PHPUnit)
- [ ] **CI/CD** avec GitHub Actions

### Analytics
- [ ] **Dashboard ventes** pour propriétaire
- [ ] **Statistiques menu** populaire
- [ ] **Rapports** de performance
- [ ] **Intégration** Google Analytics 4

---

## 📸 Captures d'Écran

### Site Public
![Accueil Desktop](docs/screenshots/accueil-desktop.png)
![Menu Mobile](docs/screenshots/menu-mobile.png)

### Panel Admin
![Dashboard Admin](docs/screenshots/admin-dashboard.png)
![Gestion Plats](docs/screenshots/admin-plats.png)

---

## 🤝 Contribution

Ce projet est développé par **Shadah HASSAN-ABDALLAH** dans le cadre d'un stage de développement web.

### Contact
- **Email** : contact@barbecue-alep.fr
- **LinkedIn** : [Shadah HASSAN-ABDALLAH](https://www.linkedin.com/in/shadah-developpeuse/)
- **Site** : [www.barbecue-alep.fr](https://www.barbecue-alep.fr)

---

## 📄 Licence

© 2025 Barbecue d'Alep - Tous droits réservés.

Ce projet est développé spécifiquement pour le restaurant "Barbecue d'Alep" situé à Grenoble, France.

---

## 📚 Documentation Technique

### Base de Données
- **6 tables principales** avec relations bien définies
- **Contraintes d'intégrité** référentielle
- **Index optimisés** sur colonnes fréquentes
- **Support UTF8MB4** pour caractères spéciaux

### API Endpoints (Admin)
```php
// Gestion des plats
POST /admin/plats/ajouter.php    // Créer un plat
GET  /admin/plats/show.php       // Lister les plats  
PUT  /admin/plats/modifier.php   // Modifier un plat
DELETE /admin/plats/delete.php   // Supprimer un plat
```

### Configuration Avancée
```php
// Variables d'environnement
define('IS_PRODUCTION', $_SERVER['HTTP_HOST'] !== 'localhost');

// Configuration automatique dev/prod
if (IS_PRODUCTION) {
    // Paramètres production
} else {
    // Paramètres développement
}
```

---

**Développé avec ❤️ pour l'authenticité culinaire syrienne à Grenoble** 🇸🇾🇫🇷
