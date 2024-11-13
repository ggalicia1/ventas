<?php

namespace App\Repositories\Services;

use App\Repositories\Contracts\CategoryRepositoryInterface;

class CategoryService
{
    protected $category_repository;

    public function __construct(CategoryRepositoryInterface $category_repository)
    {
        $this->category_repository = $category_repository;
    }

    public function getAllCategories()
    {
        return $this->category_repository->all();
    }

    public function getCategoryWithProducts($id)
    {
        return $this->category_repository->find($id)->load('products');
    }

    public function createCategory(array $data)
    {
        return $this->category_repository->create($data);
    }

    public function updateCategory($id, array $data)
    {
        return $this->category_repository->update($id, $data);
    }

    public function deleteCategory($id)
    {
        return $this->category_repository->delete($id);
    }
}