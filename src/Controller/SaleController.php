<?php

namespace App\Controller;

use App\Core\ViewController;
use App\Repository\SaleRepository;
use App\Repository\ProductRepository;
use App\Controller\ErrorController;
use App\Support\AuthService;

class SaleController extends ViewController
{
    public function __construct(
        AuthService $authService,
        private SaleRepository $saleRepository,
        private ProductRepository $productRepository
    ) {
        parent::__construct($authService);
    }

    public function index()
    {
        $sales = $this->saleRepository->getAll();


        // Renderiza a página de produtos
        $this->render('sales/index', [
            'sales' => $sales
        ]);
    }
    public function create()
    {
        $errors = [];
        $customerName = '';
        $discountAmount = 0.0;
        $status = 'completed';
        $items = [];
        $this->render('sales/create', [
            'errors' => $errors
        ]);
    }
}
