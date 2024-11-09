<?php
// app/Repositories/CategoryRepository.php
namespace App\Repositories;

use App\Models\Category;
use App\Repositories\Contracts\CategoryRepositoryInterface;

class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{
    public function __construct(Category $model)
    {
        parent::__construct($model);
    }

    public function getWithProducts()
    {
        return $this->model->with('products')->get();
    }
}
