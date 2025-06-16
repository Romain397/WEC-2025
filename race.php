<?php

require_once 'config.php'; // Inclusion du fichier de configuration, notamment pour la connexion à la base de données

class Race
{
    private $pdo;          // Instance PDO pour la connexion à la base de données
    private $id;           // Identifiant unique d'une course
    private $raceName;     // Nom de la course
    private $circuit;      // Nom du circuit où se déroule la course
    private $category;     // Catégorie de la course (ex: Hypercar, LMP2, etc.)
    private $raceDate;     // Date à laquelle la course a lieu
    private $videoUrl;     // URL d'une vidéo associée à la course (ex: résumé)
    private $imageUrl;     // URL d'une image associée à la course

    // Constructeur : initialise la connexion PDO en instanciant la classe Database
    public function __construct()
    {
        $db = new Database();
        $this->pdo = $db->getConnection();
    }

    // Méthode pour hydrater l'objet avec un tableau associatif de données
    public function hydrate(array $data)
    {
        foreach ($data as $key => $value) {
            // Construit le nom du setter à appeler à partir de la clé (ex: 'raceName' => 'setRaceName')
            $method = 'set' . ucfirst($key);
            if (method_exists($this, $method)) {
                $this->$method($value); // Appelle le setter correspondant
            }
        }
    }

    /**
     * Récupère toutes les courses d'une année donnée, triées par date croissante
     */
    public function getRacesByYear($year)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM races WHERE YEAR(race_date) = ? ORDER BY race_date ASC");
        $stmt->execute([$year]);
        return $stmt->fetchAll(); // Retourne un tableau de résultats
    }

    /**
     * Récupère toutes les courses, triées par date croissante
     */
    public function getAllRaces()
    {
        $stmt = $this->pdo->prepare("SELECT * FROM races ORDER BY race_date ASC");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Ajoute une nouvelle course dans la base avec les données de l'objet courant
     */
    public function addRace()
    {
        $stmt = $this->pdo->prepare("INSERT INTO races (race_name, circuit, category, race_date, video_url, image_url) VALUES (?, ?, ?, ?, ?, ?)");
        // Exécute la requête avec les propriétés de l'objet
        return $stmt->execute([$this->raceName, $this->circuit, $this->category, $this->raceDate, $this->videoUrl, $this->imageUrl]);
    }

    /**
     * Récupère une course selon son ID
     */
    public function getRaceById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM races WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(); // Retourne une seule course sous forme de tableau associatif
    }

    /**
     * Met à jour les informations d'une course dans la base en fonction de l'ID
     */
    public function updateRace()
    {
        $stmt = $this->pdo->prepare("UPDATE races SET race_name = ?, circuit = ?, category = ?, race_date = ?, video_url = ?, image_url = ? WHERE id = ?");
        return $stmt->execute([$this->raceName, $this->circuit, $this->category, $this->raceDate, $this->videoUrl, $this->imageUrl, $this->id]);
    }

    /**
     * Supprime une course en fonction de son ID
     */
    public function deleteRace($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM races WHERE id = ?");
        return $stmt->execute([$id]);
    }

    /**
     * Ensemble des setters pour chaque propriété privée
     */
    public function setId($id)
    {
        $this->id = $id;
    }
    public function setRaceName($raceName)
    {
        $this->raceName = $raceName;
    }
    public function setCircuit($circuit)
    {
        $this->circuit = $circuit;
    }
    public function setCategory($category)
    {
        $this->category = $category;
    }
    public function setRaceDate($raceDate)
    {
        $this->raceDate = $raceDate;
    }
    public function setVideoUrl($videoUrl)
    {
        $this->videoUrl = $videoUrl;
    }
    public function setImageUrl($imageUrl)
    {
        $this->imageUrl = $imageUrl;
    }
}
