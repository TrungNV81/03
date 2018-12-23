<?php

namespace App\Http\Repositories;

use App\Http\Models\TemplateEmailModel;
use Illuminate\Support\Facades\DB;

class TemplateEmailRepository extends BaseRepository
{
    /**
     * @var TemplateEmailModel
     */
    protected $templateEmailModel;

    /**
     * DetailsDataImportRepository constructor.
     */
    public function __construct()
    {
        $this->templateEmailModel = new TemplateEmailModel();
    }

    /**
     * @return mixed
     */
    public function getTemplateEmail()
    {
        return $this->templateEmailModel->get();
    }
}
