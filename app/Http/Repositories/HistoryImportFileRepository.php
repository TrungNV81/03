<?php

namespace App\Http\Repositories;

use App\Http\Models\HistoryImportFileModel;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HistoryImportFileRepository extends BaseRepository
{
    /**
     * @var HistoryImportFileModel
     */
    protected $historyImportFileModel;

    /**
     * DetailsDataImportRepository constructor.
     */
    public function __construct()
    {
        $this->historyImportFileModel = new HistoryImportFileModel();
    }

    public function getTimeLastImportFile()
    {
        return $this->historyImportFileModel->select('created_at')
            ->where('id', DB::raw("(select max(`id`) from history_file)"))
            ->get();
    }
    
    public function getFileImportToday()
    {
        return $this->historyImportFileModel->whereDate('created_at', Carbon::today())
            ->get();
    }

    public function getHistoryFile()
    {
        return $this->historyImportFileModel->get();
    }
    
    public function totalSuccessFile()
    {
        return $this->historyImportFileModel->where('status', '=' ,'success')
            ->get();
    }
        
}
