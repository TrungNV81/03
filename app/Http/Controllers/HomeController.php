<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function readAndSaveCSV() {
        $dir = public_path().'/files/';
        if ($handle = opendir($dir)) {
            while (false !== ($entry = readdir($handle))) {
                if ($entry != "." && $entry != "..") {
                    if (file_exists($dir.$entry)) {
                        $dateOld = strtotime(date ("Y-m-d H:i:s", filemtime($dir.$entry)));
                        $dateNew = strtotime(date('Y-m-d H:i:s'));
                        $start_date = $dateNew - $dateOld;
                        // if($start_date < 60)
                        if (true) {
                            $importMaxId = DB::table('csv_data_import')->max('id');
                            if ($importMaxId == "") {
                                $importMaxId = 0;
                            }
                            $importMaxId += 1;

                            $importId = $importMaxId;
                            $subId = 1;
                            $files = glob($dir.$entry);
                            foreach($files as $file) {
                                if (($handle1 = fopen($file, "r")) !== FALSE) {
                                    echo "<h2>Filename: " . basename($file) . "</h2></hr>";
                                    while (($data = fgetcsv($handle1, 1000, ",")) !== FALSE) {
                                        $colA = mb_convert_encoding($data[0], 'UTF-8', 'Shift-JIS');
                                        $colB = mb_convert_encoding($data[1], 'UTF-8', 'Shift-JIS');
                                        $colC = mb_convert_encoding($data[2], 'UTF-8', 'Shift-JIS');
                                        $colD = mb_convert_encoding($data[3], 'UTF-8', 'Shift-JIS');
                                        $colE = mb_convert_encoding($data[4], 'UTF-8', 'Shift-JIS');
                                        $colF = mb_convert_encoding($data[5], 'UTF-8', 'Shift-JIS');
                                        $colG = mb_convert_encoding($data[6], 'UTF-8', 'Shift-JIS');
                                        $colH = mb_convert_encoding($data[7], 'UTF-8', 'Shift-JIS');
                                        $colI = mb_convert_encoding($data[8], 'UTF-8', 'Shift-JIS');
                                        $colJ = mb_convert_encoding($data[9], 'UTF-8', 'Shift-JIS');
                                        $colK = mb_convert_encoding($data[10], 'UTF-8', 'Shift-JIS');
                                        $colL = mb_convert_encoding($data[11], 'UTF-8', 'Shift-JIS');
                                        $colM = mb_convert_encoding($data[12], 'UTF-8', 'Shift-JIS');
                                        $colN = mb_convert_encoding($data[13], 'UTF-8', 'Shift-JIS');
                                        $colO = mb_convert_encoding($data[14], 'UTF-8', 'Shift-JIS');
                                        $colP = mb_convert_encoding($data[15], 'UTF-8', 'Shift-JIS');
                                        $colQ = mb_convert_encoding($data[16], 'UTF-8', 'Shift-JIS');
                                        DB::table('csv_data_import')->insert(
                                            ['id' => $importId, 'sub_id' => $subId, 'A' => $colA, 'B' => $colB,
                                            'C' => $colC, 'D' => $colD, 'E' => $colE, 'F' => $colF, 'G' => $colG,
                                            'H' => $colH, 'I' => $colI, 'J' => $colJ, 'K' => $colK, 'L' => $colL,
                                            'M' => $colM, 'N' => $colN, 'O' => $colO, 'P' => $colP, 'Q' => $colQ ]
                                        );
                                        $subId++;
                                    }
                                    fclose($handle1);
                                } else {
                                    echo "Could not open file: " . $file;
                                }
                            }
                            DB::table('csv_file_import')->insert(
                                ['id' => $importId, 'file_name' => basename($file)]
                            );
                        }
                    }
                }
            }
            closedir($handle);
        }
    }
}
