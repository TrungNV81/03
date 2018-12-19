<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use Validator;

class UploadFileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function uploadFile()
    {
        return view('upload_form');
    }

    public function uploadSubmit(Request $request)
    {
        $this->validate($request, ['csv-file'=>'required']);
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
