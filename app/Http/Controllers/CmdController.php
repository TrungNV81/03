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

    public function saveTime()
    {
        $time = $_POST['time'];
        $subject = $_POST['subject'];
        $body = $_POST['body'];

        exec($_POST['time'] . " > /dev/null &");

        DB::table('time_run_batch')
            ->update(['time' => $time]);

        DB::table('template_email')
            ->update(['subject' => $subject, 'body' => $body]);

        $smg = "update success";
        echo $smg;
    }
}
