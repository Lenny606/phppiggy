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
        //pagination => logic can be handled by controller instead of service
        $page = (int)($_GET['p'] ?? 1); //default is 1, cast as integer
        $length = 3; //number of results hardcoded
        $offset = ($page - 1) * $length; //in code first page is 0
        $searchTerm = $_GET['s'];

        //get transactions via TransactionService and pass it to template, deconstructint results from service
        [$transactions, $transactionsCount] = $this->transactionService->getUserTransactions(length: $length, offset: $offset);

        //calculate last page
        $lastPage = ceil($transactionsCount / $length);

        //page Links, range() creates array
        $pages = $lastPage ? range(1, $lastPage) : [];

        $pageLinks = array_map(
            fn($pageNumber) => http_build_query(
                [
                    'p' => $pageNumber,
                    's' => $searchTerm
                ]),
            $pages);

        //renders return value of the render method
        echo $this->view->render("index.php", [
//            'title' => 'Home',
            'transactions' => $transactions,
            'currentPage' => $page,
            'previousPageQuery' => http_build_query(
                [
                    'p' => $page - 1,
                    's' => $searchTerm
                ]),
            'lastPage' => $lastPage,
            'nextPageQuery' => http_build_query(
                [
                    'p' => $page + 1,
                    's' => $searchTerm
                ]),
            'pageLinks' => $pageLinks,
            'searchTerm' => $searchTerm

        ]);
    }
}