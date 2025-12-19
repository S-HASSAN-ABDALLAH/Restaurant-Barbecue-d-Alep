<footer>
<div class="container">
    <div class="row text-center">
        <div class="col-12 col-md-4">
            <img class="logo" src="./assets/images/Logo.webp" alt="Barbecue d'Alep">
           <p class="footer-description">
        Restaurant syrien authentique à Grenoble
    </p>
        <h3> Contact</h3>
        <h4><i class="fa-solid fa-phone"></i> Appelez-nous</h4>
    <a class="phone-number"  href="tel:+33988014272">09 88 01 42 72</a>
    <p>Pour commander ou réserver</p>
        </div>
        
        <div class="col-12 col-md-4">
                       <h3>ADRESSE & HORAIRES</h3>
                       <h4><i class="fa-solid fa-location-dot"></i> Nous trouver</h4>
                       <p>7 Rue Raoul Blanchard<br>38000 GRENOBLE</p>
                       <h4><i class="fa-regular fa-clock"></i> Horaires</h4>
                       <p>Ouvert du mardi au samedi</p>
                       <p>11h30-15h00 / 18h30-22h00</p>
                       <p>Fermé dimanche & lundi</p>

        </div>
        <div class="col-12 col-md-4">
            <h3>LIVRAISON & RÉSEAUX</h3>
            <h4><i class="fa-solid fa-motorcycle"></i> Livraison rapide via Uber Eats</h4>
            <a href="https://www.ubereats.com/fr/store/barbecue-dalep/5R3ZDI_aTUC5uBllhX6DFg?diningMode=DELIVERY&pl=JTdCJTIyYWRkcmVzcyUyMiUzQSUyMjglMjBBbGwlQzMlQTllJTIwZHUlMjBQYXJjJTIwR2VvcmdlcyUyMFBvbXBpZG91JTIyJTJDJTIycmVmZXJlbmNlJTIyJTNBJTIyYWEwNjRiN2YtMTMwYy1iOTgwLWYxODQtNTZhZWJhNDZiOThiJTIyJTJDJTIycmVmZXJlbmNlVHlwZSUyMiUzQSUyMnViZXJfcGxhY2VzJTIyJTJDJTIybGF0aXR1ZGUlMjIlM0E0NS4xNzY4NTMlMkMlMjJsb25naXR1ZGUlMjIlM0E1LjcyMDM2NyU3RA%3D%3D" class="uber-link">
            <img src="./assets/images/Ubereat.webp" alt="Uber Eats" class="uber-logo"></a>
            <h3>Suivez-nous</h3>
            <a class="icon-social" 
            href="https://www.facebook.com/p/Barbecue-dAlep-100035121283153/"
            aria-label="Visitez notre page Facebook" 
            title="Facebook"
            target="_blank">
            <i class="fa-brands fa-facebook"></i></a>            
            <a class="tripadvisor-img icon-social" 
            href="https://www.tripadvisor.fr/Restaurant_Review-g187264-d17195499-Reviews-Barbecue_d_Alep-Grenoble_Isere_Auvergne_Rhone_Alpes.html" 
            aria-label="Consultez nos avis sur TripAdvisor"
            title="TripAdvisor"
            target="_blank">
            <img src="./assets/images/TripAdvisor1.webp" alt="Logo TripAdvisor - Consultez nos avis"  class="tripadvisor-img"> </a>
            <a class="icon-social" 
            href="https://www.instagram.com/barbecue_dalep/"
            aria-label="Suivez-nous sur Instagram" 
            title="Instagram"
            target="_blank">
            <i class="fa-brands fa-instagram"></i></a>
         </div> 
    </div>
</div>

<div class="copyright">
    <p>©️ 2025 Barbecue d'Alep - Tous droits réservés</p>
    <p class="developer">
        Conçu et développé par 
        <a href="https://www.linkedin.com/in/shadah-developpeuse/" target="_blank">Shadah HASSAN-ABDALLAH</a>
    </p>
</div>

<!-- Back to Top Button -->
<button id="backToTop" title="Retour en haut">
    <i class="fas fa-arrow-up"></i>
</button>

<script src="https://kit.fontawesome.com/7d16ed7181.js" crossorigin="anonymous" async></script>

<script>
// Back to Top Button
const backToTopBtn = document.getElementById('backToTop');

window.addEventListener('scroll', function() {
    if (window.pageYOffset > 300) {
        backToTopBtn.classList.add('show');
    } else {
        backToTopBtn.classList.remove('show');
    }
});

backToTopBtn.addEventListener('click', function() {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
});
</script>

</footer>