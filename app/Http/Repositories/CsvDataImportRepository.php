<?php

namespace App\Http\Repositories;

use App\Http\Models\CsvDataImportModel;

class CsvDataImportRepository extends BaseRepository
{
    /**
     * @var CsvDataImportModel
     */
    protected $csvDataImportModel;

    /**
     * CsvDataImportRepository constructor.
     */
    public function __construct()
    {
        $this->csvDataImportModel = new CsvDataImportModel();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function importMaxId($id)
    {
        return $this->csvDataImportModel->max($id);
    }

    /**
     * @param $importId
     * @param $subId
     * @param $colA
     * @param $colB
     * @param $colC
     * @param $colD
     * @param $colE
     * @param $colF
     * @param $colG
     * @param $colH
     * @param $colI
     * @param $colJ
     * @param $colK
     * @param $colL
     * @param $colM
     * @param $colN
     * @param $colO
     * @param $colP
     * @param $colQ
     * @return mixed
     */
    public function insertCsvDataImport($importId, $subId, $colA, $colB, $colC, $colD, $colE,
        $colF, $colG, $colH, $colI, $colJ, $colK, $colL, $colM, $colN, $colO, $colP, $colQ) {
        return $this->csvDataImportModel->insert([
            'id' => $importId, 'sub_id' => $subId, 'A' => $colA, 'B' => $colB,
            'C' => $colC, 'D' => $colD, 'E' => $colE, 'F' => $colF, 'G' => $colG,
            'H' => $colH, 'I' => $colI, 'J' => $colJ, 'K' => $colK, 'L' => $colL,
            'M' => $colM, 'N' => $colN, 'O' => $colO, 'P' => $colP, 'Q' => $colQ,
        ]);
    }

    /**
     * @param $importId
     * @param $A
     * @param $B
     * @param $O
     * @param $P
     * @param $orderBy
     * @return mixed
     */
    public function getDataCsv($importId, $A, $B, $O, $P, $orderBy)
    {
        return $this->csvDataImportModel->where([
            ['id', '=', $importId],
            ['A', '=', $A],
            ['B', '=', $B],
            ['O', '=', $O],
            ['P', '=', $P],
        ])
            ->orderByRaw($orderBy)
            ->get();
    }

    /**
     * @param $importId
     * @return mixed
     */
    public function getDrawing($importId)
    {
        return $this->csvDataImportModel->where('id', '=', $importId)
            ->get();
    }
}

