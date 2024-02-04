<?php
declare(strict_types=1);

namespace App\Services;

use Framework\Database;
use Framework\Exceptions\ValidationException;

class UserService
{
    public function __construct(
        private Database $db
    )
    {
    }

    public function isEmailTaken(string $email)
    {
        $emailCount = $this->db->query(
            "SELECT COUNT(*) FROM `users` WHERE `email` = :email",
            [
                'email' => $email
            ]
        )->count();

        if ($emailCount > 0) {
            throw new ValidationException(['email' => 'Email taken']);
        }
    }

    public function createUser(array $formData)
    {
        //for hash use password_hash() + bcrypt + options[cost == speed]
        $this->db->query(
            "INSERT INTO `users` (email, password, age, country, social_media_url) VALUES (
                  :email, :password, :age, :country, :social_media_url)",
            [
                'email' => $formData['email'],
                'password' => password_hash($formData['password'], PASSWORD_BCRYPT, ['cost' => 12]),
                'age' => $formData['age'],
                'country' => $formData['country'],
                'social_media_url' => $formData['social_media_url']
            ]);

        //after registration user should be authenticated and redirected to homepage (same as login)
        session_regenerate_id();
        //PDO class has access to last saved data from query
        $_SESSION['user'] = $this->db->id();
    }
    public function login(array $formData)
    {
        //retrieve user row and save ID into SESSION
        $user = $this->db->query("SELECT * FROM `users` WHERE `email` = :email",
            [
                'email' => $formData['email'],
            ])->find();

        //password match step because hashing has different results
        //compare the password from form data and from dtb query
        //empty string if no user is found
        $passwordMatch = password_verify($formData['password'],$user['password'] ?? "");

        if(!$user || !$passwordMatch){
            throw new ValidationException(['password' => ["Invalid credentials"]]);
        }

        //regenerate session id after user is logged in, data are still saved
        //simple and effective against hijacking
        session_regenerate_id();

        //save the user id into session (id never changes)
        $_SESSION['user'] = $user['id'];

    }
    public function logout() {
        //delete the session, with unset() method we can target specific cookie
        //unset($_SESSION['user']);

        //session_destroy will destroy the session + cookie
        session_destroy();

        //for extra precaution reset the session, sets new id , cookie is not destroyed
        //session_regenerate_id();

        //better way to reset ,name, value , expires (now - 3600s)
        $params = session_get_cookie_params();
        setcookie(
            'PHPSESSID',
            '',
            time() - 3600,
            $params['path'],
            $params['domain'],
            $params['secure'],
            $params['httponly'],
        );
    }
}
