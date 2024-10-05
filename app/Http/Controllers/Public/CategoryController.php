<?php
namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Interfaces\CategoryRepositoryInterface;
use App\Traits\ApiResponseTrait;
use Exception;


class CategoryController extends Controller
{
    use ApiResponseTrait;

    protected CategoryRepositoryInterface $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function index()
    {
        try {
            $categories = $this->categoryRepository->all();
            return $this->successResponse([
                CategoryResource::collection($categories),
            ], 'Categories retrieved successfully.');
        } catch (Exception $e) {
            return $this->errorResponse("Categories retrieved failed",$e->getMessage());
        }
    }

    public function store(CategoryRequest $request)
    {
        try {
            $category = $this->categoryRepository->create($request->validated());
            return $this->successResponse([
                new CategoryResource($category),
            ], 'Category created successfully.', 201);
        } catch (Exception $e) {
            return $this->errorResponse("Category created failed",$e->getMessage());
        }
    }

    public function show(int $id)
    {
        try {
            $category = $this->categoryRepository->findById($id);
            if ($category) {
                return $this->successResponse([
                    new CategoryResource($category),
                ], 'Category retrieved successfully.');
            } else {
                return $this->errorResponse('Category not found.', [],404);
            }
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function update(CategoryRequest $request, int $id)
    {
        try {
            $category = $this->categoryRepository->update($request->validated(), $id);
            return $this->successResponse([
                new CategoryResource($category),
            ], 'Category updated successfully.');
        } catch (Exception $e) {
            return $this->errorResponse("Fail to Update",$e->getMessage(), 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            $this->categoryRepository->delete($id);
            return $this->successResponse([], 'Category deleted successfully.', 204);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
    public function getCategoriesWithBrands()
    {
        try {
            $categories = $this->categoryRepository->getCategoriesWithBrands();
            return $this->successResponse([
               new CategoryResource($categories),
            ], 'Retrieved successfully.');
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function getCategoryWithBrands(int $id)
    {
        try {
            $category = $this->categoryRepository->getCategoryWithBrands($id);
            return $this->successResponse([
                new CategoryResource($category),
            ], 'Retrieved successfully.');
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
    public function attachBrandWithCategory(int $categoryId, int $brandId)
    {
        try {
            $this->categoryRepository->attachBrandWithCategory($categoryId, $brandId);
            return $this->successResponse([], 'Brand attached to category successfully.', 201);
        } catch (Exception $e) {
            return $this->errorResponse("Brand attached to category failed",$e->getMessage(), 500);
        }
    }

    public function detachBrandFromCategory(int $categoryId, int $brandId)
    {
        try {
            $this->categoryRepository->detachBrandFromCategory($categoryId, $brandId);
            return $this->successResponse([], 'Brand detached from category successfully.', 201);
        } catch (Exception $e) {
            return $this->errorResponse("Brand detached from category failed",$e->getMessage(), 500);
        }
    }



}
