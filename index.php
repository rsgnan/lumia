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


$route = @(string) ($_GET['route'] ?? 'index');

$container->bind('controller', function() {
    return new \App\Admin\Controller\AdminController();
});

$controller = $container->get('controller');
$controller->dispatch($route);

