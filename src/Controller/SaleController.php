<?php

namespace App\Controller;

use App\Core\ViewController;
use App\Repository\SaleRepository;
use App\Repository\ProductRepository;
use App\Support\AuthService;

class SaleController extends ViewController
{
    public function __construct(
        AuthService $authService,
        private ProductRepository $productRepository,
        private SaleRepository $saleRepository,
    ) {
        parent::__construct($authService);
    }

    public function index(): void
    {
        $sales = $this->saleRepository->getList();

        // Renderiza a página de vendas
        $this->render('sales/index', [
            'sales' => $sales
        ]);
    }
    public function create(): void 
    {
        $products = $this->productRepository->getAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        }

        // Renderiza a página de criar venda
        $this->render('sales/create', [
            'products' => $products
        ]);
    }
}
