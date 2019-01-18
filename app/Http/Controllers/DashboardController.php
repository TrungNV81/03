<?php

namespace App\Http\Controllers;

use App\Http\Services\DashboardService;

class DashboardController extends Controller
{
    /**
     * DashboardController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->dashboardService = new DashboardService();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function dashboard()
    {
        return $this->dashboardService->dashboard();
    }
}
