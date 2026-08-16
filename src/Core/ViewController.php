<?php

namespace App\Core;

use App\Support\AuthService;

abstract class ViewController
{
    public function __construct(protected AuthService $authService) {}

    // Renderiza uma página dentro do layout principal
    protected function render(string $view, array $params): void
    {
        extract($params);
        
        ob_start();
        require __DIR__ . '/../../views/' . $view . '.view.php';
        $contents = ob_get_clean();

        $isLoggedIn = $this->authService->isLoggedIn();

        require __DIR__ . '/../../views/layouts/main.view.php';
    }

    // Renderiza uma página sozinha
    protected function renderStandalone(string $view, array $params): void 
    {
        extract($params);

        require __DIR__ . '/../../views/' . $view . '.view.php';
    }

}
