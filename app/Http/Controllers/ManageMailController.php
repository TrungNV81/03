<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use Validator;

class ManageMailController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
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

    public function delMail()
    {
        DB::table('manage_mail')->where('id', '=', $_POST['id-mail'])->delete();
        echo '<script language="javascript">';
        echo 'alert("Delete mail success!")';
        echo '</script>';
        return redirect()->intended('manageMail?id_group='.$_POST['id_group']);
    }

    public function templateMail()
    {
        $timeRunBatch = DB::table('time_run_batch')
            ->get();

        $templateEmail = DB::table('template_email')
            ->get();

        return view("setting", ['timeRunBatch' => $timeRunBatch[0], 'templateEmail' => $templateEmail[0]]);
    }

    public function updateTemplate()
    {
        //$time = $_POST['time'];
        $subject = $_POST['subject'];
        $receiver = $_POST['receiver'];
        $body = $_POST['body'];
        $sender = $_POST['sender'];

        $timeRun = DB::table('time_run_batch')
            ->get();

        // $fileCrontab = file_get_contents(public_path().'/crontab');
        // $newFileCrontab = str_replace('*/'.$timeRun[0]->time, '*/'.$time, $fileCrontab);
        // file_put_contents(public_path().'/crontab', $newFileCrontab);

        // DB::table('time_run_batch')
        //    ->update(['time' => $time]);

        DB::table('template_email')
            ->update(['subject' => $subject, 'receiver' => $receiver, 'body' => $body, 'sender' => $sender]);

        $smg = "Update success";
        echo $smg;
    }
}
