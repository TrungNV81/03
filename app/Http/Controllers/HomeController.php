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

    /**
     * HomeController constructor.
     */
    public function __construct()
    {
        $this->homeService = new HomeService();
    }

    /**
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function handle()
    {
        return $this->homeService->handle();
    }
}
