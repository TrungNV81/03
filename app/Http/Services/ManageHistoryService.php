<?php

namespace App\Http\Services;

use App\Http\Repositories\HistoryFileRepository;
use App\Http\Repositories\HistorySendMailRepository;
use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use Validator;

class ManageHistoryService
{
    private $historyFileRepository;
    private $historySendMailRepository;

    /**
     * ManageHistoryService constructor.
     */
    public function __construct()
    {
        $this->historyFileRepository = new HistoryFileRepository();
        $this->historySendMailRepository = new HistorySendMailRepository();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function historyFile()
    {
        $historyFile = $this->historyFileRepository->historyFile();
        return view("historyFile", ['historyFile' => $historyFile]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function historySendMail()
    {
        $historySendMail = $this->historySendMailRepository->historySendMail();
        return view("historySendMail", ['historySendMail' => $historySendMail]);
    }
}
