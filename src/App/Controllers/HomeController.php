<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Services\TransactionService;
use Framework\TemplateEngine;
use App\Config\Paths;

/**
 * responsible for rendering homepage
 * here is the good place to have instace of template engine if the is no container
 *
 */
class HomeController
{


    public function __construct(
        //refactor using container, class is in contructor
        private TemplateEngine     $view,
        private TransactionService $transactionService
    )
    {
        //path is configured in Paths class
        // $this->view = new TemplateEngine(Paths::VIEW);
    }

    /**
     * @return void
     */
    public function home()
    {
        //get transactions via TransactionService and pass it to template
        $transactions = $this->transactionService->getUserTransactions();


        //renders return value of the render method
        echo $this->view->render("index.php", [
//            'title' => 'Home',
            'transactions' => $transactions
        ]);
    }
}