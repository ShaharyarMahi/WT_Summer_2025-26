<?php

require_once "config/auth.php";

class OperationsController
{
    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        requireRole("operations");

        require "views/operations/dashboard.php";
    }
}

?>
