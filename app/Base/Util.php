<?php
namespace App\Base;

class Util
{
    public static function isLoggedIn()
    {
        return isset($_SESSION['id']) && isset($_SESSION['token']);
    }

    public static function isReporter()
    {
        if (!Util::isLoggedIn()) return false;

        $usersModel = new UsersModel();

        $user = $usersModel->getUserById($_SESSION['id']);
        $user = json_decode($user, true);

        return $user['Role'] == 2;
    }
}
