<?php

namespace App\Repository;

use PDO;

class SaleItemRepository
{
    public function __construct(private PDO $pdo) {}

    public function create(
        int $sale_id,
        int $product_id,
        string $product_name,
        float $original_price,
        float $unit_price,
        int $quantity,
        float $subtotal
    ): void {
        $stmt = $this->pdo->prepare(
            'INSERT INTO `sale_items`
            (`sale_id`, `product_id`, `product_name`, `original_price`, `unit_price`, `quantity`, `subtotal`)
            VALUES
            (:sale_id, :product_id, :product_name, :original_price, :unit_price, :quantity, :subtotal)'
        );

        $stmt->bindValue(':sale_id', $sale_id, PDO::PARAM_INT);
        $stmt->bindValue(':product_id', $product_id, PDO::PARAM_INT);
        $stmt->bindValue(':product_name', $product_name);
        $stmt->bindValue(':original_price', $original_price);
        $stmt->bindValue(':unit_price', $unit_price);
        $stmt->bindValue(':quantity', $quantity, PDO::PARAM_INT);
        $stmt->bindValue(':subtotal', $subtotal);

        $stmt->execute();
    }
}