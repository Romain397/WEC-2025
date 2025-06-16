<!DOCTYPE html>
<html lang="fr-FR">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>WEC 2025 - Circuits</title>
  <link rel="stylesheet" href="styles.css">

  <!-- Fonction JS pour naviguer vers une page avec un paramètre année -->
  <script>
    function navigateToPage(page, year) {
      window.location.href = page + ".php?year=" + year;
    }
  </script>
</head>

<body>

  <header>
    <!-- Logo avec lien vers la page d'accueil -->
    <a href="index.php">
      <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTtnqHfmA59-toWX-WCqq_WjMO1PmY_Fi_zug&s" alt="WEC 2025" class="logo">
    </a>

    <div>
      <!-- Navigation latérale (sidenav) -->
      <nav id="mySidenav" class="sidenav">
        <ul>
          <!-- Bouton pour fermer la navigation -->
          <a id="closeBtn" href="#" class="close">×</a>

          <!-- Affichage conditionnel selon si l'utilisateur est connecté -->
          <?php if (isset($_SESSION['user_email'])): ?>
            <li><a href="logout.php">Se déconnecter</a></li>
          <?php else: ?>
            <li><a href="login.php">Se connecter</a></li>
            <li><a href="register.php">S'inscrire à la newsletter</a></li>
          <?php endif; ?>

          <!-- Bouton pour changer le thème du site -->
          <button id="mode-toggle">Switch theme</button>
        </ul>
      </nav>

      <!-- Bouton pour ouvrir la navigation latérale -->
      <a href="#" id="openBtn">
        <span class="burger-icon">
          <span></span>
          <span></span>
          <span></span>
        </span>
      </a>
    </div>
  </header>