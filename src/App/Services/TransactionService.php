<?php
declare(strict_types=1);

namespace App\Services;

use Framework\Database;

class TransactionService
{
    public function __construct(
        private Database $db
    )
    {

    }

    //TODO refactor to DTO
    public function createTransaction(array $formData)
    {

        $formatedDate = "{$formData['date']} 00:00:00";

        $this->db->query(
            'INSERT INTO transaction(user_id, description, amount, date)
          VALUES(:user_id, :description, :amount, :date)'
            ,
            [
                'user_id' => $_SESSION['user_id'],
                'description' => $formData['description'],
                'amount' => $formData['amount'],
                'date' => $formatedDate
            ]);
    }

    /**
     * Retrieves transactions for a specific user.
     *
     * This method queries the database to retrieve all transactions associated
     * with the currently authenticated user.
     *
     * @return array|false An array of transactions if successful, or false
     *
     */
    public function getUserTransactions() : array | false
    {
        $userTransactions = $this->db->query(
            "SELECT * FROM transaction WHERE user_id = :user_id",
            [
                'user_id' => $_SESSION['user_id']
            ]
        );
        return $userTransactions->findAll();
    }
}