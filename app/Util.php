<?php
namespace App;

use App\Models\UserModel;

class Util
{
    /**
     * Check if the user is currently logged in.
     */
    public static function isLoggedIn()
    {
        return isset($_SESSION['id']) && isset($_SESSION['token']);
    }

    /**
     * Check if the user is currently logged in as a reporter.
     */
    public static function isReporter()
    {
        if (!Util::isLoggedIn()) return false;

        $usersModel = new UserModel();

        $user = $usersModel->getUserById($_SESSION['id']);
        $user = json_decode($user, true);

        return $user['Role'] == 1;
    }
}
