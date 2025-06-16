<?php

require_once 'race.php'; // Inclusion du modèle Race

class RaceController
{
    private $raceModel; // Instance du modèle Race pour interagir avec les données des courses

    // Constructeur : initialise une nouvelle instance du modèle Race
    public function __construct()
    {
        $this->raceModel = new Race();
    }

    /**
     * Ajouter une course
     * 
     * @param array $data Données de la course sous forme de tableau associatif
     * @return bool Résultat de l'insertion (true si succès, false sinon)
     */
    public function addRace($data)
    {
        // Hydrate l'objet Race avec les données reçues
        $this->raceModel->hydrate($data);
        // Appelle la méthode d'ajout dans le modèle
        return $this->raceModel->addRace();
    }

    /**
     * Obtenir toutes les courses
     * 
     * @return array Liste de toutes les courses
     */
    public function getAllRaces()
    {
        // Retourne la liste complète des courses depuis le modèle
        return $this->raceModel->getAllRaces();
    }

    /**
     * Obtenir une course par son ID
     * 
     * @param int $id Identifiant de la course
     * @return array|null Données de la course ou null si non trouvée
     */
    public function getRaceById($id)
    {
        // Appelle la méthode du modèle pour récupérer une course spécifique
        return $this->raceModel->getRaceById($id);
    }

    /**
     * Modifier une course existante
     * 
     * @param array $data Données modifiées de la course (doit contenir l'id)
     * @return bool Résultat de la mise à jour
     */
    public function updateRace($data)
    {
        // Hydrate l'objet avec les nouvelles données
        $this->raceModel->hydrate($data);
        // Exécute la mise à jour dans la base via le modèle
        return $this->raceModel->updateRace();
    }

    /**
     * Supprimer une course par son ID
     * 
     * @param int $id Identifiant de la course à supprimer
     * @return bool Résultat de la suppression
     */
    public function deleteRace($id)
    {
        // Appelle la suppression dans le modèle
        return $this->raceModel->deleteRace($id);
    }

    /**
     * Obtenir les courses d'une année spécifique
     * 
     * @param int $year Année désirée
     * @return array Liste des courses pour cette année
     */
    public function getRacesByYear($year)
    {
        // Délègue la récupération au modèle
        return $this->raceModel->getRacesByYear($year);
    }
}
