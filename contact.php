<!DOCTYPE html>
<html lang="fr">
<head>
    <!-- Meta essentiels -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- META DESCRIPTION (SEO) -->
    <meta name="description" content="Découvrez l'histoire de Barbecue d'Alep, restaurant syrien authentique à Grenoble. Cuisine traditionnelle, passion et hospitalité syrienne.">
    
    <!-- Keywords -->
    <meta name="keywords" content="à propos barbecue alep, restaurant syrien grenoble, histoire restaurant, cuisine traditionnelle alep">
    
    <!-- Titre de la page -->
    <title>Contact - Barbecue d'Alep</title>
    
    <!-- Préconnexions -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdn.jsdelivr.net">
    
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
    
    <!-- STYLE INLINE POUR FIX MOBILE -->
    <style>
        @media (max-width: 768px) {
            .hero-contact .container {
                display: flex !important;
                align-items: flex-end !important;
                height: 100% !important;
                padding-bottom: 1rem !important;
            }
            
            .hero-contact .text-content {
                margin-top: 0 !important;
            }
        }
        
        @media (max-width: 576px) {
            .hero-contact .container {
                padding-bottom: 0.5rem !important;
            }
        }
    </style>
</head>
<body>

<!-- ========================================
     NAVBAR
     ======================================== -->
<?php include "includes/header.php"; ?>


<!-- ==========================================
     SECTION HERO - CONTACT
     ========================================== -->
<section class="hero-contact">
    <div class="container">
        <div class="text-content">
            <h1 class="contact-title">Contactez-nous</h1>
            <p class="contact-description">Nous serions ravis de vous accueillir</p>
        </div>
    </div>
</section>

<!-- ==========================================
     SECTION INFORMATIONS (3 Cartes)
     ========================================== -->
<section class="contact-info">
    <div class="container">
        <div class="row">
            <!-- Carte 1: Téléphone -->
            <div class="col-12 col-md-6 col-lg-4 mb-4">
                <div class="info-card">
                    <div class="card-icon">
                        <i class="fa-solid fa-phone"></i>
                    </div>
                    <h3 class="card-title">Téléphone</h3>
                    <p class="card-text">09 88 01 42 72</p>
                    <p class="card-subtitle">Pour commander ou réserver</p>
                </div>
            </div>

            <!-- Carte 2: Adresse -->
            <div class="col-12 col-md-6 col-lg-4 mb-4">
                <div class="info-card">
                    <div class="card-icon">
                        <i class="fa-solid fa-location-dot"></i>
                    </div>
                    <h3 class="card-title">Adresse</h3>
                    <p class="card-text">7 Rue Raoul Blanchard<br>38000 Grenoble</p>
                </div>
            </div>

            <!-- Carte 3: Horaires -->
            <div class="col-12 col-md-6 col-lg-4 mb-4">
                <div class="info-card">
                    <div class="card-icon">
                        <i class="fa-regular fa-clock"></i>
                    </div>
                    <h3 class="card-title">Horaires</h3>
                    <p class="card-text">
                        Mardi-Samedi<br>
                        11h30-15h00 / 18h30-22h00
                    </p>
                    <p class="card-closed">Fermé dimanche & lundi</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ==========================================
     SECTION GOOGLE MAPS
     ========================================== -->
<section class="maps-section">
    <div class="maps-header">
        <h2>Notre Emplacement</h2>
    </div>
    <div class="maps-container">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3335.4151145912083!2d5.726612376594888!3d45.190055751687815!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x478af55d4eb70163%3A0x80cf82d06be695a0!2sAleppo%20BBQ!5e1!3m2!1sen!2sfr!4v1764098181064!5m2!1sen!2sfr" title="Carte Google Maps - Barbecue d'Alep, 7 Rue Raoul Blanchard, Grenoble" width="100%" height="500" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
</section>

<!-- SECTION NOTRE RESTAURANT -->
<section class="notre-restaurant">
    <div class="container">
        <h2 class="section-title">Notre Restaurant</h2>
        
        <!-- Description du restaurant -->
        <div class="restaurant-description">
            <p>Découvrez l'atmosphère chaleureuse et authentique de notre restaurant. 
            Un lieu de convivialité où la tradition syrienne rencontre l'hospitalité grenobloise.</p>
        </div>
        
        <!-- Galerie photos -->
        <div class="restaurant-gallery-pro">
            <!-- Photo principale -->
            <div class="gallery-item-large">
                <img src="./assets/images/intérieur-restaurant.webp"
                     alt="Intérieur du restaurant Barbecue d'Alep"
                     loading="lazy">
            </div>
            
            <!-- Photos secondaires -->
            <div class="gallery-items-small">
                <div class="gallery-item-small">
                    <img src="./assets/images/PlatContact1.webp"
                         alt="Plat syrien traditionnel"
                         loading="lazy">
                </div>
                <div class="gallery-item-small">
                    <img src="./assets/images/TeaContact2.webp"
                         alt="Thé syrien traditionnel"
                         loading="lazy">
                </div>
            </div>
        </div>
        
        <!-- Boutons d'action -->
        <div class="restaurant-cta">
            <div class="cta-buttons-group">
                <!-- Uber Eats -->
                <a href="https://www.ubereats.com/fr/store/barbecue-dalep/5R3ZDI_aTUC5uBllhX6DFg?diningMode=DELIVERY&pl=JTdCJTIyYWRkcmVzcyUyMiUzQSUyMjglMjBBbGwlQzMlQTllJTIwZHUlMjBQYXJjJTIwR2VvcmdlcyUyMFBvbXBpZG91JTIyJTJDJTIycmVmZXJlbmNlJTIyJTNBJTIyYWEwNjRiN2YtMTMwYy1iOTgwLWYxODQtNTZhZWJhNDZiOThiJTIyJTJDJTIycmVmZXJlbmNlVHlwZSUyMiUzQSUyMnViZXJfcGxhY2VzJTIyJTJDJTIybGF0aXR1ZGUlMjIlM0E0NS4xNzY4NTMlMkMlMjJsb25naXR1ZGUlMjIlM0E1LjcyMDM2NyU3RA%3D%3D"
                   target="_blank"
                   rel="noopener"
                   class="btn-cta btn-uber"
                   aria-label="Commander sur Uber Eats">
                    <i class="fa-solid fa-bag-shopping"></i>
                    Commander sur Uber Eats
                </a>
                
                <!-- Téléphone -->
                <a href="tel:0988014272"
                   class="btn-cta btn-phone"
                   aria-label="Appeler le restaurant">
                    <i class="fa-solid fa-phone"></i>
                    Réserver par téléphone
                </a>
            </div>
        </div>
    </div>
</section>

<!-- ==========================================
     FOOTER (Inclus depuis includes)
     ========================================== -->
<?php include './includes/footer.php'; ?>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Script pour navbar scroll -->
<script>
    // Ajoute une classe "scrolled" quand on scroll
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
</html></content>
