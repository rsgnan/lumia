<?php

namespace App\Core;

abstract class ViewController
{

    // Renderiza uma página dentro do layout principal
    public function render(string $view, array $params): void
    {
        extract($params);
        
        ob_start();
        require __DIR__ . '/../../views/' . $view . '.view.php';
        $contents = ob_get_clean();

        require __DIR__ . '/../../views/layouts/main.view.php';
    }
}
