<?php

namespace App\Controller;

use App\Core\ViewController;
use App\Repository\ProductRepository;
use App\Controller\ErrorController;
use App\Support\AuthService;

class ProductController extends ViewController
{
    public function __construct(
        AuthService $authService,
        private ProductRepository $productRepository
        ) {
            parent::__construct($authService);
        }

    public function index(): void
    {
        $products = $this->productRepository->getAll();
        $categories = $this->productRepository->getAllCategories();
        $productCategoryRows = $this->productRepository->getWithCategoryName();

        // Monta um mapa do produto para o nome da categoria
        $categoryMap = [];
        foreach ($productCategoryRows as $row) {
            $categoryMap[$row['id']] = $row['category_name'];
        }

        // Anexa o nome da categoria em cada produto
        foreach ($products as $product) {
            $product->category_name = $categoryMap[$product->id] ?? '';
        }

        // Renderiza a página de produtos
        $this->render('products/index', [
            'products' => $products,
            'categories' => $categories
        ]);
    }

    public function create(): void
    {
        $categories = $this->productRepository->getAllCategories();
        $errors = [];
        $tempPhoto = $_POST['temp_photo'] ?? null;

        if (!empty($_POST)) {
            $name = trim((string) ($_POST['name'] ?? ''));
            $category_id = (int) ($_POST['category_id'] ?? '');
            $tag = trim((string) ($_POST['tag'] ?? ''));
            $price = (float) ($_POST['price'] ?? '');
            $stock = (int) ($_POST['stock'] ?? '');
            $description = trim((string) ($_POST['description'] ?? ''));

            // Valida os dados antes de salvar o produto
            $this->validateFields($name, $category_id, $stock, $price, $errors);

            // Trata a foto antes de salvar o produto
            $photo = $this->handlePhoto($errors, $tempPhoto, null);

            // Salva o produto somente após validar todos os dados
            if (empty($errors)) {
                $this->productRepository->create($name, $category_id, $tag, $price, $stock, $description, $photo);
                header("Location: index.php?route=products/index");
                return;
            }
        }

        // Renderiza a página de adicionar produto
        $this->render('products/create', [
            'errors' => $errors,
            'categories' => $categories,
            'tempPhoto' => $tempPhoto
        ]);
    }

    public function update(): void
    {

        $id = (int) ($_GET['id'] ?? 0);
        $product = $this->productRepository->getById($id);

        // Verifica se o produto existe antes de continuar
        if ($product === null) {
            (new ErrorController())->notFound();
            return;
        }

        $categories = $this->productRepository->getAllCategories();
        $errors = [];
        $tempPhoto = $_POST['temp_photo'] ?? null;

        if (!empty($_POST)) {
            $name = trim((string) ($_POST['name'] ?? ''));
            $category_id = (int) ($_POST['category_id'] ?? '');
            $tag = trim((string) ($_POST['tag'] ?? ''));
            $price = (float) ($_POST['price'] ?? '');
            $stock = (int) ($_POST['stock'] ?? '');
            $description = trim((string) ($_POST['description'] ?? ''));

            // Valida os dados antes de atualizar o produto
            $this->validateFields($name, $category_id, $stock, $price, $errors);

            // Guarda a foto original antiga para removê-la depois
            $oldPhoto = $product->photo ?? '';

            $photo = $this->handlePhoto($errors, $tempPhoto, $oldPhoto);

            // Atualiza os dados do produto antes de remover a foto antiga
            if (empty($errors)) {
                $this->productRepository->update(
                    $id, 
                    $name, 
                    $category_id, 
                    $tag, $price, 
                    $stock, 
                    $description, 
                    $photo
                );

                // Remove a foto antiga somente após atualizar o banco
                if (!empty($oldPhoto) && $oldPhoto !== $photo) {
                    $oldPhotoPath = __DIR__ . '/../../public/uploads/products/' . $oldPhoto;
                    if (is_file($oldPhotoPath)) {
                        @unlink($oldPhotoPath);
                    }
                }

                header("Location: index.php?route=products/index");
                return;
            }
        }
        // Renderiza a página de editar produto
        $this->render('products/edit', [
            'product' => $product,
            'errors' => $errors,
            'categories' => $categories,
            'tempPhoto' => $tempPhoto
        ]);
    }

    private function validateFields(
        string $name, 
        int $category_id, 
        int $stock, 
        float $price, 
        array &$errors
        ): void {
        if (trim($name) === '') {
            $errors[] = "Preencha o Nome do Produto corretamente!";
        }
        if ($category_id === 0) {
            $errors[] = "Selecione uma Categoria!";
        } elseif (!$this->productRepository->categoryExists($category_id)) {
            $errors[] = "A Categoria selecionada não existe!";
        }
        if ($stock < 0) {
            $errors[] = "Valor de Estoque não pode ser negativo!";
        }
        if ($price <= 0) {
            $errors[] = "Estabeleça o valor do Produto!";
        }
    }

    private function handlePhoto(array &$errors, ?string &$tempPhoto, ?string $currentPhoto): string
    {
        // Mantém a foto atual até trocar
        $photo = $currentPhoto ?? '';

        $hasNewPhoto = !empty($_FILES['photo']['name']);

        if ($hasNewPhoto) {

            // Valida a foto enviada
            $validation = validatePhoto($_FILES['photo']);
            if (!$validation['success']) {
                $errors[] = $validation['error'];
                return $photo;
            }

            // Se houver erros, mantém a foto na pasta temporária
            $isTemporary = !empty($errors);

            $folder = $isTemporary ? 'tmp' : 'products';

            $upload = uploadPhoto($_FILES['photo'], __DIR__ . '/../../public/uploads/' . $folder);

            if (!$upload['success']) {
                $errors[] = $upload['error'];
                return $photo;
            }

            if ($isTemporary) {
                $tempPhoto = $upload['filename'];

                // Registra a foto temporária para validar o acesso depois
                $_SESSION['temp_photos'][] = $tempPhoto;
            } else {
                $photo = $upload['filename'];
                $tempPhoto = null;
            }

            return $photo;
        }

        if (empty($_POST['temp_photo'])) {
            return $photo;
        }

        // Recupera a foto temporária enviada anteriormente
        $tempPhotoName = basename(trim((string) $_POST['temp_photo']));
        $tempPath = __DIR__ . '/../../public/uploads/tmp/' . $tempPhotoName;

        // Garante que a foto temporária pertence à sessão atual
        $belongToUser = in_array(
            $tempPhotoName, 
            $_SESSION['temp_photos'] ?? [], 
            true
        );

        if (!$belongToUser || !is_file($tempPath)) {
            $tempPhoto = null;
            return $photo;
        }

        $checkFile = [
            'error'     => UPLOAD_ERR_OK,
            'name'      => $tempPhotoName,
            'tmp_name'  => $tempPath,
            'size'      => filesize($tempPath)
        ];

        // Valida novamente a foto temporária
        $validation = validatePhoto($checkFile);

        if (!$validation['success']) {
            $errors[] = $validation['error'];
            @unlink($tempPath);
            $this->forgetTempPhoto($tempPhotoName);
            $tempPhoto = null;
            return $photo;
        }

        if (!empty($errors)) {
            // Mantém a foto temporária para a próxima tentativa
            $tempPhoto = $tempPhotoName;
            return $photo;
        }

        // Move a foto temporária para a pasta definitiva
        $finalPath = __DIR__ . '/../../public/uploads/products/' . $tempPhotoName;

        if (rename($tempPath, $finalPath)) {
            $this->forgetTempPhoto($tempPhotoName);
            $tempPhoto = null;
            return $tempPhotoName;
        }

        $errors[] = 'Falha ao salvar a imagem no servidor.';
        $tempPhoto = $tempPhotoName;
        return $photo;
    }

    private function forgetTempPhoto(string $filename): void
    {
        if (empty($_SESSION['temp_photos'])) {
            return;
        }

        // Remove a foto da lista de arquivos temporários da sessão
        $_SESSION['temp_photos'] = array_values(
            array_diff($_SESSION['temp_photos'], [$filename])
        );
    }
}
