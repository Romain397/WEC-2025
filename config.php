<?php

class Database
{
    // Informations de connexion à la base de données
    private $host = 'localhost';              // Hôte local (serveur MySQL)
    private $dbname = 'WEC_2025';             // Nom de la base de données (à adapter si besoin)
    private $user = 'root';                   // Nom d'utilisateur MySQL (par défaut "root" sous WAMP/MAMP)
    private $pass = '';                       // Mot de passe (souvent vide en local)
    private $pdo;                             // Objet PDO pour la connexion

    /**
     * Constructeur - établit la connexion à la base de données dès l'instanciation de la classe
     */
    public function __construct()
    {
        try {
            // Création d'une nouvelle connexion PDO
            $this->pdo = new PDO("mysql:host={$this->host};dbname={$this->dbname}", $this->user, $this->pass);

            // Définition des attributs PDO pour gérer les erreurs et le mode de récupération
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);       // Affiche les erreurs comme exceptions
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);  // Récupère les résultats sous forme de tableau associatif
        } catch (PDOException $e) {
            // En cas d'erreur de connexion, affichage du message et arrêt du script
            echo "Database connection failed: " . $e->getMessage();
            exit;
        }
    }

    /**
     * Méthode publique pour récupérer l'objet PDO depuis l'extérieur de la classe
     *
     * @return PDO La connexion à la base de données
     */
    public function getConnection()
    {
        return $this->pdo;
    }
}
