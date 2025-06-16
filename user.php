<?php

require_once 'config.php'; // Inclusion de la configuration, notamment la connexion à la BDD

class User
{
    // Propriétés privées correspondant aux colonnes de la table 'users'
    private $id;
    private $firstName;
    private $lastName;
    private $email;
    private $password;
    private $isAdmin;

    private $pdo; // Instance PDO pour la connexion à la base de données

    public function __construct()
    {
        // Instancie la connexion à la BDD via la classe Database (définie dans config.php)
        $db = new Database();
        $this->pdo = $db->getConnection();
    }

    /**
     * Hydrater l'objet avec un tableau de données associatives
     * Chaque clé doit correspondre à un setter de la classe
     * @param array $data
     */
    public function hydrate(array $data)
    {
        foreach ($data as $key => $value) {
            // Construit le nom de la méthode setter à partir de la clé
            $method = 'set' . ucfirst($key);
            // Vérifie si le setter existe puis l'appelle avec la valeur correspondante
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    /**
     * Vérifie si un email existe déjà dans la table 'users'
     * @param string $email
     * @return bool true si l'email est trouvé, false sinon
     */
    public function isMailExists($email)
    {
        $stmt = $this->pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch() !== false;
    }

    /**
     * Ajoute un utilisateur en base de données
     * Vérifie d'abord que l'email n'existe pas déjà
     * Hash le mot de passe avant insertion
     * @return bool true si insertion réussie, false sinon
     */
    public function addUser()
    {
        // Vérifie la présence de l'email
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$this->email]);

        if ($stmt->fetch()) {
            return false; // Email déjà utilisé
        }

        // Hash du mot de passe sécurisé
        $hashedPassword = password_hash($this->password, PASSWORD_BCRYPT);

        // Préparation de l'insertion
        $stmt = $this->pdo->prepare("
            INSERT INTO users (first_name, last_name, email, password, is_admin) 
            VALUES (?, ?, ?, ?, ?)
        ");

        // Exécution avec les propriétés de l'objet
        return $stmt->execute([
            $this->firstName,
            $this->lastName,
            $this->email,
            $hashedPassword,
            $this->isAdmin
        ]);
    }

    /**
     * Récupère tous les utilisateurs (sans le mot de passe)
     * @return array tableau des utilisateurs
     */
    public function getAllUsers()
    {
        $stmt = $this->pdo->prepare("SELECT id, first_name, last_name, email, is_admin FROM users");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Supprime un utilisateur selon son ID
     * @param int $id
     * @return bool succès de la suppression
     */
    public function deleteUser($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM users WHERE id = ?");
        return $stmt->execute([$id]);
    }

    /**
     * Met à jour le rôle admin d'un utilisateur
     * @param int $userId
     * @param int $isAdmin 0 ou 1
     * @return bool succès de la mise à jour
     */
    public function updateUserRole($userId, $isAdmin)
    {
        $stmt = $this->pdo->prepare("UPDATE users SET is_admin = ? WHERE id = ?");
        return $stmt->execute([$isAdmin, $userId]);
    }

    /**
     * Authentifie un utilisateur selon son email et mot de passe
     * Si succès, stocke les infos utiles en session
     * @param string $email
     * @param string $password
     * @return bool true si connexion réussie, false sinon
     */
    public function login($email, $password)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            // Stocke les données utilisateur en session
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['is_admin'] = $user['is_admin'];
            return true;
        }

        return false;
    }

    /**
     * Getters & Setters pour accéder et modifier les propriétés privées
     */

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function setIsAdmin($isAdmin)
    {
        $this->isAdmin = $isAdmin;
    }
}
