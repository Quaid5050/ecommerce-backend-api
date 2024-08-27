<?php

namespace App\Interfaces;

interface PrinterModelRepositoryInterface
{
    public function all();
    public function create(array $data);
    public function update(array $data, int $id);
    public function delete(int $id);
    public function show(int $id);
    public function findById(int $id);
    public function attachProductWithPrinterModel(int $printerModelId, int $productId);
    public function detachProductFromPrinterModel(int $printerModelId, int $productId);
    public function getPrinterModelWithProducts(int $printerModelId);
    public function getPrinterModelsWithProducts();

}
