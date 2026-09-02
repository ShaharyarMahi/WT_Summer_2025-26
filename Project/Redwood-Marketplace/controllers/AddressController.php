<?php

require_once "models/Address.php";
require_once "config/auth.php";

class AddressController
{
    private $addressModel;


    public function __construct($conn)
    {
        $this->addressModel =
            new Address($conn);
    }


    /*
    |--------------------------------------------------------------------------
    | Address List
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        requireLogin();

        $userId =
            (int)$_SESSION["user_id"];

        $addresses =
            $this->addressModel
                ->getAddressesByUser(
                    $userId
                );

        require
            "views/customer/addresses.php";
    }


    /*
    |--------------------------------------------------------------------------
    | Add Address Form
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        requireLogin();

        require
            "views/customer/address-form.php";
    }


    /*
    |--------------------------------------------------------------------------
    | Store New Address
    |--------------------------------------------------------------------------
    */

    public function store()
    {
        requireLogin();


        if (
            $_SERVER["REQUEST_METHOD"]
            !== "POST"
        ) {

            header(
                "Location: index.php?page=addresses"
            );

            exit;
        }


        $userId =
            (int)$_SESSION["user_id"];


        $addressType =
            trim(
                $_POST["address_type"] ?? "home"
            );


        $fullName =
            trim(
                $_POST["full_name"] ?? ""
            );


        $phone =
            trim(
                $_POST["phone"] ?? ""
            );


        $addressLine =
            trim(
                $_POST["address_line"] ?? ""
            );


        $city =
            trim(
                $_POST["city"] ?? ""
            );


        $postalCode =
            trim(
                $_POST["postal_code"] ?? ""
            );


        $country =
            trim(
                $_POST["country"] ?? "Bangladesh"
            );


        $isDefault =
            isset($_POST["is_default"])
                ? 1
                : 0;


        /*
        Basic validation
        */

        if (
            $fullName === ""
            || $phone === ""
            || $addressLine === ""
            || $city === ""
        ) {

            die(
                "Please fill in all required fields."
            );
        }


        $success =
            $this->addressModel
                ->addAddress(
                    $userId,
                    $addressType,
                    $fullName,
                    $phone,
                    $addressLine,
                    $city,
                    $postalCode,
                    $country,
                    $isDefault
                );


        if ($success) {

            header(
                "Location: index.php?page=addresses"
            );

            exit;
        }


        die(
            "Unable to add address."
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Edit Address
    |--------------------------------------------------------------------------
    */

    public function edit()
    {
        requireLogin();


        $userId =
            (int)$_SESSION["user_id"];


        $addressId =
            (int)($_GET["id"] ?? 0);


        if ($addressId <= 0) {

            header(
                "Location: index.php?page=addresses"
            );

            exit;
        }


        $address =
            $this->addressModel
                ->getAddressById(
                    $addressId,
                    $userId
                );


        if ($address === false) {

            die("Address not found.");
        }


        require
            "views/customer/address-form.php";
    }


    /*
    |--------------------------------------------------------------------------
    | Update Address
    |--------------------------------------------------------------------------
    */

    public function update()
    {
        requireLogin();


        if (
            $_SERVER["REQUEST_METHOD"]
            !== "POST"
        ) {

            header(
                "Location: index.php?page=addresses"
            );

            exit;
        }


        $userId =
            (int)$_SESSION["user_id"];


        $addressId =
            (int)(
                $_POST["address_id"] ?? 0
            );


        $addressType =
            trim(
                $_POST["address_type"] ?? "home"
            );


        $fullName =
            trim(
                $_POST["full_name"] ?? ""
            );


        $phone =
            trim(
                $_POST["phone"] ?? ""
            );


        $addressLine =
            trim(
                $_POST["address_line"] ?? ""
            );


        $city =
            trim(
                $_POST["city"] ?? ""
            );


        $postalCode =
            trim(
                $_POST["postal_code"] ?? ""
            );


        $country =
            trim(
                $_POST["country"] ?? "Bangladesh"
            );


        $isDefault =
            isset($_POST["is_default"])
                ? 1
                : 0;


        if (
            $addressId <= 0
            || $fullName === ""
            || $phone === ""
            || $addressLine === ""
            || $city === ""
        ) {

            die(
                "Invalid address information."
            );
        }


        /*
        Verify ownership first
        */

        $existing =
            $this->addressModel
                ->getAddressById(
                    $addressId,
                    $userId
                );


        if ($existing === false) {

            die("Address not found.");
        }


        $success =
            $this->addressModel
                ->updateAddress(
                    $addressId,
                    $userId,
                    $addressType,
                    $fullName,
                    $phone,
                    $addressLine,
                    $city,
                    $postalCode,
                    $country,
                    $isDefault
                );


        if ($success) {

            header(
                "Location: index.php?page=addresses"
            );

            exit;
        }


        die(
            "Unable to update address."
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Set Default
    |--------------------------------------------------------------------------
    */

    public function setDefault()
    {
        requireLogin();


        $userId =
            (int)$_SESSION["user_id"];


        $addressId =
            (int)(
                $_GET["id"] ?? 0
            );


        if ($addressId <= 0) {

            header(
                "Location: index.php?page=addresses"
            );

            exit;
        }


        $address =
            $this->addressModel
                ->getAddressById(
                    $addressId,
                    $userId
                );


        if ($address === false) {

            die("Address not found.");
        }


        $this->addressModel
            ->setDefault(
                $addressId,
                $userId
            );


        header(
            "Location: index.php?page=addresses"
        );

        exit;
    }


    /*
    |--------------------------------------------------------------------------
    | Delete
    |--------------------------------------------------------------------------
    */

    public function delete()
    {
        requireLogin();


        $userId =
            (int)$_SESSION["user_id"];


        $addressId =
            (int)(
                $_GET["id"] ?? 0
            );


        if ($addressId <= 0) {

            header(
                "Location: index.php?page=addresses"
            );

            exit;
        }


        $address =
            $this->addressModel
                ->getAddressById(
                    $addressId,
                    $userId
                );


        if ($address === false) {

            die("Address not found.");
        }


        /*
        Do not allow deleting the only/default
        address for now.
        */

        if ($address["is_default"] == 1) {

            die(
                "Set another address as default before deleting this address."
            );
        }


        $this->addressModel
            ->deleteAddress(
                $addressId,
                $userId
            );


        header(
            "Location: index.php?page=addresses"
        );

        exit;
    }
}

?>