<?php

require_once "models/User.php";
require_once "config/auth.php";

class UserController
{
    private $userModel;


  

    public function __construct($conn)
    {
        $this->userModel = new User($conn);
    }


   

    public function profile()
    {
        /*
        Only logged-in users can access profile.
        */

        requireLogin();


        /*
        Get logged-in user's ID
        from session.
        */

        $userId =
            (int)$_SESSION["user_id"];


        /*
        Ask the User Model
        to get this user's information.
        */

        $user =
            $this->userModel
                ->getUserById($userId);


        /*
        If user does not exist,
        stop the request.
        */

        if ($user === false) {

            die("User not found.");
        }


        /*
        Send the user data
        to the profile View.
        */

        require
            "views/customer/profile.php";
    }


    /*
    |--------------------------------------------------------------------------
    | Show Edit Profile Form
    |--------------------------------------------------------------------------
    */

    public function editProfile()
    {
        requireLogin();


        $userId =
            (int)$_SESSION["user_id"];


        $user =
            $this->userModel
                ->getUserById($userId);


        if ($user === false) {

            die("User not found.");
        }


        /*
        Open the edit profile form.
        */

        require
            "views/customer/edit-profile.php";
    }


    /*
    |--------------------------------------------------------------------------
    | Update Profile
    |--------------------------------------------------------------------------
    */

    public function updateProfile()
    {
        requireLogin();


        /*
        Only accept POST request.
        */

        if (
            $_SERVER["REQUEST_METHOD"]
            !== "POST"
        ) {

            header(
                "Location: index.php?page=profile"
            );

            exit;
        }


        /*
        IMPORTANT:
        Get user ID from session,
        NOT from the browser.
        */

        $userId =
            (int)$_SESSION["user_id"];


        /*
        Get submitted form data.
        */

        $firstName =
            trim(
                $_POST["first_name"] ?? ""
            );


        $lastName =
            trim(
                $_POST["last_name"] ?? ""
            );


        $email =
            trim(
                $_POST["email"] ?? ""
            );


        $phone =
            trim(
                $_POST["phone"] ?? ""
            );


        /*
        Basic validation.
        */

        if (
            $firstName === ""
            || $email === ""
        ) {

            die(
                "First name and email are required."
            );
        }


        /*
        Validate email format.
        */

        if (
            !filter_var(
                $email,
                FILTER_VALIDATE_EMAIL
            )
        ) {

            die(
                "Please enter a valid email address."
            );
        }

        if (
    $this->userModel->emailExistsForOtherUser(
        $email,
        $userId
    )
) {

    die(
        "This email address is already being used by another account."
    );
}


        /*
        Update the database.
        */

        $success =
            $this->userModel
                ->updateProfile(
                    $userId,
                    $firstName,
                    $lastName,
                    $email,
                    $phone
                );


        /*
        If update was successful,
        update the session too.
        */

        if ($success) {

            $_SESSION["first_name"] =
                $firstName;


            header(
                "Location: index.php?page=profile"
            );

            exit;
        }


        /*
        If database update fails.
        */

        die(
            "Unable to update profile."
        );
    }
}

?>