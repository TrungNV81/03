<?php

namespace App\Http\Services;

use App\Http\Repositories\ManageMailRepository;
use App\Http\Repositories\TemplateEmailRepository;
use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use Validator;

class ManageMailService
{
    private $manageMailRepository;

    /**
     * ManageMailService constructor.
     */
    public function __construct()
    {
        $this->manageMailRepository = new ManageMailRepository();
        $this->templateEmailRepository = new TemplateEmailRepository();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function manageMail()
    {
        $dataGroupMail = $this->manageMailRepository->dataGroupMail();

        if(isset($_GET['id_group'])) {
            $id_group = $_GET['id_group'];
            $dataMail = $this->manageMailRepository->dataMail($id_group);

        } else {
            $dataMail = [];
            $id_group = '';
        }
        return view("manageMail", ['dataMail' => $dataMail, 'dataGroupMail' => $dataGroupMail, 'id_group' => $id_group]);
    }


    public function getMailGroup($request)
    {

        if(isset($_POST['id_group'])) {
            $id_group = $_POST['id_group'];
            $nameGroup = $this->manageMailRepository->nameGroup($id_group);
            $dataMail = $this->manageMailRepository->dataMail($id_group);

        } else {
            $dataMail = [];
            $id_group = '';
        }
        return [$dataMail, $id_group, $nameGroup];
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addMail(Request $request)
    {
        $id_group = $_POST['id_group'];
        $new_email = $_POST['new_email'];
        $checkExists = $this->manageMailRepository->checkExists($id_group, $new_email);
        if ($checkExists == 1) {
            return -1;
        } else {
            $maxIdMail = $this->manageMailRepository->maxIdMail('id');
            if ($maxIdMail == "") {
                $maxIdMail = 0;
            }
            $maxIdMail += 1;
            $maxIdMail = $maxIdMail;
            $this->manageMailRepository->addMail($maxIdMail, $id_group, $new_email, '0');
            return $id_group;
        }
    }

    /**
     * @return string
     */
    public function editMail()
    {
        $stringMail = $_POST['arrMail'];
        $stringStatus = $_POST['arrStatus'];
        $id_group = $_POST['id_group'];
        $arrMail = explode(',',$stringMail);
        $arrStatus = explode(',',$stringStatus);
        if(isset($id_group)) {
            $arrId = $this->manageMailRepository->arrIdMail($id_group);
            foreach($arrId as $key => $value)
            {
                $this->manageMailRepository->updateMail($arrId[$key]->id, $arrMail[$key], $arrStatus[$key]);
            }
            return 'Update success';
        } else {
            return 'Update fail';
        }
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delMail()
    {
        $this->manageMailRepository->delMail($_POST['idMail']);
        return $_POST['idGroup'];
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addGroup(Request $request)
    {
        $rules = [
            'group-email' => 'required'
        ];
        $messages = [
            'group-email.required' => 'Group mail is required.',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $maxIdGroup = $this->manageMailRepository->maxIdGroupMail('id');
            if ($maxIdGroup == "") {
                $maxIdGroup = 0;
            }
            $maxIdGroup += 1;
            $idGroup = $maxIdGroup;
            $this->manageMailRepository->addGroupMail($idGroup, $_POST['group-email'], '0');
            echo '<script type="text/javascript">';
            echo 'alert("Add group success!")';
            echo '</script>';
            return redirect()->intended('manageMail');
        }
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function editGroup()
    {
        $this->manageMailRepository->editGroup($_POST['id_group'], $_POST['name_group']);
        echo '<script type="text/javascript">';
        echo 'alert("Update group success!")';
        echo '</script>';
        return redirect()->intended('manageMail');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delGroup()
    {
        $this->manageMailRepository->delGroupMail($_POST['id-group']);
        $this->manageMailRepository->delMailInGroup($_POST['id-group']);
        echo '<script type="text/javascript">';
        echo 'alert("Delete group success!")';
        echo '</script>';
        return redirect()->intended('manageMail');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function templateMail()
    {
        $timeRunBatch = DB::table('time_run_batch')
            ->get();
        $templateEmail = $this->templateEmailRepository->getTemplateEmail();

        return view("setting", ['timeRunBatch' => $timeRunBatch[0], 'templateEmail' => $templateEmail[0]]);
    }

    /**
     * @return string
     */
    public function updateTemplate()
    {
        $time = $_POST['time'];
        $subject = $_POST['subject'];
        $receiver = $_POST['receiver'];
        $body = $_POST['body'];
        $sender = $_POST['sender'];
        // Update time run batch
        DB::table('time_run_batch')
            ->update(['time' => $time]);

        $this->templateEmailRepository->updateTempalteMail($subject, $receiver, $body, $sender);
        $smg = "Update success";
        return $smg;
    }
}
