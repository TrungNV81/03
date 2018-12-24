<?php

namespace App\Http\Repositories;

use App\Http\Models\DetailsDataImportModel;
use Illuminate\Support\Facades\DB;

class DetailsDataImportRepository extends BaseRepository
{
    /**
     * @var DetailsDataImportModel
     */
    protected $detailDataImportModel;

    /**
     * DetailsDataImportRepository constructor.
     */
    public function __construct()
    {
        $this->detailDataImportModel = new DetailsDataImportModel();
    }

    /**
     * @param $sub_id
     * @return mixed
     */
    public function getMaxId($sub_id)
    {
        return $this->detailDataImportModel->max($sub_id);
    }

    /**
     * @param $importId
     * @param $maxSubId
     * @param $sheetName
     * @param $floor
     * @param $name
     * @param $thickness
     * @param $totalx
     * @return mixed
     */
    public function insertDetailsData($importId,  $maxSubId, $sheetName, $floor, $name, $thickness, $totalx)
    {
        return $this->detailDataImportModel->insert([
            ['id' => $importId, 'sub_id' => $maxSubId, 'sheet' => $sheetName,
            'floor' => $floor, 'name' => $name, 'thickness' => $thickness, 'total' => $totalx]
        ]);
    }

    /**
     * @param $importId
     * @param $thickness
     * @return mixed
     */
    public function getDataInformation($importId,  $thickness)
    {
        return $this->detailDataImportModel->where([
            ['id', '=', $importId],
            ['thickness', '=', $thickness],
        ])
            ->get();
    }

    /**
     * @param $importId
     * @param $sheet
     * @param $thickness
     * @return mixed
     */
    public function getDataFactory($importId, $sheet, $thickness)
    {
        return $this->detailDataImportModel->select('name', 'thickness', 'total as F1', DB::raw('sum(total) as total'))
            ->where([
                ['id', '=', $importId],
                ['sheet', '=', $sheet],
                ['thickness', '!=', $thickness],
            ])
            ->groupBy('name')
            ->get();
    }
}
