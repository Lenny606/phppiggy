<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use App\Services\{ReceiptService, TransactionService};

class ReceiptController
{
    public function __construct(
        private TemplateEngine $view,
        private TransactionService $transactionService,
        private ReceiptService $receiptService
    ) {
    }

    public function uploadView(array $params)
    {
        $transaction = $this->transactionService->getUserTransaction($params['transaction']);

        if (!$transaction) {
            redirectTo("/");
        }

        echo $this->view->render("receipts/create.php");
    }

    public function upload(array $params)
    {
        $transaction = $this->transactionService->getUserTransaction($params['transaction']);

        if (!$transaction) {
            redirectTo("/");
        }

        //SUPER GLOBAL $_FILES CONTAINS INFORMATION FROM POST
        $file = $_FILES['receipt'] ?? null;
        $this->receiptService->validateFile($file);

        //uploads and saves to transaction
        $this->receiptService->uploadFile($file, $transaction['id']);

        redirectTo("/");
    }

    public function download(array $params) {
        $transaction = $this->transactionService->getUserTransaction($params['transaction']);

        if (!$transaction) {
            redirectTo("/");
        }
//        get receipt
        $receipt = $this->receiptService->getReceipt($params('receipt'));

        //compare receipt id with transaction id => should be equal
        if ($receipt['transaction_id'] !== $transaction['id']){
            redirectTo("/");
        }

        //logic for file in service
        $this->receiptService->read($receipt);
    }
    public function delete(array $params) {
        $transaction = $this->transactionService->getUserTransaction($params['transaction']);

        if (!$transaction) {
            redirectTo("/");
        }
//        get receipt
        $receipt = $this->receiptService->getReceipt($params('receipt'));

        //compare receipt id with transaction id => should be equal
        if ($receipt['transaction_id'] !== $transaction['id']){
            redirectTo("/");
        }

        $this->receiptService->delete($receipt);

        redirectTo('/');
    }
}