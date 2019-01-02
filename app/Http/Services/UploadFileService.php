<?php

namespace App\Http\Services;

use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use Validator;

class UploadFileService
{
    public function uploadFile()
    {
        return view('upload_form');
    }

    /**
     * @param $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function uploadSubmit($request)
    {
        sleep(1);
        $file = $request->file('file');
        $extension = strtolower($file->getClientOriginalExtension());
        if($extension == "csv")
        {
            $dir = public_path() . '/files/';
            $file->move($dir, $file->getClientOriginalName());
        } else {
            return response()->json([
                'errors' => 'File wrong format',
            ], 422);
        }
    }

    public function deleteFile($request)
    {
        $filename = $request->get('filename');
        $dir = public_path() . '/files/'.$filename;
        if (file_exists($dir)) {
            unlink($dir);
        }
        return $filename;
    }
}
