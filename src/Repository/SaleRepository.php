<?php

namespace App\Repository;

use PDO;
use App\Model\SaleModel;

class SaleRepository
{
    public function __construct(private PDO $pdo) {}
    public function getAll(): array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM `sales` ORDER BY `id` DESC');
        $stmt->execute();
        $entries = $stmt->fetchAll(PDO::FETCH_CLASS, SaleModel::class);
        return $entries;
    }
    public function getList(): array
    {
        $stmt = $this->pdo->prepare(
            'SELECT `sales`.*,
            COUNT(`sale_items`.`id`) AS item_count,
            COALESCE(SUM(`sale_items`.`quantity`), 0) AS items_quantity
        FROM `sales`
        LEFT JOIN `sale_items` ON `sale_items`.`sale_id` = `sales`.`id`
        GROUP BY `sales`.`id`
        ORDER BY `sales`.`created_at` DESC'
        );
        $stmt->execute();
        $entries = $stmt->fetchAll(PDO::FETCH_CLASS, SaleModel::class);
        return $entries;
    }
}
