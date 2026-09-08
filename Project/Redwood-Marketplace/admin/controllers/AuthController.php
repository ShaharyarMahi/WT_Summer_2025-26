<?php


require_once __DIR__ . '/../models/User.php';

class AuthController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    /**
     * Show the login form (GET request)
     */
    public function showLoginForm()
    {
        $error = $_SESSION['login_error'] ?? null;
        unset($_SESSION['login_error']);

        require __DIR__ . '/../views/auth/login.php';
    }

    /**
     * Process login form submission (POST request)
     */
    public function login()
    {
        $email    = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');

        // ---- Basic validation ----
        if ($email === '' || $password === '') {
            $_SESSION['login_error'] = 'Email and password are required.';
            header('Location: index.php?page=login');
            exit;
        }

        // ---- Find admin user ----
        $admin = $this->userModel->findAdminByEmail($email);

        if (!$admin) {
            $_SESSION['login_error'] = 'Invalid email or password.';
            header('Location: index.php?page=login');
            exit;
        }

        // ---- Check account status ----
        if ($admin['status'] !== 'active') {
            $_SESSION['login_error'] = 'Your admin account is not active.';
            header('Location: index.php?page=login');
            exit;
        }

        // ---- Verify password (hashed) ----
        if (!password_verify($password, $admin['password'])) {
            $_SESSION['login_error'] = 'Invalid email or password.';
            header('Location: index.php?page=login');
            exit;
        }

        // ---- Success: set session ----
        $_SESSION['admin_id']    = $admin['user_id'];
        $_SESSION['admin_name']  = $admin['first_name'] . ' ' . $admin['last_name'];
        $_SESSION['admin_email'] = $admin['email'];

        header('Location: index.php?page=dashboard');
        exit;
    }

    /**
     * Logout - destroy session, then send to Delivery panel's login page
     * so the same person can log back in with their delivery/operations account.
     */
    public function logout()
    {
        session_unset();
        session_destroy();
        header('Location: ../delivery/index.php?page=login');
        exit;
    }
}
