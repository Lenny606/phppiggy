<?php
declare(strict_types=1);

namespace App\Services;

use Framework\Database;

class TransactionService
{
  public function __construct(
      private Database $db
  ){

  }

  //TODO refactor to DTO
  public function createTransaction(array $formData){

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
}