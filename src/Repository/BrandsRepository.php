<?php

namespace App\Repository;

use PDO;
use App\Model\BrandModel;

class BrandsRepository
{
    public function __construct(private PDO $pdo) {}
    public function get(): array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM `brands` ORDER BY `id` ASC');
        $stmt->execute();
        $entries = $stmt->fetchAll(PDO::FETCH_CLASS, BrandModel::class);
        return $entries;
    }
}
