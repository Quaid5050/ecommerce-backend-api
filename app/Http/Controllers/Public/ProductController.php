<?php

namespace App\Http\Controllers\Public;


use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Traits\ApiResponseTrait;
use App\Interfaces\ProductRepositoryInterface;
use App\Http\Resources\ProductResource;
use Exception;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use apiResponseTrait;
    protected ProductRepositoryInterface $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function index()
    {
        try {
            $products = $this->productRepository->all();
            return $this->successResponse([ProductResource::collection($products)],
                'Products Retrieved Successfully', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('An error occurred', 500);
        }
    }

    public function store(ProductRequest $request)
    {
        try {
            $product = $this->productRepository->create($request->all());
            return $this->successResponse([new ProductResource($product)],
                'Product Created Successfully', 201);
        } catch (\Exception $e) {
            return $this->errorResponse('An error occurred', 500);
        }
    }

    public function show(int $id)
    {
        try {
            $product = $this->productRepository->show($id);
            return $this->successResponse([new ProductResource($product)],
                'Product Retrieved Successfully', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('An error occurred', 500);
        }
    }

    public function update(ProductRequest $request, int $id)
    {
        try {
            $product = $this->productRepository->update($request->all(), $id);
            return $this->successResponse([new ProductResource($product)],
                'Product Updated Successfully', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('An error occurred', 500);
        }
    }

    public function destroy(int $id)
    {
        try {
            $this->productRepository->delete($id);
            return $this->successResponse([], 'Product Deleted Successfully', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('An error occurred', 500);
        }
    }

    public function getProductsWithPrinterModels(){
        try {
            $products = $this->productRepository->getProductsWithPrinterModels();
            return $this->successResponse([ProductResource::collection($products)],
                'Products Retrieved Successfully', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('An error occurred', 500);
        }
    }

    public function findProductWithPrinterModels(int $productId){
        try {
            $product = $this->productRepository->getProductWithPrinterModels($productId);
            return $this->successResponse([new ProductResource($product)],
                'Product Retrieved Successfully', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('An error occurred', 500);
        }
    }

}
