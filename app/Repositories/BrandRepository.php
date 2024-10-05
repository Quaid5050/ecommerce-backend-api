<?php

namespace App\Repositories;

use App\Models\Brand;
use App\Interfaces\BrandRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Exception;

class BrandRepository implements BrandRepositoryInterface
{
    public function all()
    {
        return Brand::all();
    }

    public function create(array $data)
    {
        DB::beginTransaction();
        try {
            $brand = Brand::create($data);
            DB::commit();
            return $brand;
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception("Error creating brand: " . $e->getMessage());
        }
    }

    public function update(array $data, int $id)
    {
        DB::beginTransaction();
        try {
            $brand = $this->findById($id);
            $brand->update($data);
            DB::commit();
            return $brand;
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception("Error updating brand: " . $e->getMessage());
        }
    }

    public function findById(int $id)
    {
        return Brand::find($id);
    }

    public function delete(int $id)
    {
        DB::beginTransaction();
        try {
            $brand = $this->findById($id);
            if ($brand) {
                $brand->delete();
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception("Error deleting brand: " . $e->getMessage());
        }
    }

    public  function getBrandWithCategories(int $brandId)
    {
        return Brand::with('categories')->find($brandId);
    }
    public function getBrandWithSeries(int $brandId)
    {
        return Brand::with('series')->find($brandId);
    }
    public function getBrandWithSeriesAndPrinterModels(int $brandId)
    {
        return Brand::with('series.printerModels')->find($brandId);
    }

    public function getBrandsWithCategories()
    {
        return Brand::with('categories')->get();
    }

}
