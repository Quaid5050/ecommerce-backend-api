<?php
namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Requests\BrandRequest;
use App\Http\Resources\BrandResource;
use App\Interfaces\BrandRepositoryInterface;
use App\Traits\ApiResponseTrait;
use Exception;

class BrandController extends Controller
{
    use ApiResponseTrait;

    protected BrandRepositoryInterface $brandRepository;

    public function __construct(BrandRepositoryInterface $brandRepository)
    {
        $this->brandRepository = $brandRepository;
    }

    public function index()
    {
        try {
            $brands = $this->brandRepository->all();
            return $this->successResponse([
                BrandResource::collection($brands),
            ], 'Brands retrieved successfully.');
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function store(BrandRequest $request)
    {
        try {
            $brand = $this->brandRepository->create($request->validated());
            return $this->successResponse([
                new BrandResource($brand),
            ], 'Brand created successfully.', 201);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function show(int $id)
    {
        try {
            $brand = $this->brandRepository->findById($id);
            if ($brand) {
                return $this->successResponse([
                    new BrandResource($brand),
                ], 'Brand retrieved successfully.');
            } else {
                return $this->errorResponse('Brand not found.', 404);
            }
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function update(BrandRequest $request, int $id)
    {
        try {
            $brand = $this->brandRepository->update($request->validated(), $id);
            return $this->successResponse([
                new BrandResource($brand),
            ], 'Brand updated successfully.');
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(),);
        }
    }

    public function destroy(int $id)
    {
        try {
            $this->brandRepository->delete($id);
            return $this->successResponse([], 'Brand deleted successfully.', 204);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), );
        }
    }
    public function getBrandsWithCategories()
    {
        try {
            $categories = $this->brandRepository->getBrandsWithCategories();
            return $this->successResponse([
                BrandResource::collection($categories),
            ], 'Retrieved successfully.');
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
    public function getBrandWithCategories(int $id)
    {
        try {
            $categories = $this->brandRepository->getBrandWithCategories($id);
            return $this->successResponse([
                new BrandResource($categories),
                ], 'Retrieved successfully.');
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
    public function getBrandWithSeries(int $id)
    {
        try {
            $series = $this->brandRepository->getBrandWithSeries($id);
            return $this->successResponse([
                new BrandResource($series),
            ], 'Brand with Series retrieved successfully.');
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function getBrandWithSeriesAndPrinterModels(int $id)
    {
        try {
            $series = $this->brandRepository->getBrandWithSeriesAndPrinterModels($id);
            return $this->successResponse([
                new BrandResource($series),
                ], 'Brand with Series & Printer Models retrieved successfully.');
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

}
