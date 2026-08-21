<?php

namespace App\Controller;

use App\Core\ViewController;
use App\Support\AuthService;
use App\Controller\ErrorController;
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

        // Renderiza a lista de vendas
        $this->render('sales/index', [
            'sales' => $sales
        ]);
    }
    public function create(): void
    {
        $errors = [];
        $products = $this->productRepository->getAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Recebe os produtos enviados pelo JavaScript em JSON
            $items = json_decode($_POST['items'] ?? '', true);

            $customerName = ($_POST['customer_name'] ?? '');
            $status = ($_POST['status'] ?? '');
            $userId = ($_POST['userId'] ?? null);

            $subtotal = 0;
            $validateFields = [];

            // Valida os produtos e calcula o subtotal da venda
            $this->validateFields($items, $validateFields, $subtotal, $errors);

            $discount = (float) ($_POST['discount_amount'] ?? 0);

            if ($discount < 0) {
                $errors[] = 'Desconto inválido.';
            }

            $total = max(0, $subtotal - $discount);

            if (empty($errors)) {
                try {

                    // Garante que venda, itens e estoque sejam alterados juntos
                    $this->pdo->beginTransaction();

                    $saleId = $this->saleRepository->create(
                        $customerName,
                        $discount,
                        $total,
                        $status,
                        $userId
                    );

                    foreach ($validateFields as $item) {
                        $product = $item['product'];
                        $quantity = (int) $item['quantity'];

                        $itemSubtotal = $product->price * $quantity;

                        // Salva cada produto pertencente à venda
                        $this->saleItemRepository->create(
                            $saleId,
                            $product->id,
                            $product->name,
                            $product->price,
                            $product->price,
                            $quantity,
                            $itemSubtotal
                        );

                        // Retira do estoque a quantidade vendida
                        $stockUpdated = $this->productRepository->decreaseStock(
                            $product->id,
                            $quantity
                        );

                        if (!$stockUpdated) {
                            throw new \Exception('Estoque insuficiente.');
                        }
                    }

                    $this->pdo->commit();

                    header('Location: index.php?route=sales/index');
                    return;
                } catch (\Throwable $e) {

                    // Desfaz todas as alterações se qualquer etapa falhar
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

    public function edit(): void
    {
        $saleId = (int) ($_GET['id'] ?? 0);

        $sale = $this->saleRepository->getById($saleId);

        if ($sale === null) {
            (new ErrorController())->notFound();
            return;
        }

        // Somenta vendas pendentes podem ser alteradas
        if ($sale->status !== 'pending') {
            header('Location: index.php?route=sales/index');
            return;
        }

        // Itens que pertencem atualmente à venda
        $items = $this->saleItemRepository->getBySaleId($saleId);

        // Todos os produtos são enviados para o JavaScript
        $products = $this->productRepository->getAll();

        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $customerName = trim((string) ($_POST['customer_name'] ?? ''));
            $discount = (float) ($_POST['discount_amount'] ?? 0);
            $status = $_POST['status'] ?? '';

            // Novos itens enviados pelo JavaScript após a edição
            $newItems = json_decode($_POST['items'] ?? '', true);

            $subtotal = 0;
            $validateFields = [];

            // Valida os novos itens e considera o estoque da venda antiga
            $this->validateFields(
                $newItems,
                $validateFields,
                $subtotal,
                $errors,
                $items
            );

            if ($discount < 0) {
                $errors[] = 'Desconto inválido.';
            }

            $total = max(0, $subtotal - $discount);

            if (empty($errors)) {
                try {
                    // Todas as alterações da edição devem ser feitas juntas
                    $this->pdo->beginTransaction();

                    // Devolve ao estoque os produtos da venda antiga
                    foreach ($items as $item) {
                        $this->productRepository->increaseStock(
                            (int) $item['product_id'],
                            (int) $item['quantity']
                        );
                    }

                    // Atualiza os dados principais da venda
                    $this->saleRepository->update(
                        $saleId,
                        $customerName,
                        $discount,
                        $total,
                        $status
                    );

                    // Remove os itens antigos antes de inserir os novos
                    $this->saleItemRepository->deleteBySaleId($saleId);

                    // Insere os itens resultantes da edição
                    foreach ($validateFields as $item) {
                        $product = $item['product'];
                        $quantity = (int) $item['quantity'];

                        $itemSubTotal = $product->price * $quantity;

                        $this->saleItemRepository->create(
                            $saleId,
                            $product->id,
                            $product->name,
                            $product->price,
                            $product->price,
                            $quantity,
                            $itemSubTotal
                        );

                        // Retira do estoque a quantidade da nova venda
                        $stockUpdated = $this->productRepository->decreaseStock(
                            $product->id,
                            $quantity
                        );

                        if (!$stockUpdated) {
                            throw new \Exception('Estoque insuficiente.');
                        }
                    }

                    $this->pdo->commit();
                    header('Location: index.php?route=sales/index');
                } catch (\Throwable $e) {

                    // Se alguma etapa falhar, desfaz toda a edição
                    if ($this->pdo->inTransaction()) {
                        $this->pdo->rollBack();
                    }
                    $errors[] = 'Não foi possível atualizar a venda.';
                }
            }
        }
        $this->render('sales/edit', [
            'sale' => $sale,
            'items' => $items,
            'products' => $products,
            'errors' => $errors
        ]);
    }

    public function cancel(): void
    {
        $saleId = (int) ($_GET['id']);
        $sale = $this->saleRepository->getById($saleId);

        if ($sale === null) {
            (new ErrorController())->notFound();
            return;
        }

        // Somente vendas pendentes podem ser canceladas
        if ($sale->status !== 'pending') {
            header('Location: index.php?route=sales/index');
            return;
        }

        $items = $this->saleItemRepository->getBySaleId($saleId);

        try {
            $this->pdo->beginTransaction();

            // Ao cancelar, devolve os produtos da venda ao estoque
            foreach ($items as $item) {
                $this->productRepository->increaseStock(
                    (int) $item['product_id'],
                    (int) $item['quantity']
                );
            }

            $this->saleRepository->updateStatus(
                $saleId,
                'cancelled'
            );

            $this->pdo->commit();

            header('Location: index.php?route=sales/index');
            return;
        } catch (\Throwable $e) {

            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }

            // Por enquanto, volta para a lista
            header('Location: index.php?route=sales/index');
            return;
        }
    }

    private function validateFields(
        ?array $items,
        array &$validateFields,
        float &$subtotal,
        array &$errors,
        ?array $currentItems = null
    ): void {
        if (empty($items)) {
            $errors[] = 'Adicione pelo menos um produto à venda.';
            return;
        }

        foreach ($items as $item) {

            // Busca no banco os dados reais do produto
            $product = $this->productRepository->getById((int) $item['id']);

            if ($product === null) {
                $errors[] = 'Produto não encontrado.';
                continue;
            }

            $currentQuantity = 0;

            // Considera o estoque devolvido pela venda antiga
            if ($currentItems !== null) {
                foreach ($currentItems as $currentItem) {
                    if ((int) ($currentItem['product_id']) === $product->id) {
                        $currentQuantity = (int) $currentItem['quantity'];
                        break;
                    }
                }
            }

            $quantity = (int) ($item['quantity'] ?? 0);

            if ($quantity < 1) {
                $errors[] = 'Quantidade inválida';
                continue;
            }

            // Estoque atual + estoque devolvido
            if ($quantity > ($product->stock + $currentQuantity)) {
                $errors[] = 'Quantidade maior que o estoque disponível.';
                continue;
            }

            $subtotal += $product->price * $quantity;

            // Guarda os produtos validados para salvar a venda
            $validateFields[] = [
                'product' => $product,
                'quantity' => $quantity
            ];
        }
    }
}
