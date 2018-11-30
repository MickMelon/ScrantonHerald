<?php
namespace App\Base;

use App\Models\UserModel;

class Util
{
    public static function isLoggedIn()
    {
        return isset($_SESSION['id']) && isset($_SESSION['token']);
    }

    public static function isReporter()
    {
        if (!Util::isLoggedIn()) return false;

        $usersModel = new UserModel();

        $user = $usersModel->getUserById($_SESSION['id']);
        $user = json_decode($user, true);

        return $user['Role'] == 2;
    }
}
