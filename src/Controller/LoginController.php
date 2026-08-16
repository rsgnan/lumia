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
            return;
        }

        $loginError = false;
        $username = '';
        if (!empty($_POST)) {
            $username = @(string) ($_POST['username'] ?? '');
            $password = @(string) ($_POST['password'] ?? '');

            if (!empty($username) && !empty($password)) {
                $loginOK = $this->authService->handleLogin($username, $password);
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

        $this->renderStandalone('admin/login', [
            'loginError' => $loginError,
            'oldUsername' => $username
        ]);
    }
}
