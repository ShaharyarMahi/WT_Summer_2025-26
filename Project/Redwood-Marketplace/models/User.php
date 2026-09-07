<?php

class User
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function emailExists($email)
    {
        $sql = "SELECT user_id FROM users WHERE email = ?";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param("s", $email);

        $stmt->execute();

        $result = $stmt->get_result();

        return $result->num_rows > 0;
    }


//fahim





    public function createUser(
        $firstName,
        $lastName,
        $email,
        $password,
        $phone
    ) {
        $hashedPassword = password_hash(
            $password,
            PASSWORD_DEFAULT
        );

        $sql = "INSERT INTO users
                (first_name, last_name, email, password, phone)
                VALUES (?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param(
            "sssss",
            $firstName,
            $lastName,
            $email,
            $hashedPassword,
            $phone
        );

        return $stmt->execute();
    }




        public function loginUser($email)
{
    $sql = "SELECT *
            FROM users
            WHERE email = ?
            LIMIT 1";

    $stmt = $this->conn->prepare($sql);

    $stmt->bind_param("s", $email);

    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        return $result->fetch_assoc();
    }

    return false;
}


public function getUserById($userId)
{
    $sql = "SELECT
                user_id,
                first_name,
                last_name,
                email,
                phone,
                role,
                status,
                created_at,
                updated_at
            FROM users
            WHERE user_id = ?
            LIMIT 1";

    $stmt = $this->conn->prepare($sql);

    $stmt->bind_param(
        "i",
        $userId
    );

    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        return $result->fetch_assoc();
    }

    return false;
}


public function updateProfile(
    $userId,
    $firstName,
    $lastName,
    $email,
    $phone
) {
    $sql = "UPDATE users
            SET
                first_name = ?,
                last_name = ?,
                email = ?,
                phone = ?
            WHERE user_id = ?";

    $stmt = $this->conn->prepare($sql);

    $stmt->bind_param(
        "ssssi",
        $firstName,
        $lastName,
        $email,
        $phone,
        $userId
    );

    return $stmt->execute();
}



public function emailExistsForOtherUser($email, $userId)
{
    $sql = "SELECT user_id
            FROM users
            WHERE email = ?
            AND user_id != ?
            LIMIT 1";

    $stmt = $this->conn->prepare($sql);

    $stmt->bind_param(
        "si",
        $email,
        $userId
    );

    $stmt->execute();

    $result = $stmt->get_result();

    return $result->num_rows > 0;
}








}

?>