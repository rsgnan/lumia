<?php

namespace App\Controller;

use App\Core\ViewController;
use App\Repository\ProductRepository;
use App\Controller\ErrorController;

class ProductController extends ViewController
{
    public function __construct(private ProductRepository $productRepository) {}

    public function index()
    {
        $products = $this->productRepository->getAll();
        $categories = $this->productRepository->getAllCategories();
        $productCategoryRows = $this->productRepository->getWithCategoryName();

        // Monta um mapa a partir do id do PRODUTO para o nome da categoria
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

    public function create()
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

            $this->validateFields($name, $category_id, $stock, $price, $errors);

            $photo = $this->handlePhoto($errors, $tempPhoto, null);

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

    public function update()
    {

        $id = (int) ($_GET['id'] ?? 0);
        $product = $this->productRepository->getById($id);

        // Verifica se o produto existe, se não existir redireciona
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

            $this->validateFields($name, $category_id, $stock, $price, $errors);

            // Guarda a foto original para poder apagá-la depois de trocar
            $oldPhoto = $product->photo ?? '';

            $photo = $this->handlePhoto($errors, $tempPhoto, $oldPhoto);


            if (empty($errors)) {
                $this->productRepository->update($id, $name, $category_id, $tag, $price, $stock, $description, $photo);

                // Só apaga a foto antiga depois do UPDATE no banco for confirmado
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

    private function validateFields(string $name, int $category_id, int $stock, float $price, array &$errors): void
    {
        if (empty($name)) {
            $errors[] = "Preencha o Nome do Produto corretamente!";
        }
        if (empty($category_id)) {
            $errors[] = "Selecione uma Categoria!";
        } else if (!$this->productRepository->categoryExists($category_id)) {
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
        $photo = $currentPhoto ?? '';
        $hasNewPhoto = !empty($_FILES['photo']['name']);

        if ($hasNewPhoto) {

            // Valida a foto enviada
            $validation = validatePhoto($_FILES['photo']);
            if (!$validation['success']) {
                $errors[] = $validation['error'];
                return $photo;
            }

            // Define o destino com base em erros de validação já acumulados
            $isTemporary = !empty($errors);
            $folder = $isTemporary ? 'tmp' : 'products';

            $upload = uploadPhoto($_FILES['photo'], __DIR__ . '/../../public/uploads/' . $folder);

            if (!$upload['success']) {
                $errors[] = $upload['error'];
                return $photo;
            }

            if ($isTemporary) {
                $tempPhoto = $upload['filename'];
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

        // Reaproveita a foto temporária do envio anterior
        $tempPhotoName = basename(trim((string) $_POST['temp_photo']));
        $tempPath = __DIR__ . '/../../public/uploads/tmp/' . $tempPhotoName;

        // Verifica se o arquivo pertence à sessão do usuário atual
        $belongToUser = in_array($tempPhotoName, $_SESSION['temp_photos'] ?? [], true);

        if (!$belongToUser || !is_file($tempPath)) {
            $tempPhoto = null;
            return $photo;
        }

        $checkFile = [
            'error'     => UPLOAD_ERR_OK,
            'name'      => $tempPhotoName,
            'tmp_name'  => $tempPath,
            'size'      => filesize($tempPath,)
        ];

        // Valida novamente a foto temporária, mesmo já tendo sido validada
        $validation = validatePhoto($checkFile);

        if (!$validation['success']) {
            $errors[] = $validation['error'];
            @unlink($tempPath);
            $this->forgetTempPhoto($tempPhotoName);
            $tempPhoto = null;
            return $photo;
        }

        if (!empty($errors)) {
            // Mantém a foto temporária para a view
            $tempPhoto = $tempPhotoName;
            return $photo;
        }

        // Transfere da 'tmp' para a pasta definitiva
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

        $_SESSION['temp_photos'] = array_values(
            array_diff($_SESSION['temp_photos'], [$filename])
        );
    }
}
