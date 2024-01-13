<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Services\ValidatorService;
use App\Services\UserService;
use Framework\TemplateEngine;

class AuthController
{
    public function __construct(
        private TemplateEngine $view,
        private ValidatorService $validatorService,
        private UserService $userService
    )
    {

    }

    public function registerView()
    {
        //send variables into template , new middleware for exposing errors in template
        echo $this->view->render('register.php');

    }

    public function loginView()
    {
        //send variables into template , new middleware for exposing errors in template
        echo $this->view->render('login.php');

    }

    //method responsible for processing form submission
    public function register()
    {
        //superglobal variable with stored values from post method
       //dd($_POST);
        $this->validatorService->validateRegister($_POST);

        //validation on dtb level if email exists
        $this->userService->isEmailTaken($_POST['email']);

        $this->userService->createUser($_POST);

        //redirect to homepage
        redirectTo('/');
    }
}