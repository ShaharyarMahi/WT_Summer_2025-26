<?php
require_once __DIR__ . '/../models/Category.php';

class CategoryController
{
    private $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new Category();
    }

    public function index()
    {
        $editCategory = null;

        if (isset($_GET['edit'])) {
            $editCategory = $this->categoryModel->findById($_GET['edit']);
        }

        $categories = $this->categoryModel->getAll();

        $message = $_SESSION['category_message'] ?? null;
        unset($_SESSION['category_message']);

        require __DIR__ . '/../views/layout/header.php';
        require __DIR__ . '/../views/categories/index.php';
        require __DIR__ . '/../views/layout/footer.php';
    }

    public function store()
    {
        $categoryId  = $_POST['category_id'] ?? null;
        $name        = trim($_POST['category_name'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $status      = $_POST['status'] ?? 'active';

        if ($name === '') {
            $_SESSION['category_message'] = 'Category name is required.';
            header('Location: index.php?page=categories');
            exit;
        }

        if ($this->categoryModel->nameExists($name, $categoryId ?: null)) {
            $_SESSION['category_message'] = 'This category name already exists.';
            header('Location: index.php?page=categories');
            exit;
        }

        $data = [
            'category_name' => $name,
            'description'   => $description,
            'status'        => $status,
        ];

        if ($categoryId) {
            $this->categoryModel->update($categoryId, $data);
            $_SESSION['category_message'] = 'Category updated successfully.';
        } else {
            $this->categoryModel->create($data);
            $_SESSION['category_message'] = 'Category added successfully.';
        }

        header('Location: index.php?page=categories');
        exit;
    }

    public function remove()
    {
        $id = $_GET['delete'] ?? null;

        if ($id) {
            $this->categoryModel->delete($id);
            $_SESSION['category_message'] = 'Category deleted.';
        }

        header('Location: index.php?page=categories');
        exit;
    }
}