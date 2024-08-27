<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface BrandRepositoryInterface
{
    public function all();
    public function create(array $data);
    public function update(array $data, int $id);
    public function findById(int $id);
    public function delete(int $id);
    public function getBrandsWithCategories();
    public function getBrandWithCategories(int $brandId);
    public  function getBrandWithSeries(int $brandId);
    public  function getBrandWithSeriesAndPrinterModels(int $brandId);
}
