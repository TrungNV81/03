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
        $dataGroupMail = DB::table('group_mail')
            ->get();

        if(isset($_GET['id_group'])) {
            $id_group = $_GET['id_group'];
            $dataMail = DB::table('manage_mail')
                ->where('id_group', '=', $id_group)
                ->get();
        } else {
            $dataMail = [];
            $id_group = '';
        }
        return view("manageMail", ['dataMail' => $dataMail, 'dataGroupMail' => $dataGroupMail, 'id_group' => $id_group]);
    }

    public function editMail()
    {
        $stringMail = $_POST['arrMail'];
        $stringStatus = $_POST['arrStatus'];
        $id_group = $_POST['id_group'];
        $arrMail = explode(',',$stringMail);
        $arrStatus = explode(',',$stringStatus);
        if(isset($id_group)) {
            $arrId = DB::table('manage_mail')
                ->select('id')
                ->where('id_group', '=', $id_group)
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
        } else {
            echo 'Update fail';
        }
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
                ['id' => $maxIdMail, 'id_group' => $_POST['id_group'], 'email' => $_POST['new-email'], 'status' => '0']
            );
            echo '<script language="javascript">';
            echo 'alert("Add mail success!")';
            echo '</script>';
            return redirect()->intended('manageMail?id_group='.$_POST['id_group']);
        }
    }

    public function delMail()
    {
        DB::table('manage_mail')->where('id', '=', $_POST['id-mail'])->delete();
        echo '<script language="javascript">';
        echo 'alert("Delete mail success!")';
        echo '</script>';
        return redirect()->intended('manageMail?id_group='.$_POST['id_group']);
    }

    public function uploadFile()
    {
        return view('upload_form');
    }

    public function uploadSubmit(Request $request)
    {
        $this->validate($request, ['csv-file'=>'required']);
        $files = $request->file('csv-file');
        if($request->hasFile('csv-file'))
        {
            foreach($files as $file) {
                $extension = strtolower($file->getClientOriginalExtension());
                if($extension != "csv")
                {
                    echo '<script language="javascript">';
                    echo 'alert("The system only accepts CSV files")';
                    echo '</script>';
                    return redirect()->intended('uploadFile');
                }
                $dir = public_path() . '/files/';
                $file->move($dir, $file->getClientOriginalName());
            }
            echo '<script language="javascript">';
            echo 'alert("Upload file success!")';
            echo '</script>';
            return redirect()->intended('uploadFile');
        }
    }
}
