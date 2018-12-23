<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use Validator;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard()
    {
        $tableHistoryFile = 'history_file';
        $tableHistorySendMail = 'history_sendmail';
        
        $result = DB::table('line_chart_file')
            ->get();

        $chart_data_file = '';
        foreach($result as $key => $value)
        {
            $chart_data_file .= "{ day:'".$result[$key]->day."', total:".$result[$key]->total.", success:".$result[$key]->success.", fail:".$result[$key]->fail."}, ";
        }
        $chart_data_file = substr($chart_data_file, 0, -2);

        $timeLastImportFile = DB::table($tableHistoryFile)
            ->select('created_at')
            ->where('id', DB::raw("(select max(`id`) from history_file)"))
            ->get();

        $fileImportToday = count(DB::table($tableHistoryFile)
            ->whereDate('created_at', Carbon::today())
            ->get());

        $sendMailToday = count(DB::table($tableHistorySendMail)
            ->whereDate('created_at', Carbon::today())
            ->get());

        $historyFile = DB::table($tableHistoryFile)
            ->orderByRaw('created_at DESC')
            ->get();

        $historySendMail = DB::table($tableHistorySendMail)
            ->orderByRaw('created_at DESC')
            ->get();

        $totalSuccessFile = count(DB::table($tableHistoryFile)
            ->where('status', '=' ,'success')
            ->orderByRaw('created_at DESC')
            ->get());

        $totalSuccessSendMail = count(DB::table($tableHistorySendMail)
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
            'totalSuccessFile' => $totalSuccessFile, 'totalSuccessSendMail' => $totalSuccessSendMail, 'fileImportToday' => $fileImportToday,
            'sendMailToday' => $sendMailToday, 'timeLastImportFile' => $timeLastImportFile[0]->created_at, 'chart_data_file' => $chart_data_file
        ]);
    }
}
