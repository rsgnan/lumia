<?php

namespace App\Controller;

use App\Core\ViewController;
use App\Repository\SaleRepository;
use App\Support\AuthService;

class SaleController extends ViewController
{
    public function __construct(
        AuthService $authService,
        private SaleRepository $saleRepository,
    ) {
        parent::__construct($authService);
    }

    public function index()
    {
        $sales = $this->saleRepository->getAll();

        // Renderiza a página de vendas
        $this->render('sales/index', [
            'sales' => $sales
        ]);
    }
}
