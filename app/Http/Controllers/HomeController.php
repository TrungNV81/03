<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function readAndSaveCSV() {
        $dir = public_path().'/files/';
        if ($handle = opendir($dir)) {
            while (false !== ($entry = readdir($handle))) {
                if ($entry != "." && $entry != "..") {
                    if (file_exists($dir.$entry)) {
                        $dateOld = date ("Y/m/d H:i:s.", filemtime($dir.$entry));
                        echo $dateOld."<br>";
                        $dateNew =date('Y/m/d H:i:s');
                        echo $dateNew."<br>";
                        $start_date = date('Y-m-d H:i:s', strtotime($dateOld));
                        echo "aaa :". $start_date."<br>";
                    }
                }
            }
            closedir($handle);
        }
        
    }
}
