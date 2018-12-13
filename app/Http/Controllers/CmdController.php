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

        return view("setting", ['timeRunBatch' => $timeRunBatch[0]]);
    }

    public function saveTime()
    {
        exec($_POST['time'] . " > /dev/null &");

        DB::table('time_run_batch')
            ->update(['time' => $_POST['time']]);

        $timeRunBatch = DB::table('time_run_batch')
            ->get();

        return view("setting", ['timeRunBatch' => $timeRunBatch[0]]);
    }
}
