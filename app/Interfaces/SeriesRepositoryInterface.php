<?php

namespace App\Interfaces;

interface SeriesRepositoryInterface
{
    public function all();
    public function create(array $data);
    public function update(array $data, int $id);
    public function delete(int $id);
    public function show(int $id);
    public function findById(int $id);
    public function getSeriesWithPrinterModels();
    public function getSeriesWithPrinterModelsById(int $seriesId);

}
