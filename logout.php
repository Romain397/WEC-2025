<?php
session_start(); // Démarre la session ou reprend la session existante
session_unset(); // Supprime toutes les variables de session
session_destroy(); // Détruit complètement la session
header("Location: index.php"); // Redirige vers la page d'accueil
exit; // Termine le script pour éviter tout traitement supplémentaire
