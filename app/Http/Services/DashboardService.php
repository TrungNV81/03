<?php

namespace App\Http\Services;

use App\Http\Repositories\LineChartFileRepository;
use App\Http\Repositories\HistorySendMailRepository;
use App\Http\Repositories\HistoryImportFileRepository;
use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use Validator;
use Carbon\Carbon;

class DashboardService
{
    private $lineChartFileRepository;
    private $historySendMailRepository;
    private $historyImportFileRepository;

    /**
     * DashboardService constructor.
     */
    public function __construct()
    {
        $this->lineChartFileRepository = new LineChartFileRepository();
        $this->historySendMailRepository = new HistorySendMailRepository();
        $this->historyImportFileRepository = new HistoryImportFileRepository();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function dashboard()
    {
        // get day of week
        $dateNew = date('Y-m-d H:i:s');
        $dateNew = date('2019-01-21');
        $dayOfWeek = date("l", strtotime($dateNew));
        $weekOfYear = date("W", strtotime($dateNew));
        // select total file import in day
        $line_chart_file = $this->lineChartFileRepository->getDay($dayOfWeek);
        if ($weekOfYear > $line_chart_file[0]->week_of_year) {
            $day = array(
                "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday",
            );
            foreach ($day as $key => $value) {
                // reset line_chart_file
                $this->lineChartFileRepository->resetLineChartFile($value, $weekOfYear);
            }
        }
        $result = $this->lineChartFileRepository->getDataLineChartfile();
        $chart_data_file = '';
        foreach($result as $key => $value)
        {
            $chart_data_file .= "{ day:'".$result[$key]->day."', total:".$result[$key]->total.
                ", success:".$result[$key]->success.", fail:".$result[$key]->fail."}, ";
        }
        $chart_data_file = substr($chart_data_file, 0, -2);

        $timeLastImportFile = $this->historyImportFileRepository->getTimeLastImportFile();

        if (empty($timeLastImportFile[0]->created_at)) {
            $timeLastImportFile = '';
        } else {
            $timeLastImportFile = $timeLastImportFile[0]->created_at;
        }

        $fileImportToday = count($this->historyImportFileRepository->getFileImportToday());

        $sendMailToday = count($this->historySendMailRepository->getSendMailToday());

        $historyFile = $this->historyImportFileRepository->getHistoryFile();
        $totalFile = count($historyFile);

        $historySendMail = $this->historySendMailRepository->getHistorySendMail();
        $totalSendMail = count($historySendMail);

        $totalSuccessFile = count($this->historyImportFileRepository->totalSuccessFile());

        $totalSuccessSendMail = count($this->historySendMailRepository->totalSuccessSendMail());

        return view("dashboard", ['historyFile' => $historyFile, 'historySendMail' => $historySendMail,
            'totalFile' => $totalFile, 'totalSendMail' => $totalSendMail, 'totalSuccessFile' => $totalSuccessFile,
            'totalSuccessSendMail' => $totalSuccessSendMail, 'fileImportToday' => $fileImportToday, 'sendMailToday' => $sendMailToday,
            'timeLastImportFile' => $timeLastImportFile, 'chart_data_file' => $chart_data_file
        ]);
    }
}
