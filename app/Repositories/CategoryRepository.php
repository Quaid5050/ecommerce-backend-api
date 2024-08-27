<?php

namespace App\Repositories;

use App\Interfaces\CategoryRepositoryInterface;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Exception;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function all()
    {
        return Category::all();
    }

    public function create(array $data)
    {
        DB::beginTransaction();
        try {
            $category = Category::create($data);
            DB::commit();
            return $category;
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception("Error creating category: " . $e->getMessage());
        }
    }

    public function update(array $data, int $id)
    {
        DB::beginTransaction();
        try {
            $category = $this->findById($id);
            $category->update($data);
            DB::commit();
            return $category;
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception("Error updating category: " . $e->getMessage());
        }
    }

    public function findById(int $id)
    {
        return Category::find($id);
    }

    public function delete(int $id)
    {
        DB::beginTransaction();
        try {
            $category = $this->findById($id);
            if ($category) {
                $category->delete();
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception("Error deleting category: " . $e->getMessage());
        }
    }

    public function getCategoriesWithBrands()
    {
        return Category::with("brands");
    }

    public function getCategoryWithBrands(int $categoryId)
    {
        return Category::with("brands")->find($categoryId);
    }

    public function attachBrandWithCategory(int $categoryId, int $brandId)
    {
        try {
            $category = $this->findById($categoryId);
            $category->brands()->attach($brandId);
        } catch (Exception $exception) {
            throw new Exception("Error attaching brand with category: " . $exception->getMessage());
        }
    }

    public function detachBrandFromCategory(int $categoryId, int $brandId)
    {
        try {
            $category = $this->findById($categoryId);
            $category->brands()->detach($brandId);
        } catch (Exception $exception) {
            throw new Exception("Error detaching brand with category: " . $exception->getMessage());
        }
    }
}

