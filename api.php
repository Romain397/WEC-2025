<?php
// Démarre la session PHP (utile pour suivre les utilisateurs, stocker des messages, etc.)
session_start();
?>

<!DOCTYPE html>
<html lang="fr-FR"> <!-- Déclaration du type de document HTML en langue française -->

<head>
    <meta charset="UTF-8"> <!-- Encodage des caractères pour gérer les accents et caractères spéciaux -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- Optimisation pour Internet Explorer -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Pour un affichage responsive sur mobile et tablette -->
    <title>API - WEC 2025</title> <!-- Titre de la page affiché dans l’onglet du navigateur -->

    <!-- Lien vers la feuille de style CSS externe -->
    <link rel="stylesheet" href="style.css">

    <!-- Lien vers le fichier JavaScript externe (defer = exécuter après le chargement complet du HTML) -->
    <script src="script.js" defer></script>
</head>

<body>

    <!-- En-tête principale contenant le titre et le menu -->
    <div class="header">
        <h1>WEC 2025 - API Explorer</h1> <!-- Titre principal de la page -->

        <!-- Menu de navigation avec boutons pour charger différentes catégories d’API -->
        <div class="menu">
            <button onclick="loadAPI('circuits')">Circuits</button> <!-- Charge les données des circuits -->
            <button onclick="loadAPI('voitures')">Voitures</button> <!-- Charge les données des voitures -->
            <button onclick="loadAPI('constructeurs')">Constructeurs</button> <!-- Charge les données des constructeurs -->
            <button onclick="loadAPI('pilotes')">Pilotes</button> <!-- Charge les données des pilotes -->
        </div>
    </div>

    <!-- Conteneur principal du contenu dynamique -->
    <div class="container">
        <div id="content" class="content-container">
            <h2>Bienvenue dans l'API Explorer</h2> <!-- Message d'accueil par défaut -->
            <p>Sélectionnez une catégorie pour afficher les données correspondantes.</p>
        </div>
    </div>

</body>

</html>