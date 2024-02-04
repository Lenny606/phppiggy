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
    public function getUserTransactions(int $length, int $offset): array|false
    {
        //escaping function that allows searching for special chars
        $searchTerm = addcslashes($_GET['s'] ?? "", '%_');

        $params = [
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
        )->findAll();

        $userTransactions = array_map(
            function (array $transaction) {
            $transaction['receipts'] = $this->db->query(
                "SELECT * FROM receipts WHERE transaction_id = :transaction_id",
                ['transaction_id' => $transaction['id']])->findAll();
            return $transaction;
        }, $userTransactions);

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

    public function getUserTransaction(string $userTransactionId)
    {
        $userTransaction = $this->db->query(
            "SELECT *, DATE_FORMAT(date, '%Y-%m-%d') as formated_date
                       FROM transactions
                       WHERE user_id = :userId
                       AND id=:userTransactionId",
            [
                'userTransactionId' => $userTransactionId,
                'userId' => $_SESSION['user']
            ]
        )->find();

        return $userTransaction;
    }

    public function updateTransaction(array $formData, int $id)
    {

        $formatedDate = "{$formData['date']} 00:00:00";

        $this->db->query(
            "UPDATE transactions
                    SET description=:description,
                        amount=:amount,
                        data=:date
                       WHERE user_id = :user_id
                       AND id=:id",
            [
                'description' => $formData['description'],
                'amount' => $formData['amount'],
                'date' => $formatedDate,
                'id' => $id,
                'user_id' => $_SESSION['user']
            ]);
    }

    /**
     * @param int $id
     * @return void
     */
    public function deleteTransaction(int $id): void
    {
        $this->db->query(
            "DELETE FROM transactions
                    WHERE user_id = :user_id
                    AND id=:id",
            [
                'id' => $id,
                'user_id' => $_SESSION['user']
            ]);
    }
}