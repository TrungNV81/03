<?php

namespace App\Http\Controllers;

use App\Http\Services\ManageHistoryService;
use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use Validator;

class ManageHistoryController extends Controller
{
    /**
     * ManageHistoryController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->manageHistoryService = new ManageHistoryService();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIndex()
    {
        return view("welcome");
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function historyFile()
    {
        return $this->manageHistoryService->historyFile();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function historySendMail()
    {
        return $this->manageHistoryService->historySendMail();
    }
}
