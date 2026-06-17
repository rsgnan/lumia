<?php

try {
    $pdo = new PDO('mysql:host=localhost;dbname=lumia;charset=utf8mb4', 'rsgnan', 'oncamotos19' , [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION    
    ]);
}
catch (PDOException $e) {
    echo 'A problem ocurred with the database connection...';
    die();
}

return $pdo;