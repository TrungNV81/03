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
        return view('upload_form');
    }

    public function uploadSubmit(Request $request)
    {
        return $this->uploadFileService->uploadSubmit($request);
    }
}
