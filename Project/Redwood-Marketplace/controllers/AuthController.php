<?php

require_once "models/User.php";

class AuthController
{
    private $userModel;

    public function __construct($conn)
    {
        $this->userModel = new User($conn);
    }

    public function register()
    {
        $error = "";
        $success = "";

        if ($_SERVER["REQUEST_METHOD"] === "POST") {

            $firstName = trim($_POST["first_name"] ?? "");
            $lastName  = trim($_POST["last_name"] ?? "");
            $email     = trim($_POST["email"] ?? "");
            $password  = $_POST["password"] ?? "";
            $phone     = trim($_POST["phone"] ?? "");

            if (
                empty($firstName) ||
                empty($lastName) ||
                empty($email) ||
                empty($password)
            ) {

                $error = "Please fill in all required fields.";

            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

                $error = "Please enter a valid email address.";

            } elseif (strlen($password) < 6) {

                $error = "Password must contain at least 6 characters.";

            } elseif ($this->userModel->emailExists($email)) {

                $error = "An account with this email already exists.";

            } else {

                $created = $this->userModel->createUser(
                    $firstName,
                    $lastName,
                    $email,
                    $password,
                    $phone
                );

                if ($created) {

                    $success = "Account created successfully.";

                } else {

                    $error = "Unable to create account.";

                }
            }
        }

        require "views/customer/register.php";
    }


    public function login()
{
    $error = "";

    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        $email = trim($_POST["email"] ?? "");
        $password = $_POST["password"] ?? "";

        if (empty($email) || empty($password)) {

            $error = "Please enter your email and password.";

        } else {

            $user = $this->userModel->loginUser($email);

            if ($user === false) {

                $error = "Invalid email or password.";

            } elseif (
                !password_verify($password, $user["password"])
            ) {

                $error = "Invalid email or password.";

            } elseif ($user["status"] !== "active") {

                $error = "Your account is not active.";

            } else {

                $_SESSION["user_id"] = $user["user_id"];
                $_SESSION["first_name"] = $user["first_name"];
                $_SESSION["last_name"] = $user["last_name"];
                $_SESSION["role"] = $user["role"];

                if ($user["role"] === "customer") {

                    header(
                        "Location: index.php?page=customer"
                    );

                    exit;

                } elseif ($user["role"] === "seller") {

                    header(
                        "Location: index.php?page=seller"
                    );

                    exit;

                } else {

                    header(
                        "Location: index.php?page=home"
                    );

                    exit;
                }
            }
        }
    }

    require "views/customer/login.php";
}




public function logout()
{
    $_SESSION = [];

    session_destroy();

    header("Location: index.php?page=login");

    exit;
}
}
// Validate user login credentials

?>