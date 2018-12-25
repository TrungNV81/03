<?php

namespace App\Http\Controllers;

use App\Http\Services\ManageMailService;
use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use Validator;

class ManageMailController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->manageMailService = new ManageMailService();
    }

    public function manageMail()
    {
        return $this->manageMailService->manageMail();
    }

    public function addMail(Request $request)
    {
        return $this->manageMailService->addMail($request);
    }

    public function editMail()
    {
        return $this->manageMailService->editMail();
    }

    public function delMail()
    {
        return $this->manageMailService->delMail();
    }

    public function addGroup(Request $request)
    {
        return $this->manageMailService->addGroup($request);
    }

    public function editGroup()
    {
        return $this->manageMailService->editGroup();
    }

    public function delGroup()
    {
        return $this->manageMailService->delGroup();
    }

    public function templateMail()
    {
        return $this->manageMailService->templateMail();
    }

    public function updateTemplate()
    {
        return $this->manageMailService->updateTemplate();
    }
}
