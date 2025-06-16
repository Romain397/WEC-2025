<?php
session_start();
require_once 'RaceController.php';

$raceController = new RaceController();
$message = "";

// Gestion des messages d'inscription
if (isset($_SESSION['registration_message'])) {
    $message = $_SESSION['registration_message'];
    unset($_SESSION['registration_message']);
}

// Récupération de l'année sélectionnée (par défaut : 2025)
$year = isset($_GET['year']) && ($_GET['year'] == 2024 || $_GET['year'] == 2025) ? intval($_GET['year']) : 2025;

// Récupération des courses
$races = $raceController->getAllRaces();
$saison2024 = [];
$saison2025 = [];

foreach ($races as $race) {
    $raceYear = date('Y', strtotime($race['race_date']));
    if ($raceYear == 2024) {
        $saison2024[] = $race;
    } elseif ($raceYear == 2025) {
        $saison2025[] = $race;
    }
}
?>

<?php
require "header.php";
?>

<div class="top">
    <h1>Calendrier des Courses</h1>
</div>

<!-- Menu de navigation -->
<div class="menu">
    <button onclick="window.location.href='index.php?year=2025'">Saison 2025</button>
    <button onclick="window.location.href='index.php?year=2024'">Saison 2024</button>
    <button onclick="window.location.href='circuits.php'">Circuits</button>
    <button onclick="window.location.href='voitures.php'">Voitures</button>
    <button onclick="window.location.href='marques.php'">Constructeurs</button>
    <button onclick="window.location.href='pilotes.php'">Pilotes</button>
</div>

<!-- Saison sélectionnée -->
<div class="races-container">
    <h2>Saison <?= $year ?></h2>

    <?php
    $currentSeason = ($year == 2024) ? $saison2024 : $saison2025;

    if (!empty($currentSeason)): ?>
        <div class="grid">
            <?php foreach ($currentSeason as $race): ?>
                <div class="carte">
                    <?php if (!empty($race['image_url'])): ?>
                        <img src="<?= htmlspecialchars($race['image_url']) ?>" alt="Image de la course">
                    <?php endif; ?>

                    <?php if (!empty($race['video_url'])): ?>
                        <div>
                            <iframe width="300" height="180" src="<?= htmlspecialchars($race['video_url']) ?>" frameborder="0" allowfullscreen></iframe>
                        </div>
                    <?php endif; ?>
                    <h3><?= htmlspecialchars($race['race_name']) ?></h3>
                    <p>Circuit : <?= htmlspecialchars($race['circuit']) ?></p>
                    <p>Catégorie : <?= htmlspecialchars($race['category']) ?></p>
                    <p>Date : <?= htmlspecialchars($race['race_date']) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>Aucune course prévue pour la saison <?= $year ?>.</p>
    <?php endif; ?>
</div>

<script type="text/javascript" src="script.js"></script>
</body>

</html>