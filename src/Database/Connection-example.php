<?php

try {
    $pdo = new PDO('mysql:host=localhost;dbname=lumia;charset=utf8mb4', '', '', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
}
catch (PDOException $e) {
    var_dump($e->getMessage());
    die();
}

return $pdo;
