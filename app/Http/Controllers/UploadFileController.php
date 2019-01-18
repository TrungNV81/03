<?php

namespace App\Http\Controllers;

use App\Http\Services\UploadFileService;
use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use Validator;

class UploadFileController extends Controller
{
    /**
     * UploadFileController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->uploadFileService = new UploadFileService();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function uploadFile()
    {
        return $this->uploadFileService->uploadFile();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function uploadSubmit(Request $request)
    {
        return $this->uploadFileService->uploadSubmit($request);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function deleteFile(Request $request)
    {
        return $this->uploadFileService->deleteFile($request);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function uploadFileConfig()
    {
        return $this->uploadFileService->uploadFileConfig();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function uploadFileConfigSubmit(Request $request)
    {
        return $this->uploadFileService->uploadFileConfigSubmit($request);
    }
}
