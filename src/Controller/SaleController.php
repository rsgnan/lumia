<?php

namespace App\Controller;

use App\Core\ViewController;
use App\Support\AuthService;
use App\Repository\ProductRepository;
use App\Repository\SaleRepository;
use App\Repository\SaleItemRepository;

use PDO;

class SaleController extends ViewController
{
    public function __construct(
        AuthService $authService,
        private PDO $pdo,
        private ProductRepository $productRepository,
        private SaleRepository $saleRepository,
        private SaleItemRepository $saleItemRepository,
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
        $errors = [];
        $products = $this->productRepository->getAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $items = json_decode($_POST['items'] ?? '', true);

            $customerName = ($_POST['customer_name'] ?? '');
            $status = ($_POST['status'] ?? '');
            $userId = ($_POST['userId'] ?? null);

            $subtotal = 0;
            $validatedItems = [];

            $this->validateItems($items, $validatedItems, $subtotal, $errors);

            $discount = (float) ($_POST['discount_amount'] ?? 0);

            if ($discount < 0) {
                $errors[] = 'Desconto inválido.';
            }

            $total = max(0, $subtotal - $discount);

            if (empty($errors)) {
                try {

                    $this->pdo->beginTransaction();

                    $saleId = $this->saleRepository->create(
                        $customerName,
                        $discount,
                        $total,
                        $status,
                        $userId
                    );

                    foreach ($validatedItems as $item) {
                        $product = $item['product'];
                        $quantity = (int) $item['quantity'];

                        $itemSubtotal = $product->price * $quantity;

                        $this->saleItemRepository->create(
                            $saleId,
                            $product->id,
                            $product->name,
                            $product->price,
                            $product->price,
                            $quantity,
                            $itemSubtotal
                        );

                        $this->productRepository->decreaseStock(
                            $product->id,
                            $quantity
                        );
                    }

                    $this->pdo->commit();

                    header('Location: index.php?route=sales/index');
                    return;
                } catch (\Throwable $e) {
                    if ($this->pdo->inTransaction()) {
                        $this->pdo->rollBack();
                    }
                    $errors[] = 'Não foi possível registrar a venda.';
                }
            }
        }
        // Renderiza a página de criar venda
        $this->render('sales/create', [
            'errors' => $errors,
            'products' => $products
        ]);
    }

    private function validateItems(
        ?array $items,
        array &$validatedItems,
        float &$subtotal,
        array &$errors
    ): void {
        if (empty($items)) {
            $errors[] = 'Adicione pelo menos um produto à venda.';
            return;
        }

        foreach ($items as $item) {

            $product = $this->productRepository->getById((int) $item['id']);

            if ($product === null) {
                $errors[] = 'Produto não encontrado.';
                continue;
            }

            $quantity = (int) ($item['quantity'] ?? 0);

            if ($quantity < 1) {
                $errors[] = 'Quantidade inválida.';
                continue;
            }

            if ($quantity > $product->stock) {
                $errors[] = 'Quantidade maior que o estoque disponível.';
                continue;
            }

            $subtotal += $product->price * $quantity;

            $validatedItems[] = [
                'product' => $product,
                'quantity' => $quantity
            ];
        }
    }
}
