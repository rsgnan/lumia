<?php

namespace App\Model;

class BrandModel {
    public int $id;
    public string $name;
    public ?string $photo = null;
    public ?string $created_at = null;
    public ?string $updated_at = null;
}