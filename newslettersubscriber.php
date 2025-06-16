<?php

require_once 'config.php'; // Inclusion de la configuration (connexion DB)

class NewsletterSubscriber
{
    private $id;    // Identifiant unique de l'abonné (généralement auto-increment en DB)
    private $email; // Email de l'abonné

    private $pdo;   // Objet PDO pour la connexion à la base de données

    public function __construct()
    {
        // Création d'une instance Database pour obtenir la connexion PDO
        $db = new Database();
        $this->pdo = $db->getConnection();
    }

    /**
     * Hydrater l'objet avec un tableau de données
     * Parcourt les clés du tableau, appelle le setter correspondant si il existe
     * @param array $data Tableau associatif ['email' => 'exemple@example.com', ...]
     */
    public function hydrate(array $data)
    {
        foreach ($data as $key => $value) {
            // Compose le nom du setter (ex: setEmail)
            $method = 'set' . ucfirst($key);
            // Vérifie si le setter existe puis l'appelle avec la valeur
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    /**
     * Ajouter un abonné dans la base de données
     * Prépare et exécute une requête d'insertion
     * @return bool True si insertion réussie, false sinon
     */
    public function addSubscriber()
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO newsletter_subscribers (email) 
            VALUES (?)
        ");
        return $stmt->execute([$this->email]);
    }

    /**
     * Obtenir la liste complète des abonnés
     * @return array Tableau des abonnés sous forme associative
     */
    public function getAllSubscribers()
    {
        $stmt = $this->pdo->prepare("SELECT * FROM newsletter_subscribers");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Vérifier si un email est déjà abonné à la newsletter
     * @param string $email Email à vérifier
     * @return bool True si l'email existe en base, false sinon
     */
    public function isSubscribed($email)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM newsletter_subscribers WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch() !== false;
    }

    /**
     * Supprimer un abonné selon son email
     * @param string $email Email de l'abonné à supprimer
     * @return bool True si suppression réussie, false sinon
     */
    public function deleteSubscriber($email)
    {
        $stmt = $this->pdo->prepare("DELETE FROM newsletter_subscribers WHERE email = ?");
        return $stmt->execute([$email]);
    }

    /**
     * Getters & Setters
     */

    public function getId()
    {
        return $this->id;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }
}
