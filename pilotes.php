<?php
session_start(); // Démarrage de la session pour gérer les messages ou connexions utilisateur

$message = ""; // Initialisation de la variable message pour affichage d'informations

// Gestion des messages d'inscription stockés en session
if (isset($_SESSION['registration_message'])) {
    $message = $_SESSION['registration_message']; // Récupération du message de session
    unset($_SESSION['registration_message']);     // Suppression du message de session pour éviter la répétition
}

// Définition des chemins vers les fichiers JSON contenant les pilotes par catégorie
$hyFile = __DIR__ . '/api/api_pilotes_HY.json';
$lmp2File = __DIR__ . '/api/api_pilote_LMP2.json';
$lmgt3File = __DIR__ . '/api/api_LMGT3_pilotes.json';

// Initialisation des tableaux pour stocker les données des pilotes
$pilotesHY = [];
$pilotesLMP2 = [];
$pilotesLMGT3 = [];

// Chargement et décodage des fichiers JSON si ils existent
if (file_exists($hyFile)) {
    $pilotesHY = json_decode(file_get_contents($hyFile), true)['pilotes'];
}
if (file_exists($lmp2File)) {
    $pilotesLMP2 = json_decode(file_get_contents($lmp2File), true)['pilotes'];
}
if (file_exists($lmgt3File)) {
    $pilotesLMGT3 = json_decode(file_get_contents($lmgt3File), true)['pilotes'];
}
?>

<?php
require "header.php"; // Inclusion de l'en-tête commun HTML (menu, CSS, etc.)
?>

<div class="top">
    <h1>Pilotes</h1> <!-- Titre principal de la page -->
</div>

<!-- Menu de navigation principal -->
<div class="menu">
    <button onclick="window.location.href='index.php?year=2025'">Saison 2025</button>
    <button onclick="window.location.href='index.php?year=2024'">Saison 2024</button>
    <button onclick="window.location.href='circuits.php'">Circuits</button>
    <button onclick="window.location.href='voitures.php'">Voitures</button>
    <button onclick="window.location.href='marques.php'">Constructeurs</button>
    <button onclick="window.location.href='pilotes.php'">Pilotes</button>
</div>

<!-- Filtres pour naviguer rapidement entre les catégories de pilotes -->
<div class="filters">
    <button onclick="window.location.href='#hypercar'">Hypercar</button>
    <button onclick="window.location.href='#lmp2'">LMP2</button>
    <button onclick="window.location.href='#lmgt3'">LMGT3</button>
</div>

<!-- Conteneur principal pour l'affichage des pilotes par catégorie -->
<div class="container">

    <!-- Section Hypercar -->
    <h2 id="hypercar">Hypercar</h2>
    <div class="grid">
        <?php if (!empty($pilotesHY)): // Vérifie s'il y a des pilotes Hypercar 
        ?>
            <?php foreach ($pilotesHY as $pilote): // Parcourt chaque pilote Hypercar 
            ?>
                <div class="carte">
                    <img src="<?= htmlspecialchars($pilote['image']) ?>" alt="<?= htmlspecialchars($pilote['nom']) ?>" class="img-hover">
                    <h3><?= htmlspecialchars($pilote['nom']) ?></h3>
                    <p>Nationalité : <?= htmlspecialchars($pilote['nationalite']) ?></p>
                    <p>Équipe : <?= htmlspecialchars($pilote['equipe']) ?></p>
                    <p>Numéro de voiture : <?= htmlspecialchars($pilote['numero_voiture']) ?></p>
                    <p>Catégorie : <?= htmlspecialchars($pilote['categorie']) ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucun pilote Hypercar disponible.</p>
        <?php endif; ?>
    </div>

    <!-- Section LMP2 -->
    <h2 id="lmp2">LMP2</h2>
    <div class="grid">
        <?php if (!empty($pilotesLMP2)): ?>
            <?php foreach ($pilotesLMP2 as $pilote): ?>
                <div class="carte">
                    <img src="<?= htmlspecialchars($pilote['image']) ?>" alt="<?= htmlspecialchars($pilote['nom']) ?>">
                    <h3><?= htmlspecialchars($pilote['nom']) ?></h3>
                    <p>Nationalité : <?= htmlspecialchars($pilote['nationalite']) ?></p>
                    <p>Équipe : <?= htmlspecialchars($pilote['equipe']) ?></p>
                    <p>Voiture : <?= htmlspecialchars($pilote['voiture']) ?></p>
                    <p>Catégorie : <?= htmlspecialchars($pilote['categorie']) ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucun pilote LMP2 disponible.</p>
        <?php endif; ?>
    </div>

    <!-- Section LMGT3 -->
    <h2 id="lmgt3">LMGT3</h2>
    <div class="grid">
        <?php if (!empty($pilotesLMGT3)): ?>
            <?php foreach ($pilotesLMGT3 as $pilote): ?>
                <div class="carte">
                    <img src="<?= htmlspecialchars($pilote['image']) ?>" alt="<?= htmlspecialchars($pilote['nom']) ?>">
                    <h3><?= htmlspecialchars($pilote['nom']) ?></h3>
                    <p>Nationalité : <?= htmlspecialchars($pilote['nationalite']) ?></p>
                    <p>Équipe : <?= htmlspecialchars($pilote['equipe']) ?></p>
                    <p>Numéro de voiture : <?= htmlspecialchars($pilote['numero_voiture']) ?></p>
                    <p>Catégorie : <?= htmlspecialchars($pilote['categorie']) ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucun pilote LMGT3 disponible.</p>
        <?php endif; ?>
    </div>

</div>

<!-- Bouton pour revenir rapidement en haut de la page -->
<button id="backToTop" class="back-to-top">⬆️</button>

<script>
    const backToTopBtn = document.getElementById("backToTop");

    // Affiche le bouton "Retour en haut" au scroll > 300px
    window.addEventListener("scroll", () => {
        if (window.scrollY > 300) {
            backToTopBtn.style.display = "block";
        } else {
            backToTopBtn.style.display = "none";
        }
    });

    // Scroll fluide vers le haut de la page au clic sur le bouton
    backToTopBtn.addEventListener("click", () => {
        window.scrollTo({
            top: 0,
            behavior: "smooth"
        });
    });
</script>

<script type="text/javascript" src="script.js"></script> <!-- Inclusion du script JS externe -->

</body>

</html>