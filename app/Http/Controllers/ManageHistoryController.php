<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use Validator;

class ManageHistoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getIndex()
    {
        return view("welcome");
    }

    public function historyFile()
    {
        $historyFile = DB::table('history_file')
            ->orderByRaw('created_at DESC')
            ->get();

        return view("historyFile", ['historyFile' => $historyFile]);
    }

    public function historySendMail()
    {
        $historySendMail = DB::table('history_sendmail')
            ->orderByRaw('created_at DESC')
            ->get();

        return view("historySendMail", ['historySendMail' => $historySendMail]);
    }
}
