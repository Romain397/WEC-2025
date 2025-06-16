<?php

require_once 'User.php'; // Inclusion du modèle User

class UserController
{
    private $userModel; // Instance de la classe User (modèle)

    public function __construct()
    {
        // Instanciation du modèle User lors de la création du contrôleur
        $this->userModel = new User();
    }

    /**
     * Ajoute un utilisateur
     * Utilise la méthode hydrate du modèle pour remplir l'objet avec les données reçues,
     * puis appelle la méthode addUser pour enregistrer en base
     * @param array $data Données utilisateur (ex: firstName, lastName, email, password, isAdmin)
     * @return bool Résultat de l'insertion (true si succès, false sinon)
     */
    public function addUser($data)
    {
        $this->userModel->hydrate($data);
        return $this->userModel->addUser();
    }

    /**
     * Vérifie si un email existe déjà en base
     * Appelle directement la méthode isMailExists du modèle
     * @param string $email
     * @return bool true si email trouvé, false sinon
     */
    public function isEmailExists($email)
    {
        return $this->userModel->isMailExists($email);
    }

    /**
     * Authentifie un utilisateur avec email et mot de passe
     * Appelle la méthode login du modèle
     * @param string $email
     * @param string $password
     * @return bool true si connexion réussie, false sinon
     */
    public function login($email, $password)
    {
        return $this->userModel->login($email, $password);
    }

    /**
     * Récupère tous les utilisateurs (sans mot de passe)
     * @return array Tableau des utilisateurs
     */
    public function getAllUsers()
    {
        return $this->userModel->getAllUsers();
    }

    /**
     * Supprime un utilisateur via son identifiant
     * @param int $userId
     * @return bool Succès de la suppression
     */
    public function deleteUser($userId)
    {
        return $this->userModel->deleteUser($userId);
    }

    /**
     * Met à jour le rôle admin d'un utilisateur
     * @param int $userId
     * @param int $isAdmin 0 ou 1
     * @return bool Succès de la mise à jour
     */
    public function updateUserRole($userId, $isAdmin)
    {
        return $this->userModel->updateUserRole($userId, $isAdmin);
    }
}
