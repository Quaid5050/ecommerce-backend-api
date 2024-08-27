<?php

namespace App\Interfaces;
use Illuminate\Http\Request;

interface CategoryRepositoryInterface
{
    public function all();
    public function create(array $data);
    public function update(array $data, int $id);
    public function findById(int $id);
    public function delete(int $id);
    public function getCategoriesWithBrands();
    public function getCategoryWithBrands(int $categoryId);
    public function attachBrandWithCategory(int $categoryId, int $brandId);
    public function detachBrandFromCategory(int $categoryId, int $brandId);
}
