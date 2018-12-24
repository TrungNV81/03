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

    /**
     * @param $subject
     * @param $receiver
     * @param $body
     * @param $sender
     * @return mixed
     */
    public function updateTempalteMail($subject, $receiver, $body, $sender)
    {
        return $this->templateEmailModel->where('id', '=','1')
            ->update(['subject' => $subject, 'receiver' => $receiver, 'body' => $body, 'sender' => $sender]);
    }
}
