<?php

namespace App\Controller;

use App\Core\ViewController;
use App\Repository\ProductRepository;
use App\Controller\ErrorController;
use ValueError;

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
            } else if (!$this->productRepository->categoryExists($category_id)) {
                $errors[] = "A categoria selecionada não existe!";
            }

            if ($stock < 0) {
                $errors[] = "Valor de estoque não pode ser negativo!";
            }

            if ($price <= 0) {
                $errors[] = "Estabeleça o valor do Produto!";
            }

            // Verifica se veio um upload novo nesse request
            $hasNewPhoto = !empty($_FILES['photo']['name']);

            if ($hasNewPhoto) {
                // Valida a nova foto
                $validation = validatePhoto($_FILES['photo']);

                if (!$validation['success']) {
                    $errors[] = $validation['error'];
                } else {
                    // Define o destino com base em erros do formulário
                    $isTemporary = !empty($errors);
                    $folder = $isTemporary ? 'tmp' : 'products';

                    $upload = uploadPhoto($_FILES['photo'], __DIR__ . '/../../public/uploads/' . $folder);

                    if (!$upload['success']) {
                        $errors[] = $upload['error'];
                    } else {
                        // Salva o nome na variável correspondente
                        if ($isTemporary) {
                            $tempPhoto = $upload['filename'];
                        } else {
                            $photo = $upload['filename'];
                            $tempPhoto = null;
                        }
                    }
                }
            } else if (!empty($_POST['temp_photo'])) {
                // Reaproveita a foto temporária do envio anterior
                $tempPhotoName = basename(trim((string) $_POST['temp_photo']));
                $tempPath = __DIR__ . '/../../public/uploads/tmp/' . $tempPhotoName;

                if (is_file($tempPath)) {
                    if (empty($errors)) {
                        // Transfere da 'tmp' para a pasta definitiva
                        $finalPath = __DIR__ . '/../../public/uploads/products/' . $tempPhotoName;

                        if (rename($tempPath, $finalPath)) {
                            $photo = $tempPhotoName;
                        } else {
                            $errors[] = 'Falha ao salvar a imagem no servidor.';
                        }
                    } else {
                        // Mantém a foto temporária para a view
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
        $id  = (int) ($_GET['id'] ?? 0);
        $product = $this->productRepository->getById($id);

        // Verifica se o produto existe, se não existir redireciona para página de error 404
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

            // Mantém a foto atual do produto por padrão, caso nenhuma nova seja enviada 
            $photo = $product->photo ?? '';
            // Guarda a foto original para poder apagá-la do disco depois de trocar 
            $oldPhoto = $photo;

            // Validação dos dados e caso necessário retorna mensagem de erro
            if (empty($name)) {
                $errors[] = "Preencha o Nome do Produto corretamente!";
            }

            if (empty($category_id)) {
                $errors[] = "Selecione uma Categoria!";
            } else if (!$this->productRepository->categoryExists($category_id)) {
                $errors[] = "A categoria selecionada não existe!";
            }

            if ($stock < 0) {
                $errors[] = "Valor de estoque não pode ser negativo!";
            }

            if ($price <= 0) {
                $errors[] = "Estabeleça o valor do Produto!";
            }

            // Verifica se veio um upload novo nesse request
            $hasNewPhoto = !empty($_FILES['photo']['name']);

            if ($hasNewPhoto) {
                // Valida a nova foto
                $validation = validatePhoto($_FILES['photo']);

                if (!$validation['success']) {
                    $errors[] = $validation['error'];
                } else {
                    // Define o destino com base em erros do formulário
                    $isTemporary = !empty($errors);
                    $folder = $isTemporary ? 'tmp' : 'products';

                    $upload = uploadPhoto($_FILES['photo'], __DIR__ . '/../../public/uploads/' . $folder);

                    if (!$upload['success']) {
                        $errors[] = $upload['error'];
                    } else {
                        // Salva o nome na variável correspondente
                        if ($isTemporary) {
                            $tempPhoto = $upload['filename'];
                        } else {
                            $photo = $upload['filename'];
                            $tempPhoto = null;
                        }
                    }
                }
            } else if (!empty($_POST['temp_photo'])) {
                // Nenhum arquivo novo enviado, mas já existe uma foto temporária de um reload anterior
                $tempPhotoName = basename(trim((string) $_POST['temp_photo']));
                $tempPath = __DIR__ . '/../../public/uploads/tmp/' . $tempPhotoName;

                if (is_file($tempPath)) {
                    if (empty($errors)) {
                        // Transfere da 'tmp' para a pasta definitiva
                        $finalPath = __DIR__ . '/../../public/uploads/products/' . $tempPhotoName;

                        if (rename($tempPath, $finalPath)) {
                            $photo = $tempPhotoName;
                            $tempPhoto = null;
                        } else {
                            $errors[] = 'Falha ao salvar a imagem no servidor.';
                        }
                    } else {
                        // Mantém a foto temporária para a view
                        $tempPhoto = $tempPhotoName;
                    }
                }
            }

            // Se o formulário é válido e a foto mudou, apaga a foto antiga 
            if (empty($errors) && !empty($oldPhoto) && $oldPhoto !== $photo) {
                $oldPhotoPath = __DIR__ . '/../../public/uploads/products/' . $oldPhoto;
                if (is_file($oldPhotoPath)) {
                    @unlink($oldPhotoPath);
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

    public function delete()
    {
        $id = (int) ($_POST['id'] ?? 0);
        if (!empty($id)) {
            $this->productRepository->delete($id);
        }
        $this->render('products/index', []);
    }
}
