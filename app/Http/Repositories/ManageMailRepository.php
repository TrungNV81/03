<?php

namespace App\Http\Repositories;

use App\Http\Models\ManageMailModel;
use Illuminate\Support\Facades\DB;

class ManageMailRepository extends BaseRepository
{
    /**
     * @var ManageMailModel
     */
    protected $manageMailModel;

    /**
     * DetailsDataImportRepository constructor.
     */
    public function __construct()
    {
        $this->manageMailModel = new ManageMailModel();
    }

    /**
     * @return mixed
     */
    public function getArrMail()
    {
        return $this->manageMailModel->select('email')
            ->where([
                ['status', '=', '1'],
            ])
            ->get();
    }
}
