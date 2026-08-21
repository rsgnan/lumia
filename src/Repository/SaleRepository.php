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

    public function getById(int $id): ?SaleModel
    {
        $stmt = $this->pdo->prepare(
            'SELECT * FROM `sales`
            WHERE `id` = :id'
        );

        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_CLASS, SaleModel::class);

        $sale = $stmt->fetch();

        return $sale !== false ? $sale : null;
    }

    public function update(
        int $saleId,
        string $customer_name,
        float $discount_amount,
        float $total_amount,
        string $status
    ): void {
        $stmt = $this->pdo->prepare(
            'UPDATE `sales`
            SET
                `customer_name` = :customer_name,
                `discount_amount` = :discount_amount,
                `total_amount` = :total_amount,
                `status` = :status
            WHERE `id` = :id'
        );

        $stmt->bindValue(':id', $saleId, PDO::PARAM_INT);
        $stmt->bindValue(':customer_name', $customer_name);
        $stmt->bindValue(':discount_amount', $discount_amount);
        $stmt->bindValue(':total_amount', $total_amount);
        $stmt->bindValue(':status', $status);
        
        $stmt->execute();

    }
    public function updateStatus(int $saleId, string $status): void
    {
        $stmt = $this->pdo->prepare(
            'UPDATE `sales`
            SET `status` = :status
            WHERE `id` = :id'
        );

        $stmt->bindValue(':id', $saleId, PDO::PARAM_INT);
        $stmt->bindValue(':status', $status);

        $stmt->execute();
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
