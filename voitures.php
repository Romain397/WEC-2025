<?php
session_start(); // Démarre la session pour récupérer les messages d'inscription ou autres données de session
$message = "";

// Gestion des messages d'inscription (ou autres notifications)
// Si un message de session est défini, on le récupère puis on le supprime pour éviter de l'afficher plusieurs fois
if (isset($_SESSION['registration_message'])) {
    $message = $_SESSION['registration_message'];
    unset($_SESSION['registration_message']);
}

// Chargement des données JSON des voitures
$jsonFile = __DIR__ . '/api/api_voitures.json';

// Vérification que le fichier JSON existe
if (!file_exists($jsonFile)) {
    $message = "Erreur : Le fichier des voitures est introuvable.";
    $voitures = []; // On initialise un tableau vide pour éviter les erreurs plus tard
} else {
    // Lecture du contenu du fichier JSON
    $jsonContent = file_get_contents($jsonFile);
    // Décodage du JSON en tableau associatif PHP
    $voituresData = json_decode($jsonContent, true);
    // On récupère la liste des voitures, ou un tableau vide si la clé 'voitures' n'existe pas
    $voitures = $voituresData['voitures'] ?? [];
}
?>

<?php
require "header.php"; // Inclusion de l'en-tête HTML (balises <head>, menu, etc.)
?>

<div class="top">
    <h1>Voitures</h1>
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

<!-- Affichage d'un message d'erreur ou d'information si présent -->
<?php if ($message): ?>
    <div style="color: red; margin-bottom: 10px;">
        <?= htmlspecialchars($message) // Protection contre les injections XSS 
        ?>
    </div>
<?php endif; ?>

<h2>Liste des Voitures</h2>

<!-- Grille d'affichage des voitures -->
<div class="grid">
    <?php if (!empty($voitures)): ?>
        <?php foreach ($voitures as $voiture): ?>
            <div class="carte">
                <!-- Si la voiture a des images, on affiche un carrousel -->
                <?php if (!empty($voiture['images'])): ?>
                    <div class="slideshow-container">
                        <?php foreach ($voiture['images'] as $index => $image): ?>
                            <div class="slides fade">
                                <img src="<?= htmlspecialchars($image) ?>" alt="Image voiture <?= $index + 1 ?>" class="car">
                            </div>
                        <?php endforeach; ?>

                        <!-- Flèches de navigation du carrousel si plusieurs images -->
                        <?php if (count($voiture['images']) > 1): ?>
                            <a class="prev">❮</a>
                            <a class="next">❯</a>
                        <?php endif; ?>
                    </div>

                    <!-- Points indicateurs sous le carrousel -->
                    <div class="dots-container">
                        <?php foreach ($voiture['images'] as $index => $image): ?>
                            <span class="dot"></span>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <!-- Informations sur la voiture -->
                <h3><?= htmlspecialchars($voiture['constructeur']) ?> - <?= htmlspecialchars($voiture['modele']) ?></h3>
                <p>Catégorie : <?= htmlspecialchars($voiture['categorie']) ?></p>
                <p>Motorisation : <?= htmlspecialchars($voiture['motorisation']) ?></p>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Aucune voiture disponible.</p>
    <?php endif; ?>
</div>

<!-- Inclusion du script JS (par exemple pour gérer le carrousel) -->
<script type="text/javascript" src="script.js"></script>
</body>

</html>