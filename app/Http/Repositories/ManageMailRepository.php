<?php

namespace App\Http\Repositories;

use App\Http\Models\ManageMailModel;
use App\Http\Models\GroupMailModel;
use App\Http\Models\TemplateEmailModel;
use Illuminate\Support\Facades\DB;

class ManageMailRepository extends BaseRepository
{
    /**
     * @var ManageMailModel
     */
    protected $manageMailModel;

    /**
     * @var GroupMailModel
     */
    protected $groupMailModel;

    /**
     * @var TemplateEmailModel
     */
    protected $templateEmailModel;

    /**
     * DetailsDataImportRepository constructor.
     */
    public function __construct()
    {
        $this->manageMailModel = new ManageMailModel();
        $this->groupMailModel = new GroupMailModel();
        $this->templateEmailModel = new TemplateEmailModel();
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

    /**
     * @return mixed
     */
    public function dataGroupMail()
    {
        return $this->groupMailModel->get();
    }

    /**
     * @param $id_group
     * @return mixed
     */
    public function dataMail($id_group)
    {
        return $this->manageMailModel->join('group_mail', 'manage_mail.id_group', '=', 'group_mail.id')
            ->select('group_mail.name as group_name', 'manage_mail.id', 'manage_mail.email', 'manage_mail.status')
            ->where('id_group', '=', $id_group)
            ->get();
    }

    /**
     * @param $id_group
     * @param $new_email
     * @return mixed
     */
    public function checkExists($id_group, $new_email)
    {
        return $this->manageMailModel->where([
            ['id_group', '=', $id_group],
            ['email', '=', $new_email]])
            ->exists();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function maxIdMail($id)
    {
        return $this->manageMailModel->max('id');
    }

    /**
     * @param $maxIdMail
     * @param $id_group
     * @param $new_email
     * @param $status
     * @return mixed
     */
    public function addMail($maxIdMail, $id_group, $new_email, $status)
    {
        return $this->manageMailModel->insert([
            ['id' => $maxIdMail, 'id_group' => $id_group, 'email' => $new_email, 'status' => $status]
        ]);
    }

    /**
     * @param $id_group
     * @return mixed
     */
    public function arrIdMail($id_group)
    {
        return $this->manageMailModel->select('id')
            ->where('id_group', '=', $id_group)
            ->get();
    }

    /**
     * @param $id
     * @param $email
     * @param $status
     * @return mixed
     */
    public function updateMail($id, $email, $status)
    {
        return $this->manageMailModel->where('id', '=', $id)
            ->update([
                'email' => $email, 'status' => $status,
            ]);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delMail($id)
    {
        return $this->manageMailModel->where('id', '=', $id)->delete();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function maxIdGroupMail($id)
    {
        return $this->groupMailModel->max('id');
    }

    /**
     * @param $idGroup
     * @param $name
     * @param $status
     * @return mixed
     */
    public function addGroupMail($idGroup, $name, $status)
    {
        return $this->groupMailModel->insert(
            ['id' => $idGroup, 'name' => $name, 'status' => $status]
        );
    }

    /**
     * @param $idGroup
     * @param $name
     * @return mixed
     */
    public function editGroup($idGroup, $name)
    {
        return $this->groupMailModel->where('id', '=', $idGroup)
            ->update(['name' => $name]);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delGroupMail($id)
    {
        return $this->groupMailModel->where('id', '=', $id)->delete();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delMailInGroup($id)
    {
        return $this->manageMailModel->where('id_group', '=', $id)->delete();
    }    
}
