<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getIndex()
    {
        return view("welcome");
    }

    public function manageHistory()
    {
        $historyFile = DB::table('history_file')
            ->get();

        $historySendMail = DB::table('history_sendmail')
            ->get();

        return view("history", ['historyFile' => $historyFile, 'historySendMail' => $historySendMail]);
    }

    public function manageMail()
    {
        $dataMail = DB::table('manage_mail')
            ->get();
        return view("manageMail", ['dataMail' => $dataMail]);
    }

}
