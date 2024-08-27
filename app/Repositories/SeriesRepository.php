<?php

namespace App\Repositories;

use App\Interfaces\SeriesRepositoryInterface;
use App\Models\Series;
use Exception;
use Illuminate\Support\Facades\DB;

class SeriesRepository implements SeriesRepositoryInterface
{
    public function all()
    {
        return Series::all();
    }

    public function create(array $data)
    {
        Db::beginTransaction();
        try {
            $series = Series::create($data);
            Db::commit();
            return $series;
        } catch (Exception $e) {
            Db::rollBack();
           throw new Exception("Error creating series: " . $e->getMessage());
        }
    }

    public function update(array $data, int $id)
    {
        Db::beginTransaction();
        try {
            $series = $this->findById($id);
            $series->update($data);
            Db::commit();
            return $series;
        } catch (Exception $e) {
            Db::rollBack();
            throw new Exception("Error updating series: " . $e->getMessage());
        }
    }

    public function delete(int $id)
    {
        Db::beginTransaction();
        try {
            $series = $this->findById($id);
            if ($series) {
                $series->delete();
            }
            Db::commit();
        } catch (Exception $e) {
            Db::rollBack();
            throw new Exception("Error deleting series: " . $e->getMessage());
        }
    }

    public function show(int $id)
    {
        return $this->findById($id);
    }

    public function findById(int $id)
    {
        return Series::find($id);
    }

    public function getSeriesWithPrinterModels()
    {
        return Series::with('printerModels')->get();
    }

    public function getSeriesWithPrinterModelsById(int $seriesId)
    {
        return Series::with('printerModels')->find($seriesId);
    }


}
