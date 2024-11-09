<?php

// app/Repositories/Contracts/CategoryRepositoryInterface.php
namespace App\Repositories\Contracts;

interface CategoryRepositoryInterface extends BaseRepositoryInterface
{
    public function getWithProducts();
}