<?php
session_start(); // Démarre la session pour gérer les messages et autres données session
$message = "";

// Vérifie s'il y a un message d'inscription stocké en session (ex: confirmation ou erreur)
if (isset($_SESSION['registration_message'])) {
    $message = $_SESSION['registration_message'];
    unset($_SESSION['registration_message']); // Supprime le message pour qu'il ne réapparaisse pas
}

// Chemin vers le fichier JSON contenant les données des marques
$jsonFile = __DIR__ . '/api/api_marque.json';

// Vérifie si le fichier JSON existe
if (!file_exists($jsonFile)) {
    // Message d'erreur si le fichier est introuvable
    $message = "Erreur : Le fichier des marques est introuvable.";
    $marques = []; // Initialise un tableau vide pour éviter les erreurs
} else {
    // Lit le contenu du fichier JSON
    $jsonContent = file_get_contents($jsonFile);
    // Décode le JSON en tableau associatif PHP
    $marquesData = json_decode($jsonContent, true);
    // Récupère la liste des marques, ou un tableau vide si la clé 'marques' n'existe pas
    $marques = $marquesData['marques'] ?? [];
}
?>

<?php
require "header.php"; // Inclusion du header commun (menu, styles, etc.)
?>

<div class="top">
    <h1>Constructeurs</h1>
</div>

<!-- Menu de navigation pour accéder aux différentes pages -->
<div class="menu">
    <button onclick="window.location.href='index.php?year=2025'">Saison 2025</button>
    <button onclick="window.location.href='index.php?year=2024'">Saison 2024</button>
    <button onclick="window.location.href='circuits.php'">Circuits</button>
    <button onclick="window.location.href='voitures.php'">Voitures</button>
    <button onclick="window.location.href='marques.php'">Constructeurs</button>
    <button onclick="window.location.href='pilotes.php'">Pilotes</button>
</div>

<!-- Affiche un message d'erreur ou d'information si défini -->
<?php if ($message): ?>
    <div style="color: red; margin-bottom: 10px;">
        <?= htmlspecialchars($message) ?>
    </div>
<?php endif; ?>

<h2>Liste des Constructeurs</h2>

<div class="grid">
    <?php if (!empty($marques)): ?>
        <?php foreach ($marques as $marque): ?>
            <div class="carte">
                <?php if (!empty($marque['logo'])): ?>
                    <div>
                        <!-- Affiche le logo de la marque avec attributs sécurisés -->
                        <img src="<?= htmlspecialchars($marque['logo']) ?>" width="200" alt="<?= htmlspecialchars($marque['nom']) ?>" class="img-hover">
                    </div>
                <?php endif; ?>
                <!-- Affiche le nom de la marque -->
                <h3><?= htmlspecialchars($marque['nom']) ?></h3>
                <!-- Affiche le pays d'origine -->
                <p>Pays : <?= htmlspecialchars($marque['pays']) ?></p>
                <!-- Affiche l'histoire de la marque -->
                <p><?= htmlspecialchars($marque['histoire']) ?></p>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Aucune marque disponible.</p> <!-- Message si aucune marque n'est trouvée -->
    <?php endif; ?>
</div>

<!-- Inclusion du script JS pour interactions éventuelles -->
<script type="text/javascript" src="script.js"></script>
</body>

</html>