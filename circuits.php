<?php
// Démarrage de la session pour gérer les messages ou données utilisateur
session_start();
$message = "";

// Si un message d'inscription existe en session, on le récupère et on le supprime après
if (isset($_SESSION['registration_message'])) {
    $message = $_SESSION['registration_message'];
    unset($_SESSION['registration_message']);
}

// Chemin vers le fichier JSON contenant les circuits
$jsonFile = __DIR__ . '/api/api_circuits.json';

// Si le fichier n'existe pas, on affiche une erreur
if (!file_exists($jsonFile)) {
    $message = "Erreur : Le fichier des circuits est introuvable.";
    $circuits = [];
} else {
    // Lecture et décodage du fichier JSON
    $jsonContent = file_get_contents($jsonFile);
    $circuitsData = json_decode($jsonContent, true);
    $circuits = $circuitsData['circuits'] ?? [];
}

// Vérifie si une année est passée en paramètre et qu’elle est valide (2024 ou 2025), sinon 2025 par défaut
$year = isset($_GET['year']) && ($_GET['year'] == 2024 || $_GET['year'] == 2025) ? intval($_GET['year']) : 2025;
?>

<?php
// Inclusion de l'en-tête HTML commun à toutes les pages
require "header.php";
?>

<div class="top">
    <h1>Circuits 2025</h1>
</div>

<!-- Menu de navigation dynamique -->
<div class="menu">
    <button onclick="navigateToPage('index', 2025)">Saison 2025</button>
    <button onclick="navigateToPage('index', 2024)">Saison 2024</button>
    <button onclick="navigateToPage('circuits', <?= $year ?>)">Circuits</button>
    <button onclick="navigateToPage('voitures', <?= $year ?>)">Voitures</button>
    <button onclick="navigateToPage('marques', <?= $year ?>)">Constructeurs</button>
    <button onclick="navigateToPage('pilotes', <?= $year ?>)">Pilotes</button>
</div>

<!-- Affichage d'un éventuel message d'erreur ou de confirmation -->
<?php if ($message): ?>
    <div style="color: red; margin-bottom: 10px;">
        <?= htmlspecialchars($message) ?>
    </div>
<?php endif; ?>

<h2>Liste des Circuits - Saison <?= $year ?></h2>

<div class="grid">
    <?php if (!empty($circuits)): ?>
        <?php foreach ($circuits as $circuit): ?>
            <div class="carte">
                <?php if (!empty($circuit['images']) && is_array($circuit['images'])): ?>
                    <!-- Diaporama d'images du circuit -->
                    <div class="slideshow-container">
                        <?php foreach ($circuit['images'] as $index => $image): ?>
                            <div class="slides fade">
                                <img src="<?= htmlspecialchars($image) ?>" alt="Image de <?= htmlspecialchars($circuit['nom']) ?>">
                            </div>
                        <?php endforeach; ?>

                        <?php if (count($circuit['images']) > 1): ?>
                            <!-- Boutons de navigation du diaporama -->
                            <a class="prev">❮</a>
                            <a class="next">❯</a>
                        <?php endif; ?>
                    </div>

                    <!-- Points indicateurs du nombre d'images -->
                    <div class="dots-container">
                        <?php foreach ($circuit['images'] as $index => $image): ?>
                            <span class="dot"></span>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <!-- Informations textuelles sur le circuit -->
                <h3><?= htmlspecialchars($circuit['nom']) ?></h3>
                <p>Pays : <?= htmlspecialchars($circuit['pays']) ?></p>
                <p>Longueur : <?= htmlspecialchars($circuit['longueur_km']) ?> km</p>
                <p>Histoire : <?= htmlspecialchars($circuit['histoire']) ?></p>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Aucun circuit disponible.</p>
    <?php endif; ?>
</div>

<!-- Inclusion du JavaScript -->
<script type="text/javascript" src="script.js"></script>

</body>

</html>