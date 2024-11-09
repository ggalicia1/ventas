<?php

// app/Repositories/Contracts/ProductRepositoryInterface.php
namespace App\Repositories\Contracts;

interface ProductRepositoryInterface extends BaseRepositoryInterface
{
    public function findByCategory($category_id);
}