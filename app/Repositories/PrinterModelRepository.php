<?php

namespace App\Repositories;

use App\Interfaces\PrinterModelRepositoryInterface;
use App\Models\PrinterModel;
use Exception;
use Illuminate\Support\Facades\DB;

class PrinterModelRepository implements  PrinterModelRepositoryInterface
{
    public function all()
    {
        return PrinterModel::all();
    }

    public function create(array $data)
    {
        DB::beginTransaction();
        try {
            $printerModel = PrinterModel::create($data);
            DB::commit();
            return $printerModel;
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception("Error Creating PrinterModel ".$e->getMessage());
        }
    }

    public function update(array $data, int $id)
    {
        DB::beginTransaction();
        try {
            $printerModel = $this->findById($id);
            $printerModel->update($data);
            DB::commit();
            return $printerModel;
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception("Error Updating PrinterModel ".$e->getMessage());
        }
    }

    public function delete(int $id)
    {
        DB::beginTransaction();
        try {
            $printerModel = $this->findById($id);
            $printerModel->delete();
            DB::commit();
            return $printerModel;
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception("Error Deleting PrinterModel ".$e->getMessage());
        }
    }

    public function show(int $id)
    {
        return $this->findById($id);
    }

    public function findById(int $id)
    {
        return PrinterModel::find($id);
    }

    public function attachProductWithPrinterModel(int $printerModelId, int $productId)
    {
        DB::beginTransaction();
        try {
            $printerModel = $this->findById($printerModelId);
            $printerModel->products()->attach($productId);
            DB::commit();
            return $printerModel;
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception("Error Attaching Product with PrinterModel ".$e->getMessage());
        }
    }

    public function detachProductFromPrinterModel(int $printerModelId, int $productId)
    {
        DB::beginTransaction();
        try {
            $printerModel = $this->findById($printerModelId);
            $printerModel->products()->detach($productId);
            DB::commit();
            return $printerModel;
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception("Error Detaching Product from PrinterModel ".$e->getMessage());
        }
    }

    public function getPrinterModelWithProducts(int $printerModelId)
    {
       return PrinterModel::with("products")->find($printerModelId);
    }

    public function getPrinterModelsWithProducts()
    {
       return PrinterModel::with("products")->get();
    }

}
