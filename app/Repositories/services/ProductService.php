<?php

namespace App\Services;

use App\Repositories\Contracts\ProductRepositoryInterface;

class ProductService
{
    protected $product_repository;

    public function __construct(ProductRepositoryInterface $product_repository)
    {
        $this->product_repository = $product_repository;
    }

    public function getAllProducts()
    {
        return $this->product_repository->all();
    }

    public function getProductsByCategory($category_id)
    {
        return $this->product_repository->findByCategory($category_id);
    }

    public function createProduct(array $data)
    {
        return $this->product_repository->create($data);
    }

    public function updateProduct($id, array $data)
    {
        return $this->product_repository->update($id, $data);
    }

    public function deleteProduct($id)
    {
        return $this->product_repository->delete($id);
    }
}