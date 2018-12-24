<?php

namespace App\Http\Services;

use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use Validator;

class UploadFileService
{
    /**
     * @param $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function uploadSubmit($request)
    {
        $files = $request->file('csv-file');
        if($request->hasFile('csv-file'))
        {
            foreach($files as $file) {
                $extension = strtolower($file->getClientOriginalExtension());
                if($extension != "csv")
                {
                    echo '<script language="javascript">';
                    echo 'alert("The system only accepts CSV files")';
                    echo '</script>';
                    return redirect()->intended('uploadFile');
                }
                $dir = public_path() . '/files/';
                $file->move($dir, $file->getClientOriginalName());
            }
            echo '<script language="javascript">';
            echo 'alert("Upload file success!")';
            echo '</script>';
            return redirect()->intended('uploadFile');
        }
    }
}
