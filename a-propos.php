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
    <title>À Propos - Barbecue d'Alep | Notre Histoire</title>
    
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
</head>
<body>

<!-- ========================================
     NAVBAR
     ======================================== -->
<?php include "includes/header.php"; ?>

<!-- ========================================
     HERO SECTION - À PROPOS
     ======================================== -->
<section class="hero-apropos">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h1 class="hero-title">À Propos</h1>
            </div>
        </div>
    </div>
</section>

<!-- ========================================
     SECTION PRINCIPALE - CONTENU
     ======================================== -->
<section class="apropos-content py-5">
    <div class="container">
        <div class="row align-items-center">
            <!-- Colonne Gauche: Texte -->
            <div class="col-12 col-lg-6">
                <h2 class="section-title">NOTRE PASSION</h2>
                <h3 class="subtitle">Barbecue d'Alep</h3>
                
                <div class="text-content">
                    <p>
                        Bienvenue chez Barbecue d'Alep, où nous vous apportons les 
                        saveurs authentiques de la Syrie directement à votre table. 
                        Notre passion pour la cuisine traditionnelle se reflète dans 
                        nos plats soigneusement élaborés, inspirés par le riche 
                        patrimoine culinaire d'Alep.
                    </p>
                    
                    <p>
                        Savourez nos viandes grillées tendres, nos délicieux mezzés et 
                        nos assiettes variées, toutes préparées avec les ingrédients 
                        les plus frais et une touche de véritable hospitalité syrienne.
                    </p>
                    
                    <p>
                        Nous nous engageons à offrir une expérience culinaire 
                        inoubliable qui célèbre la culture vibrante et l'histoire de la 
                        Syrie.
                    </p>
                    
                    <p>
                        Merci d'être nos invités et de partager avec nous ce voyage 
                        gastronomique.
                    </p>
                </div>
            </div>
            
            <!-- Colonne Droite: Images -->
            <div class="col-12 col-lg-6">
                <div class="images-grid">
                    <!-- Image 1: Menu Alep -->
                    <div class="image-box image-top">
                        <img src="./assets/images/Plat Menu Alep.webp" 
                             alt="Menu Alep" 
                             loading="lazy"
                             class="img-fluid rounded">
                    </div>
                    
                    <!-- Image 2: Mezzés syriens -->
                    <div class="image-box image-bottom">
                        <img src="./assets/images/MezzéàPropos.webp" 
                             alt="Mezzés syriens" 
                             loading="lazy"
                             class="img-fluid rounded">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ========================================
     FOOTER
     ======================================== -->
<?php include "includes/footer.php"; ?>

<!-- ========================================
     SCRIPTS
     ======================================== -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

<!-- Script navbar scroll -->
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