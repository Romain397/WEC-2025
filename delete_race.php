<?php
// Démarre la session pour accéder aux variables de session
session_start();

// Vérifie si l'utilisateur est administrateur (sécurité)
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    echo "Accès refusé. Cette page est réservée aux administrateurs.";
    exit; // Interrompt l'exécution si l'utilisateur n'est pas admin
}

// Inclusion du contrôleur des courses
require_once 'RaceController.php';

// Création d'une instance du contrôleur pour gérer la suppression
$raceController = new RaceController();
$message = ""; // Message de confirmation ou d'erreur

// Vérifie si un identifiant (ID) de course est fourni dans l'URL
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Conversion en entier pour sécurité

    // Tente de supprimer la course avec l'ID donné
    if ($raceController->deleteRace($id)) {
        $message = "Course supprimée avec succès.";
    } else {
        $message = "Erreur lors de la suppression de la course.";
    }
}

// Redirige vers la page de gestion des courses avec un message (succès ou erreur)
header("Location: manage_races.php?message=" . urlencode($message));
exit; // Termine le script après la redirection
