<?php
session_start(); // Démarrage de la session pour accéder aux variables de session

// Vérifie si l'utilisateur est administrateur
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    echo "Accès refusé. Cette page est réservée aux administrateurs.";
    exit; // Interrompt l'exécution du script si l'utilisateur n'est pas admin
}

// Inclusion du contrôleur des courses
require_once 'RaceController.php';

// Création de l'objet contrôleur de course
$raceController = new RaceController();
$race = null;       // Variable qui contiendra les données de la course à modifier
$message = "";      // Message à afficher après soumission

// Vérifie si un identifiant de course est fourni dans l'URL (GET)
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Sécurisation de l'ID
    $race = $raceController->getRaceById($id); // Récupère la course depuis le contrôleur
}

// Traitement du formulaire de mise à jour (si soumis)
if (isset($_POST['updateRace'])) {
    $videoUrl = $_POST['videoUrl'];

    // Si le lien est un lien YouTube classique, le convertir en lien "embed"
    if (!empty($videoUrl) && strpos($videoUrl, 'watch?v=') !== false) {
        $videoUrl = str_replace('watch?v=', 'embed/', $videoUrl);
    }

    // Prépare les nouvelles données à enregistrer
    $updatedData = [
        'id'       => $id,
        'raceName' => $_POST['raceName'],
        'circuit'  => $_POST['circuit'],
        'category' => $_POST['category'],
        'raceDate' => $_POST['raceDate'],
        'videoUrl' => $videoUrl,
        'imageUrl' => $_POST['imageUrl']
    ];

    // Met à jour la course via le contrôleur
    if ($raceController->updateRace($updatedData)) {
        $message = "Course mise à jour avec succès.";
    } else {
        $message = "Erreur lors de la mise à jour de la course.";
    }
}
?>

<?php require "header.php"; // Inclusion du header commun 
?>
<div class="space-top"></div>

<?php if ($message): ?>
    <!-- Affiche un message de succès ou d'erreur -->
    <div style="color: green; margin-bottom: 10px;">
        <?= htmlspecialchars($message) ?>
    </div>
<?php endif; ?>

<?php if ($race): ?>
    <!-- Formulaire de mise à jour de la course -->
    <form method="post" action="">
        <label for="raceName">Nom de la course :</label><br>
        <input type="text" name="raceName" value="<?= htmlspecialchars($race['race_name'] ?? '') ?>" required><br>

        <label for="circuit">Circuit :</label><br>
        <input type="text" name="circuit" value="<?= htmlspecialchars($race['circuit'] ?? '') ?>" required><br>

        <label for="category">Catégorie :</label><br>
        <input type="text" name="category" value="<?= htmlspecialchars($race['category'] ?? '') ?>" required><br>

        <label for="raceDate">Date :</label><br>
        <input type="date" name="raceDate" value="<?= htmlspecialchars($race['race_date'] ?? '') ?>" required><br>

        <label for="videoUrl">URL Vidéo (YouTube) :</label><br>
        <input type="text" name="videoUrl" value="<?= htmlspecialchars($race['video_url'] ?? '') ?>"><br>

        <label for="imageUrl">URL Image :</label><br>
        <input type="text" name="imageUrl" value="<?= htmlspecialchars($race['image_url'] ?? '') ?>"><br>

        <input type="submit" name="updateRace" value="Mettre à jour">
    </form>
<?php else: ?>
    <!-- Si la course n'est pas trouvée ou aucun ID n'est fourni -->
    <p>Course introuvable ou identifiant non spécifié.</p>
<?php endif; ?>

<!-- Inclusion du script JS -->
<script type="text/javascript" src="script.js"></script>
</body>

</html>