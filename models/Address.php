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
        $sql = "SELECT address_id, address_type, full_name, phone, address_line, city, postal_code, country, is_default
                FROM addresses WHERE user_id = ? ORDER BY is_default DESC, address_id ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function addAddress($userId, $type, $fullName, $phone, $line, $city, $postal, $country, $isDefault)
    {
        // If this is set as default, clear any previous default for this user
        if ($isDefault) {
            $sql = "UPDATE addresses SET is_default = 0 WHERE user_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $userId);
            $stmt->execute();
        }

        $sql = "INSERT INTO addresses (user_id, address_type, full_name, phone, address_line, city, postal_code, country, is_default)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("isssssssi", $userId, $type, $fullName, $phone, $line, $city, $postal, $country, $isDefault);
        return $stmt->execute();
    }

    public function getAddressById($addressId, $userId)
    {
        $sql = "SELECT * FROM addresses WHERE address_id = ? AND user_id = ? LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $addressId, $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows === 1) {
            return $result->fetch_assoc();
        }
        return false;
    }

    public function updateAddress($addressId, $userId, $type, $fullName, $phone, $line, $city, $postal, $country, $isDefault)
    {
        if ($isDefault) {
            $sql = "UPDATE addresses SET is_default = 0 WHERE user_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $userId);
            $stmt->execute();
        }

        $sql = "UPDATE addresses SET address_type = ?, full_name = ?, phone = ?, address_line = ?, city = ?, postal_code = ?, country = ?, is_default = ?
                WHERE address_id = ? AND user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sssssssiii", $type, $fullName, $phone, $line, $city, $postal, $country, $isDefault, $addressId, $userId);
        return $stmt->execute();
    }

    public function setDefault($addressId, $userId)
    {
        $sql = "UPDATE addresses SET is_default = 0 WHERE user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();

        $sql = "UPDATE addresses SET is_default = 1 WHERE address_id = ? AND user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $addressId, $userId);
        return $stmt->execute();
    }

    public function deleteAddress($addressId, $userId)
    {
        $sql = "DELETE FROM addresses WHERE address_id = ? AND user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $addressId, $userId);
        return $stmt->execute();
    }
}