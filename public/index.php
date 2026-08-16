<?php
// Exibe erros para melhor trabalhar
ini_set('display_errors', 1);
session_start();

// Carrega dependênciase funções
require __DIR__ . '/../src/Support/Autoloader.php';
require __DIR__ . '/../src/Support/Functions.php';

// Container básico do sistema
$container = new \App\Core\Container();
$container->bind('pdo', function () {
    return require __DIR__ . '/../src/Database/Connection.php';
});

// AuthService
$container->bind('authService', function () use ($container) {
    $pdo = $container->get('pdo');
    return new \App\Support\AuthService($pdo);
});

// Login
$container->bind('loginController', function () use ($container) {
    $authService = $container->get('authService');
    return new \App\Controller\LoginController($authService);
});

// Produtos
$container->bind('productRepository', function () use ($container) {
    $pdo = $container->get('pdo');
    return new \App\Repository\ProductRepository($pdo);
});

$container->bind('productController', function () use ($container) {
    $authService = $container->get('authService');
    $productRepository = $container->get('productRepository');
    return new \App\Controller\ProductController(
        $authService,
        $productRepository
    );
});

// CSRF
$container->bind('csrfHelper', function() {
    return new \App\Support\CsrfHelper();
});

$csrfHelper = $container->get('csrfHelper');
$csrfHelper->handle();

function csrf_token() {
    global $container;
    $csrfHelper = $container->get('csrfHelper');
    return $csrfHelper->generateToken();
}

// Errors
$container->bind('errorController', function () use ($container) {
    return new \App\Controller\ErrorController();
});

// Tratamento de route

$route = @(string) ($_GET['route'] ?? 'pages');

if ($route == 'pages') {
    $page = @(string) ($_GET['page'] ?? 'index');

    $adminController = $container->get('productController');
    $adminController->index();
} else if ($route === 'admin/login') {
    $adminController = $container->get('loginController');
    $adminController->login();
} else if ($route === 'admin/logout') {
    $adminController = $container->get('loginController');
    $adminController->logout();
} else if ($route === 'products/index') {
    $authService = $container->get('authService');
    $authService->ensureLoggedIn();

    $adminController = $container->get('productController');
    $adminController->index();
} else if ($route === 'products/create') {
    $authService = $container->get('authService');
    $authService->ensureLoggedIn();

    $adminController = $container->get('productController');
    $adminController->create();
} else if ($route === 'products/edit') {
    $authService = $container->get('authService');
    $authService->ensureLoggedIn();

    $adminController = $container->get('productController');
    $adminController->update();
} else if ($route === 'login/index') {
    $adminController = $container->get('productController');
    $adminController->update();
} else {
    // Nenhuma rota bateu então devolve o error 404
    $errorController = $container->get('errorController');
    $errorController->notFound();
}
