<?php

namespace App\Http\Controllers;

use App\Http\Services\ManageHistoryService;
use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use Validator;

class ManageHistoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->manageHistoryService = new ManageHistoryService();
    }

    public function getIndex()
    {
        return view("welcome");
    }

    public function historyFile()
    {
        return $this->manageHistoryService->historyFile();
    }

    public function historySendMail()
    {
        return $this->manageHistoryService->historySendMail();
    }
}
