<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use Validator;

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
        echo 'Update success';
    }

    public function addMail(Request $request)
    {
        $rules = [
            'new-email' => 'required'
        ];
        $messages = [
            'new-email.required' => 'Email is required.',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $maxIdMail = DB::table('manage_mail')->max('id');
            if ($maxIdMail == "") {
                $maxIdMail = 0;
            }
            $maxIdMail += 1;
            $maxIdMail = $maxIdMail;

            DB::table('manage_mail')->insert(
                ['id' => $maxIdMail, 'email' => $_POST['new-email'], 'status' => '0']
            );
            echo '<script language="javascript">';
            echo 'alert("Add mail success!")';
            echo '</script>';    
            return redirect()->intended('manageMail');
        }
    }

    public function delMail()
    {
        DB::table('manage_mail')->where('id', '=', $_POST['id-mail'])->delete();
        echo '<script language="javascript">';
        echo 'alert("Delete mail success!")';
        echo '</script>';    
        return redirect()->intended('manageMail');
    }
}
