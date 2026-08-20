<?php

namespace App\Repository;

use PDO;
use App\Model\ProductModel;
use App\Model\CategoryModel;

class ProductRepository
{
    public function __construct(private PDO $pdo) {}

    public function get(int $id): ?ProductModel
    {
        $stmt = $this->pdo->prepare('SELECT * FROM `products` WHERE `id` = :id');
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, ProductModel::class);
        $entry = $stmt->fetch();
        return $entry !== false ? $entry : null;
    }
    
    public function getAll(): array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM `products` ORDER BY `name` ASC');
        $stmt->execute();
        $entries = $stmt->fetchAll(PDO::FETCH_CLASS, ProductModel::class);
        return $entries;
    }

    public function getById(int $id): ?ProductModel
    {
        $stmt = $this->pdo->prepare('SELECT * FROM `products` WHERE id = :id');
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, ProductModel::class);
        $entry = $stmt->fetch();
        return $entry ?: null;
    }

    public function getAllCategories(): array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM `categories` ORDER BY `name` ASC');
        $stmt->execute();
        $entries = $stmt->fetchAll(PDO::FETCH_CLASS, CategoryModel::class);
        return $entries;
    }

    public function categoryExists(int $category_id): bool
    {
        $stmt = $this->pdo->prepare('SELECT 1 FROM `categories` WHERE `id` = :id LIMIT 1');
        $stmt->bindValue(':id', $category_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn() !== false;
    }

    public function getWithCategoryName(): array
    {
        $stmt = $this->pdo->prepare('SELECT products.id, categories.name 
        AS category_name
        FROM `products`
        JOIN `categories` ON 
        `categories`.`id` = `products`.`category_id`
        ');
        $stmt->execute();
        $entries = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $entries;
    }

    public function create(string $name, int $category_id, string $tag, float $price, int $stock, string $description, string $photo)
    {
        $stmt = $this->pdo->prepare('INSERT 
        INTO `products` (`name`, `category_id`, `tag`, `price`, `stock`, `description`, `photo`)
        VALUES(:name, :category_id, :tag, :price, :stock, :description, :photo)');
        $stmt->bindValue(':name', $name);
        $stmt->bindValue(':category_id', $category_id, PDO::PARAM_INT);
        $stmt->bindValue(':tag', $tag);
        $stmt->bindValue(':price', $price);
        $stmt->bindValue(':stock', $stock, PDO::PARAM_INT);
        $stmt->bindValue(':description', $description);
        $stmt->bindValue(':photo', $photo);
        $stmt->execute();
    }

    public function delete(int $id): void
    {
        $stmt = $this->pdo->prepare('DELETE FROM `products` WHERE `id` = :id');
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function update(int $product_id, string $name, int $category_id, string $tag, float $price, int $stock, string $description, string $photo)
    {
        $stmt = $this->pdo->prepare('UPDATE `products`
        SET `name` = :name, `category_id` = :category_id,
        `tag` = :tag, `price` = :price, `stock` = :stock,
        `description` = :description, `photo` = :photo
        WHERE `id` = :id');
        $stmt->bindValue(':id', $product_id, PDO::PARAM_INT);
        $stmt->bindValue(':name', $name);
        $stmt->bindValue(':category_id', $category_id, PDO::PARAM_INT);
        $stmt->bindValue(':tag', $tag);
        $stmt->bindValue(':price', $price);
        $stmt->bindValue(':stock', $stock, PDO::PARAM_INT);
        $stmt->bindValue(':description', $description);
        $stmt->bindValue(':photo', $photo);
        $stmt->execute();
    }

    public function decreaseStock(int $productId, int $quantity): bool
    {
        $stmt = $this->pdo->prepare(
            'UPDATE `products`
            SET `stock` = `stock` - :quantity
            WHERE `id` = :id
            AND `stock` >= :quantity'
        );

        $stmt->bindValue(':id', $productId, PDO::PARAM_INT);
        $stmt->bindValue(':quantity', $quantity, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    public function increaseStock(int $productId, int $quantity): void
    {
        $stmt = $this->pdo->prepare(
            'UPDATE `products`
            SET `stock` = `stock` + :quantity
            WHERE `id` = :id'
        );

        $stmt->bindValue(':id', $productId, PDO::PARAM_INT);
        $stmt->bindValue(':quantity', $quantity, PDO::PARAM_INT);
        $stmt->execute();
    }
}
