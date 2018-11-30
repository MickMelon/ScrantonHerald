<?php
namespace App\Controllers;

use App\Models\UserModel;
use App\Base\View;
use App\Base\Util;

class LoginController
{
    private $userModel;

    /**
    * Creates a new LoginController object
    * and instantiate dependencies.
    */
    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    /**
    * Displays the login page with errors if there are any.
    */
    public function index($errors = null)
    {
        if (Util::isLoggedIn()) header('Location: index.php');

        $view = new View('Login/index');
        $view->assign('errors', $errors);
        $view->render();
    }

    /**
    * Goes through the login process. Called upon
    * login form submission.
    */
    public function login()
    {
        if (isset($_POST['email']) && isset($_POST['password']))
        {
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
            $result = $this->authenticate($email, $password);

            if ($result > 0)
            {
                $_SESSION['id'] = $result;
                $_SESSION['token'] = rand(100000, 999999);

                header('Location: index.php?controller=login&action=success');
            }
            else
            {
                $errors[] = 'Incorrect email address or password.';
                $this->index($errors);
            }
        }
        else
            header('Location: index.php');
    }

    /**
    * Displayed when user logs in successfully.
    */
    public function success()
    {
        $view = new View('Login/loginsuccess');
        $view->render();
    }

    /**
    * Goes through the logout process. Called when
    * clicking the logout button.
    */
    public function logout()
    {
        $_SESSION = array();
        setcookie(session_name(), '', time() - 2592000, '/');
        session_destroy();

        $this->success();
    }

    /**
    * Checks the email and password against the database to see
    * if there are matches. Returns the user ID to be used in the
    * session variables.
    */
    private function authenticate($email, $password)
    {
        $user = json_decode($this->userModel->getUserByEmailPassword($email, $password), true);

        if ($user != null)
            return $user['ID'];

        return -1;
    }
}
