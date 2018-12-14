<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
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

    public function test()
    {
        $historyFile = DB::table('history_file')
            ->orderByRaw('created_at DESC')
            ->get();

        $historySendMail = DB::table('history_sendmail')
            ->orderByRaw('created_at DESC')
            ->get();

        $dataMail = DB::table('manage_mail')
            ->get();

        $totalFile = count($historyFile);

        $totalSendMail = count($historySendMail);

        $totalMail = count($dataMail);

        return view("test", ['historyFile' => $historyFile, 'historySendMail' => $historySendMail, 'totalFile' => $totalFile, 'totalSendMail' => $totalSendMail,'totalMail' => $totalMail]);
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

    public function manageMail()
    {
        $dataMail = DB::table('manage_mail')
            ->get();
        return view("manageMail", ['dataMail' => $dataMail]);
    }

    public function editMail()
    {
        $stringMail = $_POST['arrMail'];
        $stringStatus = $_POST['arrStatus'];
        $arrMail = explode(',',$stringMail);
        $arrStatus = explode(',',$stringStatus);
        $arrId = DB::table('manage_mail')
        ->select('id')
        ->get();

        foreach($arrId as $key => $value)
        {
            DB::table('manage_mail')
            ->where('id', $arrId[$key]->id)
            ->update([
                'email' => $arrMail[$key],  'status' => $arrStatus[$key],
            ]);
        }
        echo 'Update Success';
    }
}
