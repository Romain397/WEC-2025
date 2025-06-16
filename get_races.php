<?php
// Inclusion du contrôleur qui gère les courses
require_once 'RaceController.php';

// Définir le type de contenu comme JSON
header('Content-Type: application/json');

// Vérification de la présence de l'année dans les paramètres GET
$year = isset($_GET['year']) ? intval($_GET['year']) : null;

// Si l'année n'est pas spécifiée, retourner une erreur
if (!$year) {
    echo json_encode(['error' => 'Année non spécifiée.']);
    exit;
}

// Instanciation du contrôleur
$raceController = new RaceController();

// Récupération des courses pour l'année spécifiée
$races = $raceController->getRacesByYear($year);

// Retourne les données au format JSON
echo json_encode($races);
