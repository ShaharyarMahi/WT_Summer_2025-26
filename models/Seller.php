<?php

class Seller
{
    private $conn;


    public function __construct($conn)
    {
        $this->conn = $conn;
    }


    /*
    |--------------------------------------------------------------------------
    | Get store belonging to logged-in seller
    |--------------------------------------------------------------------------
    */

    public function getStoreBySellerId($sellerId)
    {
        $sql = "SELECT
                    store_id,
                    seller_id,
                    store_name,
                    store_description,
                    store_logo,
                    store_status,
                    rating,
                    created_at
                FROM seller_stores
                WHERE seller_id = ?
                LIMIT 1";

        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            return false;
        }

        $stmt->bind_param(
            "i",
            $sellerId
        );

        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            return $result->fetch_assoc();
        }

        return false;
    }


    /*
    |--------------------------------------------------------------------------
    | Get only store ID
    |--------------------------------------------------------------------------
    */

    public function getStoreIdBySellerId($sellerId)
    {
        $sql = "SELECT store_id
                FROM seller_stores
                WHERE seller_id = ?
                LIMIT 1";

        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            return false;
        }

        $stmt->bind_param(
            "i",
            $sellerId
        );

        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows === 1) {

            $row = $result->fetch_assoc();

            return (int)$row["store_id"];
        }

        return false;
    }
}

?>