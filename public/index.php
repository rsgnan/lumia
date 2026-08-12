<?php
// Exibe erros para melhor trabalhar
ini_set('display_errors', 1);

// Carrega dependênciase funções
require __DIR__ . '/../src/Support/Autoloader.php';
require __DIR__ . '/../src/Support/Functions.php';

// Container básico do sistema
$container = new \App\Core\Container();
$container->bind('pdo', function() {
    return require __DIR__ . '/../src/Database/Connection.php';
});

// Produtos
$container->bind('productRepository', function() use ($container) {
    $pdo = $container->get('pdo');
    return new \App\Repository\ProductRepository($pdo);
});

$container->bind('productController', function() use($container) {
    $productRepository = $container->get('productRepository');
    return new \App\Controller\ProductController($productRepository);
});

// Errors
$container->bind('errorController', function() use($container) {
    return new \App\Controller\ErrorController();
});

// Tratamento de route

$route = @(string) ($_GET['route'] ?? 'pages');

if($route == 'pages') {
    $page = @(string) ($_GET['page'] ?? 'index');

    $adminController = $container->get('productController');
    $adminController->showPage($page);
} else if ($route === 'products/index') {
    $adminController = $container->get('productController');
    $adminController->index();
} else if ($route === 'products/create') {
    $adminController = $container->get('productController');
    $adminController->create();
    } else if ($route === 'products/edit') {
    $adminController = $container->get('productController');
    $adminController->update();
} else {
    // Nenhuma rota bateu então devolve o error 404
    $errorController = $container->get('errorController');
    $errorController->notFound();
}
