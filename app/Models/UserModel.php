<?php
namespace App\Models;

use App\Base\Database;
use PDO;

class UserModel
{
    /**
    * Gets the user who matches the ID parameter
    */
    public function getUserById($id)
    {
        $db = Database::getInstance();

        $sql = "SELECT * FROM `User` WHERE `ID` = :id LIMIT 1";
        $query = $db->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();

        return json_encode($query->fetch());
    }

    /**
    * Gets the user who matches the email address.
    */
    public function getUserByEmail($email)
    {
        $db = Database::getInstance();

        $sql = "SELECT * FROM `User` WHERE `Email` = :email LIMIT 1";
        $query = $db->prepare($sql);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->execute();

        return json_encode($query->fetch());
    }

    /**
    * Gets the user who matches the email address and password.
    */
    public function getUserByEmailPassword($email, $password)
    {
        $db = Database::getInstance();

        $sql = "SELECT * FROM `User` WHERE `Email` = :email LIMIT 1";
        $query = $db->prepare($sql);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->execute();

        $result = $query->fetch();
        if (password_verify($password, $result->Password))
            return json_encode($result);

        return null;
    }

    /**
    * Creates a new user.
    */
    public function createUser($firstName, $lastName, $email, $password)
    {
        $hash = password_hash($password, PASSWORD_BCRYPT);

        $db = Database::getInstance();

        $sql = "INSERT INTO `User` (`FirstName`, `LastName`, `Email`, `Password`)"
            . " VALUES (:firstName, :lastName, :email, :password)";
        $query = $db->prepare($sql);
        $query->bindParam(':firstName', $firstName, PDO::PARAM_STR);
        $query->bindParam(':lastName', $lastName, PDO::PARAM_STR);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->bindParam(':password', $hash, PDO::PARAM_STR);

        $query->execute();
    }
}
