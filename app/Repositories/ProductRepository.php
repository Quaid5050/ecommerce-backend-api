<?php

namespace App\Repositories;

use App\Interfaces\ProductRepositoryInterface;
use App\Models\Product;
use Exception;
use Illuminate\Support\Facades\DB;

class ProductRepository implements ProductRepositoryInterface
{
    public function all()
    {
        return Product::all();
    }

    public function create(array $data)
    {
        DB::beginTransaction();
        try {
            $product = Product::create($data);
            DB::commit();
            return $product;
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception("Error Creating Product ".$e->getMessage());
        }
    }

    public function update(array $data, int $id)
    {
        DB::beginTransaction();
        try {
            $product = $this->findById($id);
            $product->update($data);
            DB::commit();
            return $product;
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception("Error Updating Product ".$e->getMessage());
        }
    }

    public function delete(int $id)
    {
        DB::beginTransaction();
        try {
            $product = $this->findById($id);
            $product->delete();
            DB::commit();
            return $product;
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception("Error Deleting Product ".$e->getMessage());
        }
    }

    public function show(int $id)
    {
        return $this->findById($id);
    }

    public function findById(int $id)
    {
        return Product::findOrFail($id);
    }

    public function attachPrinterModelWithProduct(int $printerModelId, int $productId)
    {
        $product = $this->findById($productId);
        $product->printerModels()->attach($printerModelId);
        return $product;
    }

    public function detachPrinterModelFromProduct(int $printerModelId, int $productId)
    {
        $product = $this->findById($productId);
        $product->printerModels()->detach($printerModelId);
        return $product;
    }

    public function getProductWithPrinterModels(int $productId)
    {
        return $this->findById($productId)->printerModels;
    }

    public function getProductsWithPrinterModels()
    {
        return Product::with('printerModels')->get();
    }
}
