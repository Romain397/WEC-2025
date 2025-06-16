<?php

require_once 'newslettersubscriber.php'; // Inclusion du modèle NewsletterSubscriber

class NewsletterController
{
    private $subscriberModel; // Instance du modèle pour gérer les abonnés

    public function __construct()
    {
        // Initialisation de l'objet NewsletterSubscriber pour les opérations sur les abonnés
        $this->subscriberModel = new NewsletterSubscriber();
    }

    /**
     * Ajouter un abonné à la newsletter
     * @param string $email Email de l'abonné à ajouter
     * @return bool Retourne false si l'email est déjà abonné, sinon ajoute et retourne le résultat
     */
    public function addSubscriber($email)
    {
        // Vérifie si l'email est déjà présent dans la liste des abonnés
        if ($this->subscriberModel->isSubscribed($email)) {
            return false; // Abonné déjà existant, on ne l'ajoute pas
        }

        // Prépare l'objet avec l'email donné
        $this->subscriberModel->hydrate(['email' => $email]);
        // Ajoute l'abonné et retourne le résultat (true/false)
        return $this->subscriberModel->addSubscriber();
    }

    /**
     * Récupérer la liste complète des abonnés
     * @return array Tableau des abonnés
     */
    public function getAllSubscribers()
    {
        return $this->subscriberModel->getAllSubscribers();
    }

    /**
     * Supprimer un abonné via son email
     * @param string $email Email de l'abonné à supprimer
     * @return bool Résultat de la suppression (true si réussi, false sinon)
     */
    public function deleteSubscriber($email)
    {
        return $this->subscriberModel->deleteSubscriber($email);
    }

    /**
     * Vérifier si un email est déjà abonné
     * @param string $email Email à vérifier
     * @return bool True si l'email est déjà dans la liste, false sinon
     */
    public function isSubscribed($email)
    {
        return $this->subscriberModel->isSubscribed($email);
    }
}
