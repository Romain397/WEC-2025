<?php
session_start();

// Vérifie si l'utilisateur est admin, sinon interdit l'accès
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    echo "Accès refusé. Cette page est réservée aux administrateurs.";
    exit;
}

require_once 'RaceController.php';
require_once 'UserController.php';

$raceController = new RaceController();
$userController = new UserController();
$message = "";

// Si le formulaire d'ajout de course est soumis
if (isset($_POST['addRace'])) {
    // Récupère les données du formulaire dans un tableau
    $raceData = [
        'raceName' => $_POST['raceName'],
        'circuit' => $_POST['circuit'],
        'category' => $_POST['category'],
        'raceDate' => $_POST['raceDate'],
        'videoUrl' => $_POST['videoUrl'],
        'imageUrl' => $_POST['imageUrl']
    ];

    // Tente d'ajouter la course via le controller
    if ($raceController->addRace($raceData)) {
        $message = "Course ajoutée avec succès.";
    } else {
        $message = "Erreur lors de l'ajout de la course.";
    }
}

// Si le formulaire de mise à jour des rôles utilisateurs est soumis
if (isset($_POST['updateUsers'])) {
    // Parcourt les utilisateurs soumis
    foreach ($_POST['userId'] as $index => $userId) {
        // Vérifie si la checkbox admin est cochée pour cet utilisateur
        $isAdmin = isset($_POST['isAdmin'][$index]) ? 1 : 0;
        // Met à jour le rôle admin de l'utilisateur
        $userController->updateUserRole($userId, $isAdmin);
    }
    $message = "Modifications des rôles effectuées avec succès.";
}

// Récupère toutes les courses et tous les utilisateurs pour affichage
$races = $raceController->getAllRaces();
$users = $userController->getAllUsers();
?>

<?php
require "header.php"; // Inclusion de l'en-tête commun
?>

<div class="space-top"></div>

<!-- Boutons pour afficher la gestion des courses ou des utilisateurs -->
<div class="buttons">
    <button onclick="toggleSection('courses')">Gestion des Courses</button>
    <button onclick="toggleSection('users')">Gestion des Utilisateurs</button>
</div>

<!-- Affiche un message (succès/erreur) si défini -->
<?php if ($message): ?>
    <div style="color: green; margin-bottom: 10px;">
        <?= htmlspecialchars($message) ?>
    </div>
<?php endif; ?>

<!-- Section Gestion des Courses -->
<div id="coursesSection" style="display: block;">
    <h2>Gestion des Courses</h2>

    <h3>Liste des Courses</h3>
    <?php if (!empty($races)): ?>
        <table border="1">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Circuit</th>
                    <th>Catégorie</th>
                    <th>Date</th>
                    <th>Médias</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($races as $race): ?>
                    <tr>
                        <td><?= htmlspecialchars($race['race_name']) ?></td>
                        <td><?= htmlspecialchars($race['circuit']) ?></td>
                        <td><?= htmlspecialchars($race['category']) ?></td>
                        <td><?= htmlspecialchars($race['race_date']) ?></td>
                        <td>
                            <?php
                            // Liste des médias disponibles (vidéo/image)
                            $media = [];
                            if (!empty($race['video_url'])) $media[] = "Vidéo";
                            if (!empty($race['image_url'])) $media[] = "Image";
                            // Affiche la liste séparée par " / " ou "Aucun"
                            echo !empty($media) ? implode(" / ", $media) : "Aucun";
                            ?>
                        </td>
                        <td>
                            <!-- Liens pour modifier ou supprimer la course -->
                            <a href="edit_race.php?id=<?= $race['id'] ?>">Modifier</a>
                            <a href="delete_race.php?id=<?= $race['id'] ?>" onclick="return confirm('Confirmer la suppression ?')">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Aucune course disponible.</p>
    <?php endif; ?>

    <!-- Formulaire d'ajout d'une nouvelle course -->
    <h3>Ajouter une Course</h3>
    <form method="post" action="">
        <input type="text" name="raceName" placeholder="Nom de la course" required><br>
        <input type="text" name="circuit" placeholder="Circuit" required><br>
        <input type="text" name="category" placeholder="Catégorie" required><br>
        <input type="date" name="raceDate" required><br>
        <input type="text" name="videoUrl" placeholder="URL Vidéo"><br>
        <input type="text" name="imageUrl" placeholder="URL Image"><br>
        <input type="submit" name="addRace" value="Ajouter">
    </form>
</div>

<!-- Section Gestion des Utilisateurs -->
<div id="usersSection" style="display: none;">
    <h2>Gestion des Utilisateurs</h2>

    <form method="post" action="">
        <table border="1">
            <thead>
                <tr>
                    <th>Email</th>
                    <th>Admin</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $index => $user): ?>
                    <tr id="user-<?= $user['id'] ?>">
                        <td><?= htmlspecialchars($user['email']) ?></td>
                        <td>
                            <!-- Checkbox pour définir si utilisateur est admin -->
                            <input type="hidden" name="userId[]" value="<?= $user['id'] ?>">
                            <label>
                                <input type="checkbox" name="isAdmin[<?= $index ?>]" <?= $user['is_admin'] ? 'checked' : '' ?>>
                                Admin
                            </label>
                        </td>
                        <td>
                            <!-- Bouton suppression utilisateur avec JS AJAX -->
                            <button type="button" onclick="deleteUser(<?= $user['id'] ?>)">Supprimer</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Bouton pour enregistrer les modifications des rôles -->
        <div style="margin-top: 10px;">
            <input type="submit" name="updateUsers" value="Sauvegarder">
        </div>
    </form>
</div>

<script src="script.js"></script>
<script>
    // Affiche ou masque les sections Courses et Utilisateurs selon bouton cliqué
    function toggleSection(section) {
        document.getElementById('coursesSection').style.display = section === 'courses' ? 'block' : 'none';
        document.getElementById('usersSection').style.display = section === 'users' ? 'block' : 'none';
    }

    // Fonction pour supprimer un utilisateur via AJAX sans recharger la page
    function deleteUser(userId) {
        if (confirm("Confirmer la suppression de l'utilisateur ?")) {
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "delete_user.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // Supprime la ligne du tableau correspondante
                    document.getElementById("user-" + userId).remove();
                }
            };
            xhr.send("userId=" + userId);
        }
    }
</script>
</body>

</html>