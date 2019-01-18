<?php

namespace App\Http\Controllers;

use App\Http\Services\ManageMailService;
use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use Validator;

class ManageMailController extends Controller
{
    /**
     * ManageMailController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->manageMailService = new ManageMailService();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function manageMail()
    {
        return $this->manageMailService->manageMail();
    }

    /**
     * @param Request $request
     * @return array
     */
    public function getMailGroup(Request $request)
    {
        return $this->manageMailService->getMailGroup($request);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addMail(Request $request)
    {
        return $this->manageMailService->addMail($request);
    }

    /**
     * @return string
     */
    public function editMail()
    {
        return $this->manageMailService->editMail();
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delMail()
    {
        return $this->manageMailService->delMail();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addGroup(Request $request)
    {
        return $this->manageMailService->addGroup($request);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function editGroup()
    {
        return $this->manageMailService->editGroup();
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delGroup()
    {
        return $this->manageMailService->delGroup();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function templateMail()
    {
        return $this->manageMailService->templateMail();
    }

    /**
     * @return string
     */
    public function updateTemplate()
    {
        return $this->manageMailService->updateTemplate();
    }
}
