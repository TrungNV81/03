<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class CmdController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getIndex()
    {
        $timeRunBatch = DB::table('time_run_batch')
            ->get();

        $templateEmail = DB::table('template_email')
            ->get();

        return view("setting", ['timeRunBatch' => $timeRunBatch[0], 'templateEmail' => $templateEmail[0]]);
    }

    public function UpdateSetting()
    {
        $time = $_POST['time'];
        $subject = $_POST['subject'];
        $receiver = $_POST['receiver'];
        $body = $_POST['body'];
        $sender = $_POST['sender'];

        $timeRun = DB::table('time_run_batch')
            ->get();

        $fileCrontab = file_get_contents(public_path().'/crontab');
        $newFileCrontab = str_replace('*/'.$timeRun[0]->time, '*/'.$time, $fileCrontab);
        file_put_contents(public_path().'/crontab', $newFileCrontab);

        DB::table('time_run_batch')
            ->update(['time' => $time]);

        DB::table('template_email')
            ->update(['subject' => $subject, 'receiver' => $receiver, 'body' => $body, 'sender' => $sender]);

        $smg = "Update success";
        echo $smg;
    }
}
