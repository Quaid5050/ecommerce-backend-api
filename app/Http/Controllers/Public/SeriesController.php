<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponseTrait;
use Exception;
use Illuminate\Http\Request;
use App\Models\Series;
use App\Interfaces\SeriesRepositoryInterface;
use App\Http\Requests\SeriesRequest;
use App\Http\Resources\SeriesResource;


class SeriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use apiResponseTrait;
    protected SeriesRepositoryInterface $seriesRepository;

    public function __construct(SeriesRepositoryInterface $seriesRepository)
    {
        $this->seriesRepository = $seriesRepository;
    }

    public function index()
    {
        try {
            $series = $this->seriesRepository->all();
            return $this->successResponse([
                SeriesResource::collection($series),
            ], 'Series retrieved successfully.');
        } catch (Exception $e) {
            return $this->errorResponse("Series retrieved Failed",$e->getMessage(), 500);
        }
    }

    public function store(SeriesRequest $request)
    {
        try {
            $series = $this->seriesRepository->create($request->all());
            return $this->successResponse([
                new SeriesResource($series),
            ], 'Series created successfully.', 201);
        } catch (Exception $e) {
            return $this->errorResponse("Series created Failed",$e->getMessage(), 500);
        }
    }

    public function show(string $id)
    {
        try {
            $series = $this->seriesRepository->find($id);
            return $this->successResponse([
                new SeriesResource($series),
            ], 'Series retrieved successfully.');
        } catch (Exception $e) {
            return $this->errorResponse("Series retrieved Failed",$e->getMessage(), 500);
        }
    }

    public function update(SeriesRequest $request, string $id)
    {
        try {
            $series = $this->seriesRepository->update($request->all(), $id);
            return $this->successResponse([
                new SeriesResource($series),
            ], 'Series updated successfully.');
        } catch (Exception $e) {
            return $this->errorResponse("Series updated Failed",$e->getMessage(), 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            $this->seriesRepository->delete($id);
            return $this->successResponse([], 'Series deleted successfully.', 204);
        } catch (Exception $e) {
            return $this->errorResponse("Series deleted Failed",$e->getMessage(), 500);
        }
    }

    public function getSeriesWithPrinterModels()
    {
        try {
            $series = $this->seriesRepository->getSeriesWithPrinterModels();
            return $this->successResponse([
                SeriesResource::collection($series),
            ], 'Series retrieved successfully.');
        } catch (Exception $e) {
            return $this->errorResponse("Series retrieved Failed",$e->getMessage(), 500);
        }
    }

    public function findSeriesWithPrinterModels(int $seriesId)
    {
        try {
            $series = $this->seriesRepository->getSeriesWithPrinterModelsById($seriesId);
            return $this->successResponse([
                new SeriesResource($series),
            ], 'Series retrieved successfully.');
        } catch (Exception $e) {
            return $this->errorResponse("Series retrieved Failed",$e->getMessage(), 500);
        }
    }
}
