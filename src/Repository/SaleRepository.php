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
        ORDER BY `sales`.`id` DESC'
        );
        $stmt->execute();
        $entries = $stmt->fetchAll(PDO::FETCH_CLASS, SaleModel::class);
        return $entries;
    }
    public function create(
        string $customer_name,
        float $discount_amount,
        float $total_amount,
        string $status,
        ?int $user_id
    ): int {
        $stmt = $this->pdo->prepare(
            'INSERT INTO `sales`
            (`customer_name`, `discount_amount`, `total_amount`, `status`, `user_id`)
            VALUES
            (:customer_name, :discount_amount, :total_amount, :status, :user_id)'
        );

        $stmt->bindValue(':customer_name', $customer_name);
        $stmt->bindValue(':discount_amount', $discount_amount);
        $stmt->bindValue(':total_amount', $total_amount);
        $stmt->bindValue(':status', $status);
        $stmt->bindValue(':user_id', $user_id);

        $stmt->execute();
        return (int) $this->pdo->lastInsertId();
    }
}
