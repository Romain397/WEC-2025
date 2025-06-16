<?php
require_once 'UserController.php';
session_start();

$userController = new UserController();
$message = "";

// Gestion du formulaire de connexion
if (isset($_POST['login'])) {
    $email = trim($_POST['email']);       // Récupération de l'email et suppression des espaces superflus
    $password = trim($_POST['password']); // Récupération du mot de passe et suppression des espaces superflus

    // Tentative de connexion via UserController
    if ($userController->login($email, $password)) {
        // Vérification si l'utilisateur est admin
        if ($_SESSION['is_admin'] == 1) {
            // Redirection vers la page d'administration des courses
            header('Location: manage_races.php');
            exit;
        } else {
            // Message si l'utilisateur n'a pas les droits admin
            $message = "Accès refusé. Vous n'êtes pas administrateur.";
        }
    } else {
        // Message en cas d'identifiants incorrects
        $message = "Identifiants incorrects.";
    }
}
?>

<?php
require "header.php"; // Inclusion du header commun
?>

<div class="space-top">
</div>

<?php if ($message): ?>
    <div style="color: red;"><?= htmlspecialchars($message) ?></div> <!-- Affichage du message d'erreur en rouge -->
<?php endif; ?>

<div class="login-container">
    <form method="post" action="">
        <div>
            <label for="email">Email :</label>
            <input type="email" name="email" required> <!-- Champ email requis -->
        </div>

        <div>
            <label for="password">Mot de passe :</label>
            <input type="password" name="password" required> <!-- Champ mot de passe requis -->
        </div>

        <div>
            <input type="submit" name="login" value="Connexion"> <!-- Bouton de soumission -->
        </div>
    </form>

    <!-- Bouton pour retourner à la page d'accueil -->
    <div style="margin-top: 20px;">
        <button onclick="window.location.href='index.php'">Retour à l'accueil</button>
    </div>
</div>

<script type="text/javascript" src="script.js"></script>
</body>

</html>