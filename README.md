# 🍽️ Barbecue d'Alep – Site Web Restaurant

**Projet réalisé par Shadah HASSAN-ABDALLAH – Stage DWWM Nepsod 2025**

---

## Démo Live

- **Site Public** : [https://bbq-dalep.fr](https://bbq-dalep.fr)

---

## Concept Innovant

- QR Code Menu temps réel
- Gestion autonome du contenu
- Réduction 70% des appels clients

---

## Performance (Lighthouse Desktop)

SEO : 100/100 | Accessibilité : 92/100 | Performance : 92/100 | Best Practices : 100/100

---

## Technologies

- **Frontend** : HTML5, SCSS, JavaScript ES6, Bootstrap 5
- **Backend** : PHP 8, MySQL, PDO
- **Sécurité** : CSRF (hash_equals), bcrypt, finfo_file, sessions sécurisées, .htaccess
- **Hébergement** : OVH Cloud

---

## Fonctionnalités

### Site Public
- Menu dynamique responsive
- QR Code intégré
- SEO optimisé (meta tags, Open Graph, Twitter Cards)

### Panel Admin
- Authentification sécurisée (bcrypt + protection brute-force)
- CRUD complet : plats, catégories, frites, offres spéciales
- Upload images sécurisé — 4 couches de validation (taille, MIME via finfo, extension, nom unique)
- Dashboard avec statistiques

---

## Sécurité

| Protection | Implémentation |
|------------|----------------|
| Injection SQL | Requêtes préparées PDO |
| XSS | htmlspecialchars() sur toutes les sorties |
| CSRF | Token + hash_equals() |
| Upload malveillant | Validation MIME réelle avec finfo_file() |
| Authentification | password_hash() / password_verify() (bcrypt) |
| Sessions | cookie_httponly, cookie_secure, timeout 30 min |
| Serveur | .htaccess (config protégé, PHP bloqué dans uploads) |

---

## Documentation

13 documents professionnels disponibles dans `/docs` :

Cahier de charges | Personas | Parcours utilisateur | Doc technique | Guide utilisateur FR/AR | Maquettes Figma | Modèle BDD | Guide déploiement OVH

---

## Objectif

Moderniser un restaurant syrien familial avec une solution web complète permettant la gestion autonome du menu et l'amélioration de l'expérience client.

---

## Développeuse

**Shadah HASSAN-ABDALLAH**

📧 shadah.hassan.abdallah@gmail.com

Développeuse Web et Web Mobile – DWWM RNCP37674