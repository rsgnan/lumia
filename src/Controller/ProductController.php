<?php

namespace App\Controller;

use App\Core\ViewController;
use App\Repository\ProductRepository;

class ProductController extends ViewController
{
    public function __construct(private ProductRepository $productRepository) {}
    public function index()
    {
        $products = $this->productRepository->getAll();
        $categories = $this->productRepository->getAllCategories();
        $categoryNames = $this->productRepository->getWithCategoryName();

        // Monta um mapa apartir do id do produto com o nome da categoria
        $categoryMap = [];
        foreach ($categoryNames as $categoryName) {
            $categoryMap[$categoryName['id']] = $categoryName['category_name'];
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
            $photo = '';


            // Validação dos dados e caso necessário retorna mensagem de erro
            if (empty($name)) {
                $errors[] = "Preencha o Nome do Produto corretamente!";
            }

            if (empty($category_id)) {
                $errors[] = "Selecione uma Categoria!";
            }

            if ($price <= 0) {
                $errors[] = "Estabeleça o valor do Produto!";
            }

            // Verifica se veio um upload novo nesse request
            $hasNewPhoto = !empty($_FILES['photo']['name']);

            if ($hasNewPhoto) {
                $validation = validatePhoto($_FILES['photo']);
                if (!$validation['success']) {
                    $errors[] = $validation['error'];
                } else if (empty($errors)) {
                    // Upload direto para a pasta definitiva
                    $upload = uploadPhoto($_FILES['photo'], __DIR__ . '/../../public/uploads/products');
                    if (!$upload['success']) {
                        $errors[] = $upload['error'];
                    } else {
                        $photo = $upload['filename'];
                    }
                } else {
                    // Há outros erros no formulário e guarda a foto em tmp para não perder no reload
                    $upload = uploadPhoto($_FILES['photo'], __DIR__ . '/../../public/uploads/tmp');
                    if ($upload['success']) {
                        $tempPhoto = $upload['filename'];
                    }
                }
            } else if (!empty($_POST['temp_photo'])) {
                // Nenhum arquivo novo enviado, mas já existe uma foto temporária de um reload anterior
                $tempPhotoName = trim((string) $_POST['temp_photo']);
                $tempPath = __DIR__ . '/../../public/uploads/tmp/' . $tempPhotoName;

                if (is_file($tempPath)) {
                    if (empty($errors)) {
                        // Formulário válido agora move a foto temporária para a pasta definitiva
                        $finalPath = __DIR__ . '/../../public/uploads/products/' . $tempPhotoName;

                        if (rename($tempPath, $finalPath)) {
                            $photo = $tempPhotoName;
                        } else {
                            $errors[] = 'Falha ao salvar a imagem no servidor.';
                        }
                    } else {
                        // Ainda há errors mas mantém referência para reexibir no formulário
                        $tempPhoto = $tempPhotoName;
                    }
                }
            }
            // Caso não seja encontrado erro(s) adiciona o produto e redireciona
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
        $id  = @(int) ($_GET['id'] ?? 0);
        $product = $this->productRepository->getById($id);
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
            // Mantém a foto atual do produto por padrão, caso nenhuma nova seja enviada 
            $photo = $product->photo ?? '';

            // Validação dos dados e caso necessário retorna mensagem de erro
            if (empty($name)) {
                $errors[] = "Preencha o Nome do Produto corretamente!";
            }

            if (empty($category_id)) {
                $errors[] = "Selecione uma Categoria!";
            }

            if ($price <= 0) {
                $errors[] = "Estabeleça o valor do Produto!";
            }

            // Verifica se veio um upload novo nesse request
            $hasNewPhoto = !empty($_FILES['photo']['name']);

            if ($hasNewPhoto) {
                $validation = validatePhoto($_FILES['photo']);
                if (!$validation['success']) {
                    $errors[] = $validation['error'];
                } else if (empty($errors)) {
                    // Upload direto para a pasta definitiva
                    $upload = uploadPhoto($_FILES['photo'], __DIR__ . '/../../public/uploads/products');
                    if (!$upload['success']) {
                        $errors[] = $upload['error'];
                    } else {
                        $photo = $upload['filename'];
                    }
                } else {
                    // Há outros erros no formulário e guarda a foto em tmp para não perder no reload
                    $upload = uploadPhoto($_FILES['photo'], __DIR__ . '/../../public/uploads/tmp');
                    if ($upload['success']) {
                        $tempPhoto = $upload['filename'];
                    }
                }
            } else if (!empty($_POST['temp_photo'])) {
                // Nenhum arquivo novo enviado, mas já existe uma foto temporária de um reload anterior
                $tempPhotoName = trim((string) $_POST['temp_photo']);
                $tempPath = __DIR__ . '/../../public/uploads/tmp/' . $tempPhotoName;

                if (is_file($tempPath)) {
                    if (empty($errors)) {
                        // Formulário válido agora move a foto temporária para a pasta definitiva
                        $finalPath = __DIR__ . '/../../public/uploads/products/' . $tempPhotoName;

                        if (rename($tempPath, $finalPath)) {
                            // Apaga foto antiga
                            if (file_exists(__DIR__ . '/../../public/uploads/products' . $photo)) {
                                if (!unlink($photo)) {
                                    $error[] = 'Não foi possível deletar foto antiga.';
                                }
                            }
                            // Salva nome da nova foto
                            $photo = $tempPhotoName;
                        } else {
                            $errors[] = 'Falha ao salvar a imagem no servidor.';
                        }
                    } else {
                        // Ainda há errors mas mantém referência para reexibir no formulário
                        $tempPhoto = $tempPhotoName;
                    }
                }
            }

            if (empty($errors)) {
                $this->productRepository->update($id, $name, $category_id, $tag, $price, $stock, $description, $photo);
                header("Location: index.php?route=products/index");
                return;
            }
        }

        $this->render('products/edit', [
            'product' => $product,
            'categories' => $categories,
            'errors' => $errors,
            'tempPhoto' => $tempPhoto
        ]);
    }
}
