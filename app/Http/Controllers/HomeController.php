<?php

namespace App\Http\Controllers;

use App\Http\Services\HomeService;

set_time_limit(600);
class HomeController extends Controller
{
    /**
     * @var HomeService
     */
    private $homeService;

    // public function batch()
    // {
    //     $time = date('Y-m-d H:i:s');
    //     $timeNow = strtotime($time);
    //     $checkBatch = DB::table('time_run_batch')
    //         ->get();
    //     $timeOld = strtotime($checkBatch[0]->date);
    //     $minute = ($timeNow - $timeOld)/60;
    //     $minuteRunBatch = $checkBatch[0]->time;
    //     $chia = $minute/$minuteRunBatch;
    //     $return = $minute % $minuteRunBatch == 0;
    //     if ($minute % $minuteRunBatch == 0) {
    //         $this->handle();
    //         shell_exec('echo "'. '[OK]  Time: ' . $time . '     |now: ' . $minute . '     |old: ' . $minuteRunBatch . '     |chia: ' . $chia . '     |return: ' . $return .'" >> /var/www/html/webtool03/app/test.log');
    //     } else {
    //         shell_exec('echo "'. '[NEXT]  Time: ' . $time . '     |now: ' . $minute . '     |old: ' . $minuteRunBatch . '     |chia: ' . $chia . '     |return: ' . $return .'" >> /var/www/html/webtool03/app/test.log');
    //     }
    // }

    /**
     * HomeController constructor.
     */
    public function __construct()
    {
        $this->homeService = new HomeService();
    }

    /**
     *
     */
    public function handle()
    {
        return $this->homeService->handle();
    }
}
