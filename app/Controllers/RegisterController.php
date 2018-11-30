<?php
namespace App\Controllers;

use App\Models\UserModel;
use App\Base\View;
use App\Base\Util;

class RegisterController
{
    private $userModel;

    /**
    * Creates a new RegisterController object
    * and instantiate dependencies.
    */
    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    /**
    * Displays the register page with errors if there are any.
    */
    public function index($errors = null)
    {
        if (Util::isLoggedIn()) header('Location: index.php');

        $view = new View('Register/index');
        $view->assign('errors', $errors);
        $view->render();
    }

    /**
    * Goes through the register process. Called upon
    * register form submission.
    */
    public function register()
    {
        // Check if user submitted register
        if (isset($_POST['firstName']) &&
            isset($_POST['lastName']) &&
            isset($_POST['email']) &&
            isset($_POST['password']) &&
            isset($_POST['g-recaptcha-response']))
        {
            $googleCaptchaSecret = "6LfG23UUAAAAAIFz-cZ97KjwmUQ3qWTMJ1GvQdJg";
            $verifyCaptchaResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $googleCaptchaSecret . '&response=' . $_POST['g-recaptcha-response']);
            $captchaResponseData = json_decode($verifyCaptchaResponse);

            if ($captchaResponseData->success)
            {
                $firstName = filter_var($_POST['firstName'], FILTER_SANITIZE_STRING);
                $lastName = filter_var($_POST['lastName'], FILTER_SANITIZE_STRING);
                $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
                $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);

                $existingUser = json_decode(
                    $this->userModel->getUserByEmail($email));

                if ($existingUser != null)
                {
                    $errors[] = 'An account with that email address already exists.';
                    $this->index($errors);
                }
                else
                {
                    $this->userModel->createUser($firstName, $lastName, $email, $password);
                    header('Location: index.php?controller=register&action=success');
                }
            }
            else
                header('Location: index.php?controller=pages&action=error');
        }
        else
            header('Location: index.php');
    }

    /**
    * Displayed when user registers successfully.
    */
    public function success()
    {
        $view = new View('Register/registersuccess');
        $view->render();
    }
}
