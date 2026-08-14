<?php

namespace App\Controller;

use App\Support\AuthService;
use App\Core\ViewController;

class LoginController extends ViewController
{
    public function logout()
    {
        $this->authService->logout();
        header('Location: index.php?' . http_build_query(['route' => 'admin/login']));
    }
    public function login()
    {
        if ($this->authService->isLoggedIn()) {
            header('Location: index.php?' . http_build_query(['route' => 'products/index']));
        }

        $loginError = false;
        if (!empty($_POST)) {
            $email = @(string) ($_POST['email'] ?? '');
            $password = @(string) ($_POST['password'] ?? '');

            if (!empty($email) && !empty($password)) {
                $loginOK = $this->authService->handleLogin($email, $password);
                if ($loginOK == true) {
                    header('Location: index.php?' . http_build_query(['route' => 'products/index']));
                    return;
                } else {
                    $loginError = true;
                }
            } else {
                $loginError = true;
            }
        }

        $this->render('login/index', [
            'loginError' => $loginError
        ]);
    }
}
