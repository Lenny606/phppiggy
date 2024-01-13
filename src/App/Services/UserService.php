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
            'password' => password_hash($formData['password'], PASSWORD_BCRYPT, ['cost'=>12]),
            'age' => $formData['age'],
            'country' => $formData['country'],
            'social_media_url' => $formData['socialMediaUrl']
        ]);

    }
}