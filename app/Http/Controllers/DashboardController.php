<?php

namespace App\Http\Controllers;

use App\Http\Services\DashboardService;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->dashboardService = new DashboardService();
    }

    public function dashboard()
    {
        return $this->dashboardService->dashboard();
    }
}
