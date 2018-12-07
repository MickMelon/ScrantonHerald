<?php
namespace App\Models;

use App\Database;
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
        $passHash = password_hash($password, PASSWORD_BCRYPT);
        $verHash = md5(rand(0, 1000));

        $db = Database::getInstance();

        $sql = "INSERT INTO `User` (`FirstName`, `LastName`, `Email`, `Password`, `VerHash`)"
            . " VALUES (:firstName, :lastName, :email, :password, :verHash)";
        $query = $db->prepare($sql);
        $query->bindParam(':firstName', $firstName, PDO::PARAM_STR);
        $query->bindParam(':lastName', $lastName, PDO::PARAM_STR);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->bindParam(':password', $passHash, PDO::PARAM_STR);
        $query->bindParam(':verHash', $verHash, PDO::PARAM_STR);

        $query->execute();

        // Send the verification email...
        $subject = 'Scranton Herald Email Verification';
        $message .= 'Thank you for registering with Scranton Herald! 
            Please click the following link to activate your account: 
            https://mayar.abertay.ac.uk/~1800833/twix/index.php?controller=register&action=verify&email=' 
            . $email . '&hash=' . $verHash;
        $headers = 'From:michael.mcmillan@outlook.com' . "\r\n";
        mail($email, $subject, $message, $headers);
    }

    public function activateUser($id)
    {
        $db = Database::getInstance();

        $sql = "UPDATE `User` SET `Active` = 1 WHERE `ID` = :id";
        $query = $db->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_INT);

        $query->execute();
    }

    public function isActivated($id)
    {
        $db = Database::getInstance();

        $sql = "SELECT `Active` FROM `User` WHERE `ID` = :id LIMIT 1";
        $query = $db->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();

        $result = $query->fetch();

        echo $result->Active;

        return $result->Active == 1;
    }
}
