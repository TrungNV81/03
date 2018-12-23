<?php

namespace App\Http\Repositories;

use App\Http\Models\HistorySendMailModel;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HistorySendMailRepository extends BaseRepository
{
    /**
     * @var HistorySendMailModel
     */
    protected $historySendMailModel;

    /**
     * DetailsDataImportRepository constructor.
     */
    public function __construct()
    {
        $this->historySendMailModel = new HistorySendMailModel();
    }

    /**
     * @return mixed
     */
    public function getMaxIdMail($id)
    {
        return $this->historySendMailModel->max($id);
    }


    public function insertHistorySendMail($id, $filezip, $receiver, $created_at, $status)
    {
        return $this->historySendMailModel->insert([
            'id' => $id, 'file_zip' => $filezip, 'receiver' => $receiver,
            'created_at' => $created_at, 'status' => $status
        ]);
    }

    public function getSendMailToday()
    {
        return $this->historySendMailModel->whereDate('created_at', Carbon::today())
            ->get();
    }

    public function getHistorySendMail()
    {
        return $this->historySendMailModel->get();
    }

    public function totalSuccessSendMail()
    {
        return $this->historySendMailModel->where('status', '=' ,'success')
            ->get();
    }
    
}
