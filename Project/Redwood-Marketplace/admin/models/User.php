<?php
/**
 * User Model
 * -----------
 * Talks to the `users` table.
 * For the Admin Panel, we only care about users whose role = 'admin'.
 */

require_once __DIR__ . '/../config/database.php';

class User
{
    private $pdo;

    public function __construct()
    {
        global $pdo;
        $this->pdo = $pdo;
    }

    /**
     * Find an admin user by email.
     * Only returns a row if role = 'admin'.
     */
    public function findAdminByEmail($email)
    {
        $sql = "SELECT user_id, first_name, last_name, email, password, role, status
                FROM users
                WHERE email = :email AND role = 'admin'
                LIMIT 1";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['email' => $email]);

        return $stmt->fetch(); // returns false if not found
    }

    /**
     * Get a single user by ID (used to re-check session validity).
     */
    public function findById($userId)
    {
        $sql = "SELECT user_id, first_name, last_name, email, role, status
                FROM users
                WHERE user_id = :id
                LIMIT 1";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $userId]);

        return $stmt->fetch();
    }
}
