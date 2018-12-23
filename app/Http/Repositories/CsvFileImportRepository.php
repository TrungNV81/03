<?php

namespace App\Http\Repositories;

use App\Http\Models\CsvFileImportModel;

class CsvFileImportRepository extends BaseRepository
{
    /**
     * @var CsvFileImportModel
     */
    protected $csvFileImportModel;

    /**
     * CsvFileImportRepository constructor.
     */
    public function __construct()
    {
        $this->csvFileImportModel = new CsvFileImportModel();
    }

    /**
     * @param $importId
     * @param $fileName
     * @return mixed
     */
    public function insertFile($importId, $fileName)
    {
        return $this->csvFileImportModel->insert([
            'id' => $importId, 'file_name' => $fileName
        ]);
    }
}
