<?php

namespace App\Model;

class ProductModel {
    public int $id;
    public string $name;
    public int $category_id;
    public string $category_name;
    public string $tag;
    public string $price;
    public int $stock;
    public string $photo;
    public string $description;
}