<?php

namespace App\Support;

use PDO;

class AuthService
{
    public function __construct(private PDO $pdo) {}

    public function ensureSession()
    {
        if (session_id() === '') {
            session_start();
        }
    }

    public function logout()
    {
        $this->ensureSession();
        unset($_SESSION['user_email']);
        session_regenerate_id();
    }

    public function handleLogin(string $username, string $password): bool
    {
        if (empty($username)) return false;
        if (empty($password)) return false;

        $stmt = $this->pdo->prepare('SELECT `id`, `password` FROM `users` WHERE `username` = :username');
        $stmt->bindValue(':username', $username);
        $stmt->execute();
        $entry = $stmt->fetch(PDO::FETCH_ASSOC);

        if (empty($entry)) {
            return false;
        }

        $hash = $entry['password'];
        $passwordOk = password_verify($password, $hash);

        if (empty($passwordOk)) {
            return false;
        }

        $this->ensureSession();
        $_SESSION['user_id'] = $entry['id'];
        session_regenerate_id();

        return true;
    }

    public function isLoggedIn(): bool 
    {
        $this->ensureSession();
        return !empty($_SESSION['user_id']);
    }

    public function ensureLoggedIn()
    {
        $isLoggedIn = $this->isLoggedIn();
        if (empty($isLoggedIn)) {
            header('Location: index.php?' . http_build_query(['route' => 'admin/login']));
            die();
        }
    }
}
