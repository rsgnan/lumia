<?php

namespace App\Model;

class SaleModel {
    public int $id;
    public string $customer_name;
    public float $discount_amount;
    public float $total_amount;
    public string $status;
    public ?int $user_id;
}