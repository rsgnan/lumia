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

    public function getAllCategories(): array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM `categories` ORDER BY `name` ASC');
        $stmt->execute();
        $entries = $stmt->fetchAll(PDO::FETCH_CLASS, CategoryModel::class);
        return $entries;
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
}
