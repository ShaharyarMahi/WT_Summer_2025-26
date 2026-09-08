<?php
require_once __DIR__ . '/../config/database.php';

class Category
{
    private $pdo;

    public function __construct()
    {
        global $pdo;
        $this->pdo = $pdo;
    }

    public function getAll()
    {
        $stmt = $this->pdo->query("SELECT * FROM categories ORDER BY category_id DESC");
        return $stmt->fetchAll();
    }

    public function findById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM categories WHERE category_id = :id LIMIT 1");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function create($data)
    {
        $sql = "INSERT INTO categories (category_name, description, status)
                VALUES (:category_name, :description, :status)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'category_name' => $data['category_name'],
            'description'   => $data['description'],
            'status'        => $data['status'],
        ]);
    }

    public function update($id, $data)
    {
        $sql = "UPDATE categories
                SET category_name = :category_name,
                    description = :description,
                    status = :status
                WHERE category_id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'category_name' => $data['category_name'],
            'description'   => $data['description'],
            'status'        => $data['status'],
            'id'            => $id,
        ]);
    }

    public function delete($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM categories WHERE category_id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function nameExists($name, $excludeId = null)
    {
        if ($excludeId) {
            $stmt = $this->pdo->prepare("SELECT category_id FROM categories WHERE category_name = :name AND category_id != :id");
            $stmt->execute(['name' => $name, 'id' => $excludeId]);
        } else {
            $stmt = $this->pdo->prepare("SELECT category_id FROM categories WHERE category_name = :name");
            $stmt->execute(['name' => $name]);
        }
        return (bool) $stmt->fetch();
    }
}