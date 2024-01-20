<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Services\TransactionService;
use App\Services\ValidatorService;
use Framework\TemplateEngine;

class TransactionController
{
    public function __construct(
        private TemplateEngine     $view,
        private ValidatorService   $validatorService,
        private TransactionService $transactionService
    )
    {
    }

    public function createView()
    {
        echo $this->view->render("transactions/create.php");
    }

    public function editView(array $params)
    {
        //return single transaction
        $userTransaction = $this->transactionService->getUserTransaction($params['transaction']);

        if (!$userTransaction) {
            redirectTo('/');
        }

        echo $this->view->render("transactions/edit.php", [
            "userTransaction" => $userTransaction
        ]);
    }

    public function create()
    {
        //validates inputs data
        $this->validatorService->validateTransaction($_POST);

        //create transaction
        $this->transactionService->createTransaction($_POST);

        redirectTo('/');
    }

    public function edit(array $params)
    {
        $userTransaction = $this->transactionService->getUserTransaction($params['transaction']);

        if (!$userTransaction) {

            redirectTo('/');

        }
        $this->validatorService->validateTransaction($_POST);

        //create transaction
        $this->transactionService->updateTransaction($_POST, $userTransaction['id']);

        //global varibale refers to page from where the POST was submitted
        redirectTo($_SERVER['HTTP_REFERER']);
    }

    public function delete(array $params)
    {
        $this->transactionService->deleteTransaction((int)$params['transaction']);
        redirectTo('/');
    }

}