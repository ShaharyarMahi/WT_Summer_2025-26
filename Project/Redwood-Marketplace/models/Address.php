<?php

class Address
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }



    public function getAddressesByUser($userId)
    {
        $sql = "SELECT
                    address_id,
                    user_id,
                    address_type,
                    full_name,
                    phone,
                    address_line,
                    city,
                    postal_code,
                    country,
                    is_default,
                    created_at
                FROM addresses
                WHERE user_id = ?
                ORDER BY is_default DESC, address_id DESC";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param(
            "i",
            $userId
        );

        $stmt->execute();

        return $stmt->get_result();
    }


    public function getAddressById(
        $addressId,
        $userId
    ) {
        $sql = "SELECT
                    address_id,
                    user_id,
                    address_type,
                    full_name,
                    phone,
                    address_line,
                    city,
                    postal_code,
                    country,
                    is_default
                FROM addresses
                WHERE address_id = ?
                AND user_id = ?
                LIMIT 1";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param(
            "ii",
            $addressId,
            $userId
        );

        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            return $result->fetch_assoc();
        }

        return false;
    }



    public function addAddress(
        $userId,
        $addressType,
        $fullName,
        $phone,
        $addressLine,
        $city,
        $postalCode,
        $country,
        $isDefault
    ) {
       

        $checkSql =
            "SELECT COUNT(*) AS total
             FROM addresses
             WHERE user_id = ?";

        $checkStmt =
            $this->conn->prepare($checkSql);

        $checkStmt->bind_param(
            "i",
            $userId
        );

        $checkStmt->execute();

        $checkResult =
            $checkStmt->get_result()
                ->fetch_assoc();

        if ($checkResult["total"] == 0) {
            $isDefault = 1;
        }


      

        if ($isDefault == 1) {

            $this->removeDefault(
                $userId
            );
        }


        $sql = "INSERT INTO addresses
                (
                    user_id,
                    address_type,
                    full_name,
                    phone,
                    address_line,
                    city,
                    postal_code,
                    country,
                    is_default
                )
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt =
            $this->conn->prepare($sql);

        $stmt->bind_param(
            "isssssssi",
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

        return $stmt->execute();
    }


    

    public function updateAddress(
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
    ) {

        if ($isDefault == 1) {

            $this->removeDefault(
                $userId
            );
        }


        $sql = "UPDATE addresses
                SET
                    address_type = ?,
                    full_name = ?,
                    phone = ?,
                    address_line = ?,
                    city = ?,
                    postal_code = ?,
                    country = ?,
                    is_default = ?
                WHERE address_id = ?
                AND user_id = ?";

        $stmt =
            $this->conn->prepare($sql);

        $stmt->bind_param(
            "sssssssiii",
            $addressType,
            $fullName,
            $phone,
            $addressLine,
            $city,
            $postalCode,
            $country,
            $isDefault,
            $addressId,
            $userId
        );

        return $stmt->execute();
    }


   

    private function removeDefault($userId)
    {
        $sql =
            "UPDATE addresses
             SET is_default = 0
             WHERE user_id = ?";

        $stmt =
            $this->conn->prepare($sql);

        $stmt->bind_param(
            "i",
            $userId
        );

        $stmt->execute();
    }


    /*
    |--------------------------------------------------------------------------
    | Set default address
    |--------------------------------------------------------------------------
    */

    public function setDefault(
        $addressId,
        $userId
    ) {

        /*
        Remove existing default
        */

        $this->removeDefault(
            $userId
        );


        /*
        Set selected address as default
        */

        $sql =
            "UPDATE addresses
             SET is_default = 1
             WHERE address_id = ?
             AND user_id = ?";

        $stmt =
            $this->conn->prepare($sql);

        $stmt->bind_param(
            "ii",
            $addressId,
            $userId
        );

        return $stmt->execute();
    }


    /*
    |--------------------------------------------------------------------------
    | Delete address
    |--------------------------------------------------------------------------
    */

    public function deleteAddress(
        $addressId,
        $userId
    ) {

        $sql =
            "DELETE FROM addresses
             WHERE address_id = ?
             AND user_id = ?";

        $stmt =
            $this->conn->prepare($sql);

        $stmt->bind_param(
            "ii",
            $addressId,
            $userId
        );

        return $stmt->execute();
    }
}

?>