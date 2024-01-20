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
     * @param int $length
     * @param int $offset
     * @return array|false An array of transactions if successful, or false
     */
    public function getUserTransactions(int $length, int $offset) : array | false
    {
        //escaping function that allows searching for special chars
        $searchTerm = addcslashes($_GET['s'] ?? "", '%_');

        $params =  [
            'user_id' => $_SESSION['user_id'],
            'description' => "%{$searchTerm}%",
        ];


        $userTransactions = $this->db->query(
            "SELECT
            *,
            DATE_FORMAT(date, '%Y-%m-%d') as formated_date
            FROM transaction
            WHERE user_id = :user_id
            AND description LIKE :description
            LIMIT {$length} OFFSET {$offset}",
           $params
        );

        //query returns number of results
        $transactionCount = $this->db->query(
            "SELECT
            COUNT(*)    
            FROM transaction
            WHERE user_id = :user_id
            AND description LIKE :description",
            $params
        )->count();


        return [
            $userTransactions->findAll(),
            $transactionCount
            ];
    }
}