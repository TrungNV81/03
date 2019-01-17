<?php

namespace App\Http\Controllers;

use App\Http\Services\UploadFileService;
use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use Validator;

class UploadFileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->uploadFileService = new UploadFileService();
    }

    public function uploadFile()
    {
        return $this->uploadFileService->uploadFile();
    }

    public function uploadSubmit(Request $request)
    {
        return $this->uploadFileService->uploadSubmit($request);
    }

    public function deleteFile(Request $request)
    {
        return $this->uploadFileService->deleteFile($request);
    }

    public function uploadFileConfig()
    {
        return $this->uploadFileService->uploadFileConfig();
    }

    public function uploadFileConfigSubmit(Request $request)
    {
        return $this->uploadFileService->uploadFileConfigSubmit($request);
    }
}
