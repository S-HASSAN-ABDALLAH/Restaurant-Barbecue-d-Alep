<!DOCTYPE html>
<html lang="fr">
<head>
    <!-- Meta essentiels -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- META DESCRIPTION (SEO) -->
    <meta name="description" content="Barbecue d'Alep - Restaurant syrien authentique à Grenoble. Savourez de véritables grillades syriennes au charbon de bois. Cuisine traditionnelle d'Alep, ambiance chaleureuse. Réservez maintenant!">
    
    <!-- Keywords -->
    <meta name="keywords" content="restaurant syrien Grenoble, barbecue syrien, grillades charbon de bois, cuisine Alep, restaurant oriental Grenoble, mezze, kebab, livraison restaurant">
    
    <!-- Author -->
    <meta name="author" content="Barbecue d'Alep">
    
    <!-- Open Graph (réseaux sociaux) -->
    <meta property="og:title" content="Barbecue d'Alep - Restaurant Syrien Authentique à Grenoble">
    <meta property="og:description" content="Savourez de véritables grillades syriennes au charbon de bois. Cuisine traditionnelle d'Alep.">
    <meta property="og:image" content="./assets/images/Logo.webp">
    <meta property="og:url" content="https://www.barbecue-alep.fr">
    <meta property="og:type" content="restaurant">
    <meta property="og:locale" content="fr_FR">
    
    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Barbecue d'Alep - Restaurant Syrien à Grenoble">
    <meta name="twitter:description" content="Restaurant syrien authentique. Grillades au charbon de bois.">
    <meta name="twitter:image" content="./assets/images/Logo.webp">
    
    <!-- Titre de la page -->
    <title>Barbecue d'Alep - Restaurant Syrien Authentique à Grenoble</title>
    
    <!-- Préconnexions pour optimiser le chargement -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdn.jsdelivr.net">
    
    <!-- Précharger l'image hero pour performance -->
    <link rel="preload" as="image" href="./assets/images/HeroAccueill.webp">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair:ital,opsz,wght@0,5..1200,300..900;1,5..1200,300..900&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"> 
    
    <!-- CSS personnalisé -->
    <link rel="stylesheet" href="./assets/style.css">
    
    <!-- Favicon -->
    <link rel="icon" type="image/webp" href="./assets/images/Logo.webp">
</head>
<body>

<!-- ========================================
     NAVBAR - Navigation principale
     ======================================== -->
<?php include "includes/header.php"; ?>

<!-- ========================================
     HERO SECTION - Section d'accueil
     ======================================== -->
<section class="hero-section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="hero-title">De la citadelle d'Alep au cœur de Grenoble </h1>
                <p class="hero-subtitle">Savourez de véritables grillades syriennes au charbon de bois</p>
                <a href="menu.php" class="btn-hero">Voir le Menu</a>
            </div>
        </div>
    </div>
</section>

<!-- ========================================
     L'ESPRIT D'ALEP - Présentation
     ======================================== -->
<section class="esprit-alep py-5">
    <div class="container">
        <div class="row align-items-center">
            <!-- Colonne texte -->
            <div class="col-12 col-md-6">
                <h2>L'esprit d'Alep, la chaleur de la table syrienne</h2>
                <div class="title-underline"></div>
                <p>Au Barbecue d'Alep, nous célébrons la cuisine du cœur : grillades parfumées, mezzés faits maison, accueil chaleureux. Un lieu où la tradition rencontre la passion.</p>
                <a href="a-propos.php" class="btn-discover">
                    En savoir plus <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            
            <!-- Colonne image -->
            <div class="col-12 col-md-6 text-center image-container">
                     <img src="./assets/images/AlepRestoAccueil.webp" 
                     alt="Intérieur du restaurant Barbecue d'Alep à Grenoble" 
                     loading="lazy" 
                     class="img-fluid rounded-circle"
                     width="500"
                     height="500">
            </div>
        </div>
    </div>
</section>

<!-- ========================================
     NOS INCONTOURNABLES - Plats phares
     ======================================== -->
<section class="nos-incontournables">
    <div class="container">
        <!-- Titre de la section -->
        <div class="row">
            <div class="col-12 text-center section-title">
                <h2>Nos Incontournables</h2>
            </div>
        </div>
        
        <!-- Cartes de plats -->
        <div class="row cards-container">
            <!-- Carte 1: Végétarien & Végan -->
            <div class="col-lg-4 col-md-6 col-sm-12 card-column">
                <div class="food-card">
                    <div class="card-image-wrapper">
                        <img src="./assets/images/végétarienAccueil.webp" 
                             alt="Plats végétariens et végans syriens"
                             loading="lazy"
                             width="380"
                             height="300">
                    </div>
                    <div class="card-content">
                        <h5>Végétarien & Végan</h5>
                    </div>
                </div>
            </div>
            
            <!-- Carte 2: Sandwiches -->
            <div class="col-lg-4 col-md-6 col-sm-12 card-column">
                <div class="food-card">
                    <div class="card-image-wrapper">
                        <img src="./assets/images/SANDWICHS (2).webp" 
                             alt="Sandwiches syriens authentiques"
                             loading="lazy"
                             width="380"
                             height="300">
                    </div>
                    <div class="card-content">
                        <h5>SANDWICHES</h5>
                    </div>
                </div>
            </div>
            
            <!-- Carte 3: Grillades -->
            <div class="col-lg-4 col-md-6 col-sm-12 card-column">
                <div class="food-card">
                    <div class="card-image-wrapper">
                        <img src="assets/images/GrilladeAccueil1.webp" 
                             alt="Grillades syriennes au charbon de bois"
                             loading="lazy"
                             width="380"
                             height="300">
                    </div>
                    <div class="card-content">
                        <h5>GRILLADES</h5>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Bouton vers le menu complet -->
        <div class="row">
            <div class="col-12 text-center button-container">
                <a class="btn-menu" href="menu.php">
                    Voir le Menu Complet
                </a>
            </div>
        </div>
    </div>
</section>

<!-- ========================================
     NOS SERVICES - Services proposés
     ======================================== -->
<section class="nos-services">
    <div class="container">
        <h2 class="section-title">Nos Services</h2>
        
        <div class="services-grid">
            <!-- Service 1: Halal -->
            <div class="service-card">
                <div class="service-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <p class="service-name">Halal</p>
            </div>
            
            <!-- Service 2: Sur place -->
            <div class="service-card">
                <div class="service-icon">
                    <i class="fas fa-utensils"></i>
                </div>
                <p class="service-name">Sur place</p>
            </div>
            
            <!-- Service 3: À emporter -->
            <div class="service-card">
                <div class="service-icon">
                    <i class="fas fa-shopping-bag"></i>
                </div>
                <p class="service-name">À emporter</p>
            </div>
            
            <!-- Service 4: Livraison -->
            <div class="service-card">
                <div class="service-icon">
                    <i class="fas fa-truck"></i>
                </div>
                <p class="service-name">Livraison</p>
            </div>
            
            <!-- Service 5: Traiteur -->
            <div class="service-card">
                <div class="service-icon">
                    <i class="fas fa-concierge-bell"></i>
                </div>
                <p class="service-name">Traiteur</p>
            </div>
            
            <!-- Service 6: Fait Maison -->
            <div class="service-card">
                <div class="service-icon">
                    <i class="fas fa-hand-holding-heart"></i>
                </div>
                <p class="service-name">Fait Maison</p>
            </div>
            
            <!-- Service 7: Végétarien -->
            <div class="service-card">
                <div class="service-icon">
                    <i class="fas fa-carrot"></i>
                </div>
                <p class="service-name">Végétarien</p>
            </div>
            
            <!-- Service 8: Végan -->
            <div class="service-card">
                <div class="service-icon">
                    <i class="fas fa-leaf"></i>
                </div>
                <p class="service-name">Végan</p>
            </div>
        </div>
    </div>
</section>

<!-- ========================================
     AVIS CLIENTS - Témoignages
     ======================================== -->
<section class="avis-clients">
    <div class="container">
        <!-- En-tête avec note -->
        <div class="row">
            <div class="col-12 text-center avis-header">
                <h2>Ce que disent nos clients</h2>
                <div class="rating-score">
                    <span class="score">4.9</span>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="based-on">
                        <i class="fas fa-check-circle"></i> Avis vérifiés
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Cartes d'avis -->
        <div class="row avis-cards-container">
            <!-- Avis 1 -->
            <div class="col-lg-4 col-md-6 col-sm-12 avis-card-column">
                <div class="avis-card">
                    <div class="card-stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="avis-text">
                        Petit resto familial avec une cuisine syrienne au top, les portions sont généreuses.
                    </p>
                    <p class="author-name">Osman Attal</p>
                </div>
            </div>
            
            <!-- Avis 2 -->
            <div class="col-lg-4 col-md-6 col-sm-12 avis-card-column">
                <div class="avis-card">
                    <div class="card-stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="avis-text">
                        De loin l'un de mes spots préférés à Grenoble, on y mange bien, l'ambiance est sympa et le personnel aux petits soins.
                    </p>
                    <p class="author-name">Aziza Djebara</p>
                </div>
            </div>
            
            <!-- Avis 3 -->
            <div class="col-lg-4 col-md-6 col-sm-12 avis-card-column">
                <div class="avis-card">
                    <div class="card-stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="avis-text">
                        Excellente adresse. Plats maisons délicieux et hôtes adorables. Tout ce qui est sur la carte est excellent.
                    </p>
                    <p class="author-name">Rémi De Vergnette</p>
                </div>
            </div>
        </div>
        
        <!-- Bouton vers tous les avis -->
        <div class="row">
            <div class="col-12 text-center mt-5">
                <!--  URL simplifiée -->
                <a href="https://www.google.com/search?sca_esv=e5901bf1fe2672d3&sxsrf=AE3TifO14vWnv3EYOTpZpB0g1I5-n0E2DA:1763922174490&si=AMgyJEtREmoPL4P1I5IDCfuA8gybfVI2d5Uj7QMwYCZHKDZ-EwZVfPmTo-V5oIZNCWANCgYIZH45R3sBfN1BdNbrsYBU8ISnsqHezxm9HftmyT0B-fKNTAVVIk3DmfDJkDUz5H14nHmK&q=Aleppo+BBQ+Reviews&sa=X&ved=2ahUKEwj8yfyU8oiRAxUZTqQEHap9EVYQ0bkNegQIJRAD&biw=1920&bih=911&dpr=1" 
                   target="_blank" 
                   rel="noopener noreferrer"
                   class="btn-all-reviews">
                    Voir tous les avis Google <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
        
        <!-- Icônes décoratives -->
        <div class="decoration-icons">
            <i class="fas fa-thumbs-up like-icon"></i>
            <i class="fas fa-heart heart-icon"></i>
            <i class="fas fa-star star-icon star-1"></i>
            <i class="fas fa-star star-icon star-2"></i>
            <i class="fas fa-star star-icon star-3"></i>
        </div>
    </div>
</section>

<!-- ========================================
     FOOTER - Pied de page
     ======================================== -->
<?php include "includes/footer.php"; ?>

<!-- ========================================
     SCRIPTS
     ======================================== -->
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

<!-- Script navbar: fond transparent → opaque au scroll -->
<script>
window.addEventListener('scroll', function() {
    const navbar = document.querySelector('.navbar');
    if (window.scrollY > 50) {
        navbar.classList.add('scrolled');
    } else {
        navbar.classList.remove('scrolled');
    }
});
</script>

</body>
</html>
