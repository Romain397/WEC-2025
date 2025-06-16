<?php
// Démarre la session pour accéder aux variables de session
session_start();

// Vérifie si l'utilisateur est un administrateur
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    echo "Accès refusé."; // Message si l'utilisateur n'est pas autorisé
    exit; // Arrête l'exécution du script
}

// Inclut le contrôleur des utilisateurs (doit contenir la méthode deleteUser)
require_once 'UserController.php';

// Crée une instance du contrôleur utilisateur
$userController = new UserController();

// Vérifie si un identifiant d'utilisateur a été envoyé via une requête POST
if (isset($_POST['userId'])) {
    $userId = intval($_POST['userId']); // Sécurise l'ID reçu (en entier)

    // Appelle la méthode pour supprimer l'utilisateur
    $userController->deleteUser($userId);

    // Message de retour simple (utilisable via JavaScript)
    echo "Utilisateur supprimé.";
}
