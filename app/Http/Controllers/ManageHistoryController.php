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

    public function dashboard()
    {
        $historyFile = DB::table('history_file')
            ->orderByRaw('created_at DESC')
            ->get();

        $historySendMail = DB::table('history_sendmail')
            ->orderByRaw('created_at DESC')
            ->get();

        $totalSuccessFile = count(DB::table('history_file')
            ->where('status', '=' ,'success')
            ->orderByRaw('created_at DESC')
            ->get());

        $totalSuccessSendMail = count(DB::table('history_sendmail')
            ->where('status', '=' ,'success')
            ->orderByRaw('created_at DESC')
            ->get());

        $dataMail = DB::table('manage_mail')
            ->get();

        $totalFile = count($historyFile);

        $totalSendMail = count($historySendMail);

        $totalMail = count($dataMail);

        return view("dashboard", ['historyFile' => $historyFile, 'historySendMail' => $historySendMail,
            'totalFile' => $totalFile, 'totalSendMail' => $totalSendMail, 'totalMail' => $totalMail,
            'totalSuccessFile' => $totalSuccessFile, 'totalSuccessSendMail' => $totalSuccessSendMail]);
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
