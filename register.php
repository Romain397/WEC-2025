<?php
session_start(); // Démarre la session pour stocker les messages ou données persistantes entre pages

require_once 'UserController.php'; // Inclusion du contrôleur utilisateur (logique métier)

$userController = new UserController(); // Instanciation du contrôleur pour gérer les utilisateurs
$message = ""; // Variable pour stocker un message d’erreur ou de succès à afficher

// Traitement du formulaire d’inscription lors de la soumission
if (isset($_POST['register'])) {
    // Récupération et nettoyage des données du formulaire
    $firstName = trim($_POST['first_name']);
    $lastName = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Validation des données : vérifier que tous les champs sont remplis
    if (empty($firstName) || empty($lastName) || empty($email) || empty($password)) {
        $message = "Tous les champs doivent être remplis.";
    }
    // Validation du format de l’email
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "L'adresse email est invalide.";
    }
    // Vérification que l’email n’est pas déjà utilisé dans la base
    elseif ($userController->isEmailExists($email)) {
        $message = "Cet email est déjà utilisé.";
    } else {
        // Préparation des données utilisateur à enregistrer
        $userData = [
            'firstName' => $firstName,
            'lastName' => $lastName,
            'email' => $email,
            'password' => $password, // A noter : idéalement, le mot de passe devrait être hashé ici ou dans le modèle
            'isAdmin' => 0 // Nouveau compte utilisateur standard (pas administrateur)
        ];

        // Appel au contrôleur pour ajouter l’utilisateur dans la base de données
        if ($userController->addUser($userData)) {
            // Si réussite, on stocke un message de succès en session et redirige vers la page d’accueil
            $_SESSION['registration_message'] = "Inscription réussie. Vous pouvez maintenant vous connecter.";
            header('Location: index.php');
            exit; // On arrête le script après la redirection
        } else {
            // En cas d’erreur lors de l’insertion, message d’erreur
            $message = "Erreur lors de l'inscription.";
        }
    }
}
?>

<?php
require "header.php"; // Inclusion de l’en-tête HTML commun
?>

<div class="space-top"></div>

<!-- Affichage conditionnel du message d’erreur ou d’information -->
<?php if ($message): ?>
    <div style="color: red; margin-bottom: 10px;">
        <?= htmlspecialchars($message) // Affiche le message en échappant pour éviter les injections 
        ?>
    </div>
<?php endif; ?>

<!-- Formulaire d’inscription utilisateur -->
<div class="login-container">
    <form method="post" action="">
        <div class="form-group">
            <label for="first_name">Prénom :</label><br>
            <input type="text" name="first_name" required>
        </div>

        <div class="form-group">
            <label for="last_name">Nom :</label><br>
            <input type="text" name="last_name" required>
        </div>

        <div class="form-group">
            <label for="email">Email :</label><br>
            <input type="email" name="email" required>
        </div>

        <div class="form-group">
            <label for="password">Mot de passe :</label><br>
            <input type="password" name="password" required>
        </div>

        <div class="form-group">
            <input type="submit" name="register" value="S'inscrire">
        </div>

        <div style="margin-top: 20px;">
            <button onclick="window.location.href='index.php'">Retour à l'accueil</button>
        </div>
    </form>
</div>

<!-- Inclusion d’un fichier JS externe (ex: gestion UI) -->
<script type="text/javascript" src="script.js"></script>
</body>

</html>