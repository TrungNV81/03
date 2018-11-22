<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use ZipArchive;
use Symfony\Component\HttpFoundation\StreamedResponse;

class HomeController extends Controller
{
    public function readAndSaveCSV()
    {
        $dir = public_path() . '/files/';
        if ($handle = opendir($dir)) {
            while (false !== ($entry = readdir($handle))) {
                if ($entry != "." && $entry != "..") {
                    if (file_exists($dir . $entry)) {
                        $dateOld = strtotime(date("Y-m-d H:i:s", filemtime($dir . $entry)));
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
                            $files = glob($dir . $entry);
                            foreach ($files as $file) {
                                if (($handle1 = fopen($file, "r")) !== false) {
                                    echo "<h2>Filename: " . basename($file) . "</h2></hr>";
                                    while (($data = fgetcsv($handle1, 1000, ",")) !== false) {
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
                                    fclose($handle1);
                                } else {
                                    echo "Could not open file: " . $file;
                                }
                            }
                            DB::table('csv_file_import')->insert(
                                ['id' => $importId, 'file_name' => basename($file)]
                            );
                        }
                        // end if($start_date < 60)
                    }
                }
            }
            closedir($handle);
        }
        $this->exportFile($importId);
    }

    public function exportFile($importId)
    {
        $cellPos = array(
            "B", "C", "D", "E", "G", "H", "K",
        );
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load(public_path() . "/template/Excel/template01.xlsx");
        // add data sheet 1-1
        $dataImport1_1 = DB::table('csv_data_import')
            ->where([
                ['id', '=', $importId],
                ['B', '=', '1階'],
                ['K', '=', 'ベベル'],
                ['O', '=', '−'],
                ['P', '=', '○'],
            ])
            ->orderByRaw('N DESC')
            ->get();

        $spreadsheet->setActiveSheetIndexByName("先行1階2階");
        $sheet = $spreadsheet->getActiveSheet();
        $index = 3;
        foreach ($dataImport1_1 as $data) {
            $cellValue = array();
            array_push($cellValue, $data->C);
            array_push($cellValue, $data->K);
            array_push($cellValue, $data->L);
            array_push($cellValue, $data->M);
            array_push($cellValue, $data->N);
            array_push($cellValue, $data->G);
            array_push($cellValue, $data->J);
            for ($i = 0; $i < count($cellPos); $i++) {
                $num = (string) $index;
                $cellpos = $cellPos[$i] . $num;
                $sheet->setCellValue($cellpos, $cellValue[$i]);
            }
            $index++;
        }

        //add data sheet 1-2
        $dataImport1_2 = DB::table('csv_data_import')
            ->where([
                ['id', '=', $importId],
                ['B', '=', '2階'],
                ['K', '=', 'ベベル'],
                ['O', '=', '−'],
                ['P', '=', '○'],
            ])
            ->orderByRaw('N DESC')
            ->get();

        $index = 506;
        foreach ($dataImport1_2 as $data) {
            $cellValue = array();
            array_push($cellValue, $data->C);
            array_push($cellValue, $data->K);
            array_push($cellValue, $data->L);
            array_push($cellValue, $data->M);
            array_push($cellValue, $data->N);
            array_push($cellValue, $data->G);
            array_push($cellValue, $data->J);
            for ($i = 0; $i < count($cellPos); $i++) {
                $num = (string) $index;
                $cellpos = $cellPos[$i] . $num;
                $sheet->setCellValue($cellpos, $cellValue[$i]);
            }
            $index++;
        }

        // add data sheet 2
        $dataImport2 = DB::table('csv_data_import')
            ->where([
                ['id', '=', $importId],
                ['B', '=', '1階'],
                ['L', '=', '9.5'],
                ['O', '=', '−'],
                ['P', '=', '−'],
            ])
            ->orderByRaw('K ASC, N DESC')
            ->get();

        $spreadsheet->setActiveSheetIndexByName("天井1階");
        $sheet = $spreadsheet->getActiveSheet();
        $index = 3;
        foreach ($dataImport2 as $data) {
            $cellValue = array();
            array_push($cellValue, $data->C);
            array_push($cellValue, $data->K);
            array_push($cellValue, $data->L);
            array_push($cellValue, $data->M);
            array_push($cellValue, $data->N);
            array_push($cellValue, $data->G);
            array_push($cellValue, $data->J);
            for ($i = 0; $i < count($cellPos); $i++) {
                $num = (string) $index;
                $cellpos = $cellPos[$i] . $num;
                $sheet->setCellValue($cellpos, $cellValue[$i]);
            }
            $index++;
        }

        // add data sheet 3
        $dataImport3 = DB::table('csv_data_import')
            ->where([
                ['id', '=', $importId],
                ['B', '=', '2階'],
                ['L', '=', '9.5'],
                ['O', '=', '−'],
                ['P', '=', '−'],
            ])
            ->orderByRaw('K ASC, N DESC')
            ->get();

        $spreadsheet->setActiveSheetIndexByName("天井2階");
        $sheet = $spreadsheet->getActiveSheet();
        $index = 3;
        foreach ($dataImport3 as $data) {
            $cellValue = array();
            array_push($cellValue, $data->C);
            array_push($cellValue, $data->K);
            array_push($cellValue, $data->L);
            array_push($cellValue, $data->M);
            array_push($cellValue, $data->N);
            array_push($cellValue, $data->G);
            array_push($cellValue, $data->J);
            for ($i = 0; $i < count($cellPos); $i++) {
                $num = (string) $index;
                $cellpos = $cellPos[$i] . $num;
                $sheet->setCellValue($cellpos, $cellValue[$i]);
            }
            $index++;
        }

        // add data sheet 4-1
        $dataImport4_1 = DB::table('csv_data_import')
            ->where([
                ['id', '=', $importId],
                ['B', '=', '1階'],
                ['L', '=', '12.5'],
                ['O', '=', '−'],
                ['P', '=', '−'],
            ])
            ->orderByRaw('K ASC, N DESC')
            ->get();

        $spreadsheet->setActiveSheetIndexByName("壁1階2階");
        $sheet = $spreadsheet->getActiveSheet();
        $index = 3;
        foreach ($dataImport4_1 as $data) {
            $cellValue = array();
            array_push($cellValue, $data->C);
            array_push($cellValue, $data->K);
            array_push($cellValue, $data->L);
            array_push($cellValue, $data->M);
            array_push($cellValue, $data->N);
            array_push($cellValue, $data->G);
            array_push($cellValue, $data->J);
            for ($i = 0; $i < count($cellPos); $i++) {
                $num = (string) $index;
                $cellpos = $cellPos[$i] . $num;
                $sheet->setCellValue($cellpos, $cellValue[$i]);
            }
            $index++;
        }

        // add data sheet 4-2
        $dataImport4_2 = DB::table('csv_data_import')
            ->where([
                ['id', '=', $importId],
                ['B', '=', '2階'],
                ['L', '=', '12.5'],
                ['O', '=', '−'],
                ['P', '=', '−'],
            ])
            ->orderByRaw('N DESC')
            ->get();

        $index = 506;
        foreach ($dataImport4_2 as $data) {
            $cellValue = array();
            array_push($cellValue, $data->C);
            array_push($cellValue, $data->K);
            array_push($cellValue, $data->L);
            array_push($cellValue, $data->M);
            array_push($cellValue, $data->N);
            array_push($cellValue, $data->G);
            array_push($cellValue, $data->J);
            for ($i = 0; $i < count($cellPos); $i++) {
                $num = (string) $index;
                $cellpos = $cellPos[$i] . $num;
                $sheet->setCellValue($cellpos, $cellValue[$i]);
            }
            $index++;
        }
        $spreadsheet->setActiveSheetIndex(0);

        $writer = new Xlsx($spreadsheet);
        $response = new StreamedResponse(
            function () use ($writer) {
                $writer->save('php://output');
            }
        );
        $response->headers->set('Content-Type', 'application/vnd.ms-excel');
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome') == true || strpos($_SERVER['HTTP_USER_AGENT'], 'CriOS') == true) {
            $response->headers->set('Content-Disposition', 'attachment;filename="納品明細.xlsx"');
        } else {
            $response->headers->set('Content-Disposition', 'attachment;filename="' . mb_convert_encoding('納品明細.xlsx', 'Shift-JIS', 'UTF-8') . '"');
        }
        $response->headers->set('Cache-Control', 'max-age=0');

        // // Create folder
        // $path = public_path() . '/' . $importId;
        // mkdir($path, 0777, true);
        // // Save file to folder
        // $writer = new Xlsx($spreadsheet);
        // $saveFile = $path . '/' . '門沢橋3丁目2048番・B号棟_加工明細.xlsx';
        // $writer->save($saveFile);

        // // zip and download file zip
        // $file_folder = $path . '/'; // folder to load files
        // $files = glob($file_folder . '*');
        // if (extension_loaded('zip')) {
        //     // Checking files are selected
        //     $zip = new ZipArchive(); // Load zip library
        //     $zip_name = $importId . '.zip'; // Zip name
        //     $zip_folder = $importId . '/';
        //     if ($zip->open($zip_name, ZIPARCHIVE::CREATE) !== true) {
        //         $error .= "* Sorry ZIP creation failed at this time";
        //     }
        //     foreach ($files as $file) {
        //         $position = strrpos($file, '/');
        //         $basename = substr($file, $position + 1);
        //         $zip->addFile($zip_folder . $basename);
        //         continue;
        //     }

        //     $isFinished = $zip->close();
        //     if ($isFinished) {
        //         // remove folder tmp
        //         // $this->deleteDirectory($path);
        //         // archive is now downloadable ...
        //         return response()->download($zip_name)->deleteFileAfterSend(true);
        //     } else {
        //         throw new Exception("could not close zip file: " . $zip->getStatusString());
        //     }
        // }
    }
}
