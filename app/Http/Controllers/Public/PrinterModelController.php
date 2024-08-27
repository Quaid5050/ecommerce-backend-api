<?php

namespace App\Http\Controllers\Public;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use App\Models\PrinterModel;
use App\Http\Requests\PrinterModelRequest;
use App\Http\Resources\PrinterModelResource;
use App\Interfaces\PrinterModelRepositoryInterface;
class PrinterModelController extends Controller
{
   use apiResponseTrait;
   protected PrinterModelRepositoryInterface $printerModelRepository;

    public function __construct(PrinterModelRepositoryInterface $printerModelRepository)
    {
         $this->printerModelRepository = $printerModelRepository;
    }

    public function index()
    {
        try {
            $printerModels = $this->printerModelRepository->all();
            return $this->successResponse([PrinterModelResource::collection($printerModels)],
                'Printer Models Retrieved Successfully', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('An error occurred', 500);
        }
    }

    public function store(PrinterModelRequest $request)
    {
        try {
            $printerModel = $this->printerModelRepository->create($request->all());
            return $this->successResponse([new PrinterModelResource($printerModel)],
                'Printer Model Created Successfully', 201);
        } catch (\Exception $e) {
            return $this->errorResponse('An error occurred', 500);
        }
    }

    public function show(int $id)
    {
        try {
            $printerModel = $this->printerModelRepository->show($id);
            return $this->successResponse([new PrinterModelResource($printerModel)],
                'Printer Model Retrieved Successfully', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('An error occurred', 500);
        }
    }

    public function update(PrinterModelRequest $request, int $id)
    {
        try {
            $printerModel = $this->printerModelRepository->update($request->all(), $id);
            return $this->successResponse([new PrinterModelResource($printerModel)],
                'Printer Model Updated Successfully', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('An error occurred', 500);
        }
    }

    public function destroy(int $id)
    {
        try {
            $this->printerModelRepository->delete($id);
            return $this->successResponse([], 'Printer Model Deleted Successfully', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('An error occurred', 500);
        }
    }

    public function attachProductWithPrinterModel(int $printerModelId, int $productId)
    {
        try {
            $this->printerModelRepository->attachProductWithPrinterModel($printerModelId, $productId);
            return $this->successResponse([], 'Product Attached Successfully', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('An error occurred', 500);
        }
    }


    public function detachProductFromPrinterModel(int $printerModelId,int $productId)
    {
        try {
            $this->printerModelRepository->detachProductFromPrinterModel($printerModelId, $productId);
            return $this->successResponse([], 'Product Detached Successfully', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('An error occurred', 500);
        }
    }

    public function getPrinterModelsWithProducts()
    {
        try {
            $printerModels = $this->printerModelRepository->getPrinterModelsWithProducts();
            return $this->successResponse([PrinterModelResource::collection($printerModels)],
                'Printer Models Retrieved Successfully', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('An error occurred', 500);
        }
    }

    public function getPrinterModelWithProducts(int $printerModelId)
    {
        try {
            $printerModel = $this->printerModelRepository->getPrinterModelWithProducts($printerModelId);
            return $this->successResponse([new PrinterModelResource($printerModel)],
                'Printer Model Retrieved Successfully', 200);
        } catch (\Exception $e) {
            return $this->errorResponse('An error occurred', 500);
        }
    }

}
