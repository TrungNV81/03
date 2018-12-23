<?php

namespace App\Http\Repositories;

use App\Http\Models\DetailsDataImportModel;

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
}
