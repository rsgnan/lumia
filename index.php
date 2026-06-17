<?php
// Exibe erros para facilitar o desenvolvimento
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Carrega arquivos essenciais
require __DIR__ . '/inc/all.inc.php';

// Conexão com banco de dados
$container = new \App\Support\Container();
$container->bind('pdo', function () {
    return require __DIR__ . '/inc/db-connection.php';
});


// Brands
$container->bind('brandsRepository', function () use ($container) {
    $pdo = $container->get('pdo');
    return new \App\Repository\BrandsRepository($pdo);
});

$container->bind('brandsController', function () use ($container) {
    $brandsRepository = $container->get('brandsRepository');
    return new \App\Admin\Controller\BrandsController(
        $brandsRepository
    );
});

$route = @(string) ($_GET['route'] ?? 'index');

if ($route === 'index') {
    $container->bind('controller', function () {
        return new \App\Admin\Controller\AdminController();
    });
    $container->get('controller')->dispatch($route);
} else if ($route === 'brands/index') {
    // Brands
    $container->get('brandsController')->index();
} else if ($route === 'brands/create') {
    $brandsController = $container->get('brandsController');
    $brandsController->create();
}
