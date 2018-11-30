<?php

namespace App\Http\Controllers;

use App\Mail\SendEmail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use PDF;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use ZipArchive;

set_time_limit(300);
class HomeController extends Controller
{
    public function readAndSaveCSV()
    {
        $dir = public_path() . '/files/';
        $files = glob($dir . '*');
        foreach ($files as $file) {
            $dateOld = strtotime(date("Y-m-d H:i:s", filemtime($file)));
            $dateNew = strtotime(date('Y-m-d H:i:s'));
            $start_date = $dateNew - $dateOld;
            // if ($start_date < 60) {
            if (true) {
                $importMaxId = DB::table('csv_data_import')->max('id');
                if ($importMaxId == "") {
                    $importMaxId = 0;
                }
                $importMaxId += 1;

                $importId = $importMaxId;
                $subId = 1;
                $fileReader = fopen($file, 'r');
                echo "<h2>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Thanh cong: " . basename($file) . " (Khoang thoi gian: " . $start_date . ")</h2>";
                while (($data = fgetcsv($fileReader, 1000, ",")) !== false) {
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
                            'M' => $colM, 'N' => $colN, 'O' => $colO, 'P' => $colP, 'Q' => $colQ]
                    );
                    $subId++;
                }
                fclose($fileReader);

                DB::table('csv_file_import')->insert(
                    ['id' => $importId, 'file_name' => basename($file)]
                );

                // Create folder
                $path = public_path() . '/' . $importId;
                mkdir($path, 0777, true);
                // $this->exportPDF1($importId, $path);
                $this->exportFile($importId, $path);
                // $this->sendMail($importId);
                // $this->deleteFileZip($importId);
            } else {
                echo "<h2>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;That bai: " . basename($file) . " (Khoang thoi gian: " . $start_date . ")</h2>";
            }
            // end if($start_date < 60)
        }
    }

    public function exportPDF1($importId, $path)
    {
        $dataPDF1 = DB::table('csv_data_import')
            ->select('B', 'C', 'M', 'N', 'J', 'K', 'Q')
            ->where([
                ['O', '=', '−'],
                ['P', '=', '○'],
                ['K', '=', 'ベベル'],
                ['B', '=', '1階'],
                ['id', '=', $importId]])
            ->orderByRaw('N desc')
            ->get();
        $filename = $dataPDF1[0]->Q . '_１階先行壁.pdf';
        $pdf = PDF::loadView('filepdf1', compact('dataPDF1'));
        $pdf->setPaper('a4', 'landscape');
        $saveFile = $path . '/' . $filename;
        $pdf->save($saveFile);
    }

    public function exportFile($importId, $path)
    {
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load(public_path() . "/template/Excel/template01.xlsx");

        $dataImport1_1 = DB::table('csv_data_import')
            ->where([
                ['id', '=', $importId],
                ['A', '=', 'カベ'],
                ['B', '=', '1階'],
                ['O', '=', '−'],
                ['P', '=', '○'],
            ])
            ->orderByRaw('N DESC')
            ->get();
        $this->addDataToSheet($dataImport1_1, '先行1階2階', 3, $spreadsheet);

        //add data sheet 1-2
        $dataImport1_2 = DB::table('csv_data_import')
            ->where([
                ['id', '=', $importId],
                ['A', '=', 'カベ'],
                ['B', '=', '2階'],
                ['O', '=', '−'],
                ['P', '=', '○'],
            ])
            ->orderByRaw('N DESC')
            ->get();
        $this->addDataToSheet($dataImport1_2, '先行1階2階', 506, $spreadsheet);

        // add data sheet 2
        $dataImport2 = DB::table('csv_data_import')
            ->where([
                ['id', '=', $importId],
                ['A', '=', 'テンジョウ'],
                ['B', '=', '1階'],
                ['O', '=', '−'],
            ])
            ->orderByRaw('K ASC, N DESC')
            ->get();
        $this->addDataToSheet($dataImport2, '天井1階', 3, $spreadsheet);

        // add data sheet 3
        $dataImport3 = DB::table('csv_data_import')
            ->where([
                ['id', '=', $importId],
                ['A', '=', 'テンジョウ'],
                ['B', '=', '2階'],
                ['O', '=', '−'],
            ])
            ->orderByRaw('K ASC, N DESC')
            ->get();

        $this->addDataToSheet($dataImport3, '天井2階', 3, $spreadsheet);

        // add data sheet 4-1
        $dataImport4_1 = DB::table('csv_data_import')
            ->where([
                ['id', '=', $importId],
                ['A', '=', 'カベ'],
                ['B', '=', '1階'],
                ['O', '=', '−'],
                ['P', '=', '−'],
            ])
            ->orderByRaw('K ASC, N DESC')
            ->get();

        $this->addDataToSheet($dataImport4_1, '壁1階2階', 3, $spreadsheet);

        // add data sheet 4-2
        $dataImport4_2 = DB::table('csv_data_import')
            ->where([
                ['id', '=', $importId],
                ['A', '=', 'カベ'],
                ['B', '=', '2階'],
                ['O', '=', '−'],
                ['P', '=', '−'],
            ])
            ->orderByRaw('K ASC,N DESC')
            ->get();

        $this->addDataToSheet($dataImport4_2, '壁1階2階', 506, $spreadsheet);

        $spreadsheet->setActiveSheetIndex(0);

        // Save file to folder
        $writer = new Xlsx($spreadsheet);
        $saveFile = $path . '/' . '門沢橋3丁目2048番・B号棟_加工明細.xlsx';
        $writer->save($saveFile);

        // zip and download file zip
        $file_folder = $path . '/'; // folder to load files
        $files = glob($file_folder . '*');
        if (extension_loaded('zip')) {
            // Checking files are selected
            $zip = new ZipArchive(); // Load zip library
            $zip_name = $importId . '.zip'; // Zip name
            $zip_folder = $importId . '/';
            if ($zip->open($zip_name, ZIPARCHIVE::CREATE) !== true) {
                $error .= "* Sorry ZIP creation failed at this time";
            }
            foreach ($files as $file) {
                $position = strrpos($file, '/');
                $basename = substr($file, $position + 1);
                $zip->addFile($zip_folder . $basename);
                continue;
            }

            $isFinished = $zip->close();
            if ($isFinished) {
                // remove folder tmp
                // $this->deleteDirectory($path);
            } else {
                throw new Exception("could not close zip file: " . $zip->getStatusString());
            }
        }
    }

    public function addDataToSheet($dataImport, $sheetName, $index, $spreadsheet)
    {
        $importId = $dataImport[0]->id;
        $floor = $dataImport[0]->B;
        $thickness = $dataImport[0]->L;
        $name = $dataImport[0]->K;
        $indexCell = $index;
        $total = 0;
        $totalCellJ = 0;
        $maxSubId = DB::table('details_data_import')->max('sub_id');
        if ($maxSubId == "") {
            $maxSubId = 0;
        }
        $maxSubId += 1;

        $cellPos = array(
            "B", "C", "D", "E", "G", "H", "I", "J", "K", "M", "N", "O", "P", "Q", "R",
        );
        $spreadsheet->setActiveSheetIndexByName($sheetName);
        $sheet = $spreadsheet->getActiveSheet();

        foreach ($dataImport as $data) {
            $cellValue = array();
            $M = intval($data->M);
            $N = intval($data->N);

            if ($sheetName == "先行1階2階") {
                if ($N <= 910 && $M < $N) {
                    $temp = $M;
                    $M = $N;
                    $N = $temp;
                }
            }

            if ($M == 910) {
                $I = $M / 1000;
            } else {
                $I = (910 + $N) / 1000;
            }

            if ($M <= 910) {
                $M_cell = 3;
            }

            if ($N <= 1820) {
                $N_cell = 6;
            } else {
                $N_cell = 8;
            }

            if ($M > 0 && $M <= 227.5) {
                $O = 0.25;
            } else if ($M > 227.5 && $M <= 455) {
                $O = 0.5;
            } else if ($M > 455 && $M <= 672.5) {
                $O = 0.75;
            } else {
                $O = 1;
            }
            if ($N >= 1600) {$P = 1;} else { $P = $this->roundNumber($N / 1600);}
            $Q = $this->roundNumber(($data->G) * $O * $P);
            $R = $this->roundNumber(($M_cell * $N_cell * $Q) / 36);            
            $J = intval($data->G) * $I;
            $indexCell ++;
            
            if($name != $data->K)
            {
                if($sheetName == '天井1階' || $sheetName == '壁1階2階')
                {
                    $sheet->setCellValue('S'.((string)($indexCell - 2)), $total);
                }
                DB::table('details_data_import')->insert(
                    ['id' => $importId, 'sub_id' => $maxSubId, 'sheet' => $sheetName,
                    'floor' => $floor, 'name' => $name, 'thickness' => $thickness, 'total' => $total]
                );
                $name = $data->K;
                $total = $R;
                $maxSubId ++;
            }
            else
            {
                $total += $R;
            }
            $totalCellJ += $J;

            array_push($cellValue, $data->C);
            array_push($cellValue, $data->K);
            array_push($cellValue, $data->L);
            array_push($cellValue, $M);
            array_push($cellValue, $N);
            array_push($cellValue, $data->G);
            array_push($cellValue, $I);
            array_push($cellValue, $J);
            array_push($cellValue, $data->J);
            array_push($cellValue, $M_cell);
            array_push($cellValue, $N_cell);
            array_push($cellValue, $O);
            array_push($cellValue, $P);
            array_push($cellValue, $Q);
            array_push($cellValue, $R);

            for ($i = 0; $i < count($cellPos); $i++) {
                $num = (string) $index;
                $cellpos = $cellPos[$i] . $num;
                $sheet->setCellValue($cellpos, $cellValue[$i]);
            }
            $index++;
        }
        if($sheetName == '天井1階' || $sheetName == '壁1階2階')
        {
            $sheet->setCellValue('S'.((string)($indexCell - 1)), $total);
        }
        DB::table('details_data_import')->insert(
            ['id' => $importId, 'sub_id' => $maxSubId, 'sheet' => $sheetName,
            'floor' => $floor, 'name' => $name, 'thickness' => $thickness, 'total' => $total]
        );
        $maxSubId ++;
        DB::table('details_data_import')->insert(
            ['id' => $importId, 'sub_id' => $maxSubId, 'sheet' => $sheetName,
            'floor' => $floor, 'name' => '総切断m', 'thickness' => '0', 'total' => ceil($totalCellJ)]
        );

    }

    private function roundNumber($number)
    {
        $val2 = round($number, 2);
        if ($val2 < $number) {
            $val2 += 0.01;
        }
        return $val2;
    }

    public function deleteDirectory($dirPath)
    {
        if (is_dir($dirPath)) {
            $objects = scandir($dirPath);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (filetype($dirPath . DIRECTORY_SEPARATOR . $object) == "dir") {
                        deleteDirectory($dirPath . DIRECTORY_SEPARATOR . $object);
                    } else {
                        unlink($dirPath . DIRECTORY_SEPARATOR . $object);
                    }
                }
            }
            reset($objects);
            rmdir($dirPath);
        }
    }

    public function sendMail($importId)
    {
        $objDemo = new \stdClass();
        $objDemo->demo_one = 'Demo One Value';
        $objDemo->demo_two = 'Demo Two Value';
        $objDemo->sender = 'Trung Admin';
        $objDemo->receiver = 'Trung User';
        $objDemo->import_id = $importId;

        Mail::to("nguyentrung17891@gmail.com")->send(new SendEmail($objDemo));
    }

    public function deleteFileZip($importId)
    {
        $file_folder = public_path() . '/'; // folder to load files
        $files = glob($file_folder . '*');
        foreach ($files as $file) {
            $position = strrpos($file, '/');
            $basename = substr($file, $position + 1);
            if ($basename == $importId . '.zip') {
                unlink($basename);
            }
            continue;
        }
    }
}
