<?php

namespace App\Http\Repositories;

use App\Http\Models\HistoryFileModel;

class HistoryFileRepository extends BaseRepository
{
    /**
     * @var HistoryFileModel
     */
    protected $historyFileModel;

    /**
     * HistoryFileRepository constructor.
     */
    public function __construct()
    {
        $this->historyFileModel = new HistoryFileModel();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function maxIdFile($id)
    {
        return $this->historyFileModel->max($id);
    }

    /**
     * @param $idFile
     * @param $fileName
     * @param $dateNew
     * @param $category
     * @return mixed
     */
    public function insertHistoryFile($idFile, $fileName, $dateNew, $category)
    {
        return $this->historyFileModel->insert([
            'id' => $idFile, 'file_name' => $fileName, 'created_at' => $dateNew, 'status' => $category
        ]);
    }

    /**
     * @return mixed
     */
    public function historyFile()
    {
        return $this->historyFileModel->orderByRaw('created_at DESC')
            ->get();
    }
}
