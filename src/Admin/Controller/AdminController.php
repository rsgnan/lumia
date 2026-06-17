<?php

namespace App\Admin\Controller;

class AdminController
{
    public function __construct() {}
    public function dispatch(string $route): void
    {
        if (method_exists($this, $route)) {
            $this->$route();
        } else {
            $this->render($route, []);
        }
    }
    protected function render($view, $params): void
    {
        extract($params);
        ob_start();
        require __DIR__ . '/../../../views/' . $view . '.view.php';
        $contents = ob_get_clean();
        require __DIR__ . '/../../../views/main.view.php';
    }
}
