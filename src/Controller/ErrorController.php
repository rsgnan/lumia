<?php

namespace App\Controller;

use App\Core\ViewController;

class ErrorController extends ViewController
{
    // Error 404
    public function notFound(): void
    {
        http_response_code(404);

        $this->render('errors/404', []);
    }
}
