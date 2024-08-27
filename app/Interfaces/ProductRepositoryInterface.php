<?php

namespace App\Interfaces;

interface ProductRepositoryInterface
{
    public function all();
    public function create(array $data);
    public function update(array $data, int $id);
    public function delete(int $id);
    public function show(int $id);
    public function findById(int $id);
    public function attachPrinterModelWithProduct(int $PrinterModelId, int $productId);
    public function detachPrinterModelFromProduct(int $PrinterModelId, int $productId);
    public function getProductWithPrinterModels(int $productId);
    public function getProductsWithPrinterModels();

}
