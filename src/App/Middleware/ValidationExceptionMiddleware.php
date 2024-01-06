<?php
declare(strict_types=1);

namespace App\Middleware;

use Framework\Contracts\MiddlewareInterface;
use Framework\Exceptions\ValidationException;


//will catch errors caused by controllers
class ValidationExceptionMiddleware implements MiddlewareInterface
{
    public function process(callable $next)
    {
        try {
            $next();

            //catches only validation errors
        } catch (ValidationException $e) {
            //shows error, needs to be stored in sessions cuz we are redirecting
            //session has to be enabled , new logic in sessionMiddleware
            $_SESSION['errors'] = $e->errors;

            //prefilled values from error without password
            $oldFormData = $_POST;
            $excludedFields = ['password', 'confirmPassword'];

            $formattedData = array_diff_key(
                $oldFormData,
//                switch keys and values
                array_flip($excludedFields)
            );

            $_SESSION['oldFormData'] = $formattedData;

            // redirect to form
            //http referer knows what form was submitted but has some security risks
            $referer = $_SERVER['HTTP_REFERER'];
            redirectTo($referer);
        }
    }
}