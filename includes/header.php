<?php
require_once __DIR__ . '/../config/database.php';
$stmtCat = $pdo->query("SELECT * FROM categories ORDER BY display_order ASC");
$headerCategories = $stmtCat->fetchAll();
?>
<!-- test -->
<header>
  <nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mx-auto mb-lg-0 d-flex justify-content-center align-items-center">
          <li class="nav-item">
            <a class="nav-link" href="index.php">Accueil</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="a-propos.php">À propos</a>
          </li>
          
          <li class="nav-item">
            <a class="navbar-brand" href="index.php">
              <img src="./assets/images/Logo.webp" alt="Logo Restaurant" loading="lazy">
            </a>
          </li>
          
          <li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        Menu
    </a>
    <ul class="dropdown-menu">
        <!-- خيار عام لرؤية كل شيء -->
        <li>
            <a class="dropdown-item" href="menu.php">
                Explorer tout le menu
            </a>
        </li>
        <li><hr class="dropdown-divider"></li>
        
        <!-- الفئات المحددة -->
        <?php foreach ($headerCategories as $cat): ?>
        <li>
            <a class="dropdown-item" href="menu.php#category-<?= $cat['id'] ?>">
                <?= htmlspecialchars(strtoupper($cat['name'])) ?>
            </a>
        </li>
        <?php endforeach; ?>
    </ul>
</li>
          
          <li class="nav-item">
            <a class="nav-link" href="contact.php">Contact</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</header>
