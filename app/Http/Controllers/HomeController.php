<?php

namespace App\Http\Controllers;

use App\Mail\SendEmail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use PDF;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use File;
use Symfony\Component\HttpFoundation\StreamedResponse;
use ZipArchive;

set_time_limit(600);
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

                $filenameArr = DB::table('csv_data_import')
                ->select('Q')
                ->where([
                    ['id', '=', $importId],
                ])
                ->get();

                $filename = $filenameArr[0]->Q;
                // Create folder
                $path = public_path() . '/' .  $filename;
                mkdir($path, 0777, true);

                $pathExcel = public_path() . '/' . $filename. '/' .'EXCEL';
                mkdir($pathExcel, 0777, true);
                $this->exportFile1($importId, $pathExcel,$filename);
                $this->exportFile2($importId, $pathExcel);
                // $this->sendMail($importId);
                
                $this->zip($path, $filename);
                // $this->deleteFileZip($filename);
            } else {
                echo "<h2>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;That bai: " . basename($file) . " (Khoang thoi gian: " . $start_date . ")</h2>";
            }
            // end if($start_date < 60)
        }
    }

    public function exportPDF($path, $dataPDF, $file_extension)
    {
        $filename = $dataPDF[0]->Q . $file_extension;
        $pdf = PDF::loadView('filepdf1', compact('dataPDF'));
        $pdf->setPaper('a4', 'landscape');
        $saveFile = $path . '/' . $filename;
        $pdf->save($saveFile);
    }

    public function exportFile1($importId, $path, $filename) // file 指示書

    {
        $pathPDF = public_path() . '/' . $filename. '/' .'PDF';
        mkdir($pathPDF, 0777, true);
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
        $this->addDataToFile1($dataImport1_1, '先行1階2階', 3, $spreadsheet, 2395);
        $this->exportPDF($pathPDF, $dataImport1_1, '_１階先行壁.pdf');
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
        $this->addDataToFile1($dataImport1_2, '先行1階2階', 506, $spreadsheet, 2395);
        $this->exportPDF($pathPDF, $dataImport1_2, '_１階天井.pdf');
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
        $this->addDataToFile1($dataImport2, '天井1階', 3, $spreadsheet, 1820);
        $this->exportPDF($pathPDF, $dataImport2, '_１階壁.pdf');
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

        $this->addDataToFile1($dataImport3, '天井2階', 3, $spreadsheet, 1820);
        $this->exportPDF($pathPDF, $dataImport3, '_２階先行壁.pdf');
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

        $this->addDataToFile1($dataImport4_1, '壁1階2階', 3, $spreadsheet, 2395);
        $this->exportPDF($pathPDF, $dataImport4_1, '_２階天井.pdf');
        // add data sheet 4-2
        $dataImport4_2 = DB::table('csv_data_import')
            ->where([
                ['id', '=', $importId],
                ['A', '=', 'カベ'],
                ['B', '=', '2階'],
                ['O', '=', '−'],
                ['P', '=', '−'],
            ])
            ->orderByRaw('K ASC, N DESC')
            ->get();

        $this->addDataToFile1($dataImport4_2, '壁1階2階', 506, $spreadsheet, 2395);
        $this->exportPDF($pathPDF, $dataImport4_2, '_２階壁.pdf');
        $spreadsheet->setActiveSheetIndex(0);

        // Save file to folder
        $filename = $dataImport1_1[0]->Q;
        $writer = new Xlsx($spreadsheet);
        $saveFile = $path . '/' . $filename . '_加工明細.xlsx';
        $writer->save($saveFile);


    }

    public function addDataToFile1($dataImport, $sheetName, $index, $spreadsheet, $tmpN) // file 指示書

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
            } else if ($N == $tmpN) {
                $I = $N / 1000;
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

            if ($N >= 1600) {
                $P = 1;
            } else {
                $P = $this->roundNumber($N / 1600);
            }

            $Q = round((($data->G) * $O * $P), 2);
            $R = round((($M_cell * $N_cell * $Q) / 36), 2);
            $J = intval($data->G) * $I;
            $indexCell++;

            if ($sheetName == '先行1階2階') {
                $totalx = floor($total);
            } else {
                $totalx = ceil($total);
            }

            if ($name != $data->K) {
                if ($sheetName == '天井1階' || $sheetName == '壁1階2階') {
                    $sheet->setCellValue('S' . ((string) ($indexCell - 2)), $total);
                }

                DB::table('details_data_import')->insert(
                    ['id' => $importId, 'sub_id' => $maxSubId, 'sheet' => $sheetName,
                        'floor' => $floor, 'name' => $name, 'thickness' => $thickness, 'total' => $totalx]
                );
                $name = $data->K;
                $total = $R;
                $maxSubId++;
            } else {
                $total += $R;

                if ($sheetName == '先行1階2階') {
                    $totalx = floor($total);
                } else {
                    $totalx = ceil($total);
                }
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
        if ($sheetName == '天井1階' || $sheetName == '壁1階2階') {
            $sheet->setCellValue('S' . ((string) ($indexCell - 1)), $total);
        }
        DB::table('details_data_import')->insert(
            ['id' => $importId, 'sub_id' => $maxSubId, 'sheet' => $sheetName,
                'floor' => $floor, 'name' => $name, 'thickness' => $thickness, 'total' => $totalx]
        );
        $maxSubId++;
        DB::table('details_data_import')->insert(
            ['id' => $importId, 'sub_id' => $maxSubId, 'sheet' => $sheetName,
                'floor' => $floor, 'name' => '総切断m', 'thickness' => '0', 'total' => ceil($totalCellJ)]
        );

    }

    public function exportFile2($importId, $path) // file 指示書

    {
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load(public_path() . "/template/Excel/template02.xlsx");

        // sheet 情報
        $cellPos = array(
            "B12", "C12", "B13", "C13", "B14", "C14",
        );

        $dataImport1 = DB::table('details_data_import')
            ->where([
                ['id', '=', $importId],
                ['thickness', '=', '0'],
            ])
            ->get();
        $spreadsheet->setActiveSheetIndexByName('情報');
        $sheet = $spreadsheet->getActiveSheet();
        for ($i = 0; $i < count($cellPos); $i++) {
            $cellpos = $cellPos[$i];
            $sheet->setCellValue($cellpos, $dataImport1[$i]->total);
        }
        // end sheet 情報

        // sheet 工場1便
        $dataImport2 = DB::table('details_data_import')
            ->select('name', 'thickness', 'total as F1', DB::raw('sum(total) as total'))
            ->where([
                ['id', '=', $importId],
                ['sheet', '=', '先行1階2階'],
                ['thickness', '!=', '0'],
            ])
            ->groupBy('name')
            ->get();

        $numRec = 0;
        $this->addDataToFile2($dataImport2, $spreadsheet, '工場1便', 1, $numRec);

        // end sheet 工場1便

        // sheet 工場2便
        $dataImport3 = DB::table('details_data_import')
            ->select('name', 'thickness', 'total as F1', DB::raw('sum(total) as total'))
            ->where([
                ['id', '=', $importId],
                ['sheet', '=', '天井1階'],
                ['thickness', '!=', '0'],
            ])
            ->orWhere([
                ['id', '=', $importId],
                ['sheet', '=', '天井2階'],
                ['thickness', '!=', '0'],
            ])
            ->groupBy('name')
            ->get();
        $numRec = 0;
        $this->addDataToFile2($dataImport3, $spreadsheet, '工場2便', 1, $numRec);
        // end sheet 工場2便

        // sheet 工場3便
        $dataImport4 = DB::table('details_data_import')
            ->select('name', 'thickness', 'total as F1', DB::raw('sum(total) as total'))
            ->where([
                ['id', '=', $importId],
                ['sheet', '=', '壁1階2階'],
                ['thickness', '!=', '0'],
            ])
            ->groupBy('name')
            ->get();
        $numRec = 0;
        $this->addDataToFile2($dataImport4, $spreadsheet, '工場3便', 1, $numRec);
        // end sheet 工場3便

        // sheet 営業1便
        $dataImport5 = DB::table('csv_data_import')
            ->select('K as name', 'L as thickness', 'Q', 'M', 'N', 'G as F1', DB::raw('sum(G) as total'))
            ->where([
                ['id', '=', $importId],
                ['A', '=', 'カベ'],
                ['B', '=', '1階'],
                ['I', '=', '先行ボード'],
                ['K', '=', 'マーク付きベベル'],
                ['M', '=', '910'],
                ['N', '=', '2395'],
                ['O', '=', '○'],
            ])
            ->orWhere([
                ['id', '=', $importId],
                ['A', '=', 'カベ'],
                ['B', '=', '2階'],
                ['I', '=', '先行ボード'],
                ['K', '=', 'マーク付きベベル'],
                ['M', '=', '910'],
                ['N', '=', '2395'],
                ['O', '=', '○'],
            ])
            ->groupBy('K')
            ->get();

        $numRec = count($dataImport2);
        $this->addDataToFile2($dataImport2, $spreadsheet, '営業1便', 1, $numRec);
        $this->addDataToFile2($dataImport5, $spreadsheet, '営業1便', 2, $numRec);
        // end sheet 営業1便

        // sheet 営業2便
        $dataImport6 = DB::table('csv_data_import')
            ->select('K as name', 'L as thickness', 'M', 'N', 'G as F1', DB::raw('sum(G) as total'))
            ->where([
                ['id', '=', $importId],
                ['A', '=', 'テンジョウ'],
                ['B', '=', '1階'],
                ['K', '=', 'べべル'],
                ['M', '=', '910'],
                ['N', '=', '1820'],
                ['O', '=', '○'],
            ])
            ->orWhere([
                ['id', '=', $importId],
                ['A', '=', 'テンジョウ'],
                ['B', '=', '2階'],
                ['K', '=', 'べべル'],
                ['M', '=', '910'],
                ['N', '=', '1820'],
                ['O', '=', '○'],
            ])
            ->groupBy('K')
            ->get();

        $numRec = count($dataImport3);
        $this->addDataToFile2($dataImport3, $spreadsheet, '営業2便', 1, $numRec);
        $this->addDataToFile2($dataImport6, $spreadsheet, '営業2便', 2, $numRec);
        // end sheet 営業2便

        // sheet 営業3便
        $dataImport7 = DB::table('csv_data_import')
            ->select('K as name', 'L as thickness', 'M', 'N', 'G as F1', DB::raw('sum(G) as total'))
            ->where([
                ['id', '=', $importId],
                ['A', '=', 'カベ'],
                ['B', '=', '1階'],
                ['K', '=', 'マーク付きベベル'],
                ['M', '=', '910'],
                ['N', '=', '2395'],
                ['O', '=', '○'],
            ])
            ->orWhere([
                ['id', '=', $importId],
                ['A', '=', 'カベ'],
                ['B', '=', '2階'],
                ['K', '=', 'マーク付きベベル'],
                ['M', '=', '910'],
                ['N', '=', '2395'],
                ['O', '=', '○'],
            ])
            ->groupBy('K')
            ->get();

        $dataImport8 = DB::table('csv_data_import')
            ->select('K as name', 'L as thickness', 'M', 'N', 'G as F1', DB::raw('sum(G) as total'))
            ->where([
                ['id', '=', $importId],
                ['A', '=', 'カベ'],
                ['B', '=', '1階'],
                ['D', '=', 'コーナーボード'],
                ['M', '=', '65'],
                ['N', '=', '2395'],
                ['O', '=', '○'],
            ])
            ->orWhere([
                ['id', '=', $importId],
                ['A', '=', 'カベ'],
                ['B', '=', '2階'],
                ['D', '=', 'コーナーボード'],
                ['M', '=', '65'],
                ['N', '=', '2395'],
                ['O', '=', '○'],
            ])
            ->groupBy('K')
            ->get();

        $numRec = count($dataImport4);
        $this->addDataToFile2($dataImport4, $spreadsheet, '営業3便', 1, $numRec);
        $this->addDataToFile2($dataImport7, $spreadsheet, '営業3便', 2, $numRec);
        $numRec += count($dataImport7);
        $this->addDataToFile2($dataImport8, $spreadsheet, '営業3便', 2, $numRec);
        // end sheet 営業3便

        $spreadsheet->setActiveSheetIndex(0);
        // Save file to folder
        $writer = new Xlsx($spreadsheet);
        $filename = $dataImport5[0]->Q;  
        $saveFile = $path . '/' . $filename . '_指示書.xlsx';
        // $saveFile = $path . '/' . $importId . '2.xlsx';
        $writer->save($saveFile);

        $spreadsheet1 = \PhpOffice\PhpSpreadsheet\IOFactory::load(public_path() . "/template/Excel/template03.xlsx");
        $this->addDataToFile3and4($dataImport2, $dataImport5, $spreadsheet1, '受注');
        $spreadsheet1->setActiveSheetIndex(0);
        // Save file to folder
        $writer1 = new Xlsx($spreadsheet1);
        $saveFile = $path . '/' . $filename . '_受注1便.xlsx';
        $writer1->save($saveFile);


        $spreadsheet2 = \PhpOffice\PhpSpreadsheet\IOFactory::load(public_path() . "/template/Excel/template03.xlsx");
        $this->addDataToFile3and4($dataImport3, $dataImport6, $spreadsheet2, '受注');
        $spreadsheet2->setActiveSheetIndex(0);
        // Save file to folder
        $writer2 = new Xlsx($spreadsheet2);
        $saveFile = $path . '/' . $filename . '_受注2便.xlsx';
        $writer2->save($saveFile);

        $spreadsheet3 = \PhpOffice\PhpSpreadsheet\IOFactory::load(public_path() . "/template/Excel/template03.xlsx");
        $this->addDataToFile5($dataImport4, $dataImport7, $dataImport8, $spreadsheet3, '受注');
        $spreadsheet3->setActiveSheetIndex(0);
        // Save file to folder
        $writer3 = new Xlsx($spreadsheet3);
        $saveFile = $path . '/' . $filename . '_受注3便.xlsx';
        $writer3->save($saveFile);

       
    }

    private function addDataToFile5($data1, $data2, $data3, $spreadsheet, $sheetName){
        $spreadsheet->setActiveSheetIndexByName($sheetName);
        $sheet = $spreadsheet->getActiveSheet();
        $num = 4;
        foreach($data1 as $data){
            $F = '910×910';
            $H = $data->total - $data->F1;
            if ($H == 0) {
                $H = '';
            }
            $sheet->setCellValue("B1" . $num, $data->name);
            $sheet->setCellValue("C1" . $num, '加工');
            $sheet->setCellValue("E1" . $num, $data->thickness);
            $sheet->setCellValue("F1" . $num, $F);
            $sheet->setCellValue("G1" . $num, $data->F1);
            $sheet->setCellValue("H1" . $num, $H);
            $sheet->setCellValue("J1" . $num, '坪');
            $num++;
        }
        foreach($data2 as $data){
            $F = $data->M . '×' . $data->N;
            $H = $data->total - $data->F1;
            if ($H == 0) {
                $H = '';
            }
            $sheet->setCellValue("B1" . $num, $data->name);
            $sheet->setCellValue("C1" . $num, '原板');
            $sheet->setCellValue("E1" . $num, $data->thickness);
            $sheet->setCellValue("F1" . $num, $F);
            $sheet->setCellValue("G1" . $num, $data->F1);
            $sheet->setCellValue("H1" . $num, $H);
            $sheet->setCellValue("J1" . $num, ' 枚');
            $num++;
        }
        foreach($data3 as $data){
            $F = $data->M . '×' . $data->N;
            $H = $data->total - $data->F1;
            if ($H == 0) {
                $H = '';
            }
            $sheet->setCellValue("B1" . $num, $data->name);
            $sheet->setCellValue("C1" . $num, '原板');
            $sheet->setCellValue("E1" . $num, $data->thickness);
            $sheet->setCellValue("F1" . $num, $F);
            $sheet->setCellValue("G1" . $num, $data->F1);
            $sheet->setCellValue("H1" . $num, $H);
            $sheet->setCellValue("J1" . $num, ' 枚');
            $num++;
        }
    }

    private function addDataToFile2($data, $spreadsheet, $sheetName, $numRow, $numRec) // file 指示書

    {
        $spreadsheet->setActiveSheetIndexByName($sheetName);
        $sheet = $spreadsheet->getActiveSheet();
        if ($numRow == 1) {
            if ($sheetName == '営業1便' || $sheetName == '営業2便' || $sheetName == '営業3便') {
                $num = 0;
            } else {
                $num = 2;
            }
            for ($i = 0; $i < count($data); $i++, $num++) {
                $H = $data[$i]->total - $data[$i]->F1;
                if ($H == 0) {
                    $H = '';
                }
                if ($sheetName == '営業1便' || $sheetName == '営業2便' || $sheetName == '営業3便') {
                    $sheet->setCellValue("B1" . $num, $data[$i]->name);
                    $sheet->setCellValue("C1" . $num, '加工');
                    $sheet->setCellValue("E1" . $num, $data[$i]->thickness);
                    
                    if ($data[$i]->F1 != '') {
                        if ($data[$i]->name == 'マーク付きベベル' || $data[$i]->name == '耐水ベベル') {
                            $sheet->setCellValue("G1" . $num, round(($data[$i]->F1) * 1.5));
                        } else {
                            $sheet->setCellValue("G1" . $num, ($data[$i]->F1) * 2);
                        }
                    } else {
                        $sheet->setCellValue("G1" . $num, $data[$i]->F1);
                    }

                    if ($H != '') {
                        if ($data[$i]->name == 'マーク付きベベル' || $data[$i]->name == '耐水ベベル') {
                            $sheet->setCellValue("H1" . $num, round($H * 1.5));
                        } else {
                            $sheet->setCellValue("H1" . $num, ($H * 2));
                        }
                    } else {
                        $sheet->setCellValue("H1" . $num, $H);
                    }
                } else {
                    $sheet->setCellValue("B1" . $num, $data[$i]->name);
                    $sheet->setCellValue("E1" . $num, $data[$i]->thickness);
                    $sheet->setCellValue("G1" . $num, $data[$i]->F1);
                    $sheet->setCellValue("H1" . $num, $H);
                }
            }
        } else {
            $num = $numRec++;
            for ($i = 0; $i < count($data); $i++, $num++) {
                $F = $data[$i]->M . '×' . $data[$i]->N;
                $H = $data[$i]->total - $data[$i]->F1;
                if ($H == 0) {
                    $H = '';
                }
                $sheet->setCellValue("B1" . $num, $data[$i]->name);
                $sheet->setCellValue("C1" . $num, '原板');
                $sheet->setCellValue("E1" . $num, $data[$i]->thickness);
                $sheet->setCellValue("F1" . $num, $F);
                $sheet->setCellValue("G1" . $num, $data[$i]->F1);
                $sheet->setCellValue("H1" . $num, $H);
            }
        }
    }

    public function zip($path, $filename){
        $path = public_path() . '/' . $filename;
        // zip and download file zip
        $file_folder = $path . '/'; // folder to load files
        $folders = glob($file_folder . '*');
        if (extension_loaded('zip')) {
            // Checking files are selected
            $zip = new ZipArchive(); // Load zip library
            $zip_name = $filename . '.zip'; // Zip name
            $zip_folder = $filename . '/';
            if ($zip->open($zip_name, ZIPARCHIVE::CREATE) !== true) {
                $error .= "* Sorry ZIP creation failed at this time";
            }
            foreach ($folders as $folder) {
                $files = glob($folder .'/' . '*');
                $position = strrpos($folder, '/');
                $nameDir = substr($folder, $position + 1);
                // $zip->addEmptyDir($nameDir);
                foreach ($files as $file) {
                    $zip->addFile($zip_folder.$nameDir.'/'.basename($file));
                    continue;
                }
            }

            $isFinished = $zip->close();
            if ($isFinished) {
                // remove folder tmp
                $this->deleteDirectory($path);
            } else {
                throw new Exception("could not close zip file: " . $zip->getStatusString());
            }
        }
    }
    
    private function addDataToFile3and4($data1, $data2, $spreadsheet, $sheetName){
        $spreadsheet->setActiveSheetIndexByName($sheetName);
        $sheet = $spreadsheet->getActiveSheet();
        $num = 4;
        foreach($data1 as $data){
            $F = '910×910';
            $H = $data->total - $data->F1;
            if ($H == 0) {
                $H = '';
            }
            $sheet->setCellValue("B1" . $num, $data->name);
            $sheet->setCellValue("C1" . $num, '加工');
            $sheet->setCellValue("E1" . $num, $data->thickness);
            $sheet->setCellValue("F1" . $num, $F);
            $sheet->setCellValue("G1" . $num, $data->F1);
            $sheet->setCellValue("H1" . $num, $H);
            $sheet->setCellValue("J1" . $num, '坪');
            $num++;
        }
        $indexData2 = count($data2) - 1;
        $F = $data2[$indexData2]->M . '×' . $data2[$indexData2]->N;
        $H = $data2[$indexData2]->total - $data2[$indexData2]->F1;
        if ($H == 0) {
            $H = '';
        }
        $sheet->setCellValue("B1" . $num, $data2[$indexData2]->name);
        $sheet->setCellValue("C1" . $num, '原板');
        $sheet->setCellValue("E1" . $num, $data2[$indexData2]->thickness);
        $sheet->setCellValue("F1" . $num, $F);
        $sheet->setCellValue("G1" . $num, $data2[$indexData2]->F1);
        $sheet->setCellValue("H1" . $num, $H);
        $sheet->setCellValue("J1" . $num, '枚');
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
        $Path = $dirPath;
        if (is_dir($dirPath)) {
            $objects = scandir($dirPath);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    $dirPath = $Path.'/'.$object. '/';
                    $fileArr = scandir($dirPath);
                    foreach ($fileArr as $file) {
                        if ($file != "." && $file != "..") {
                            if (filetype($dirPath . DIRECTORY_SEPARATOR . $file) == "dir")
                            {                       
                                deleteDirectory($dirPath . DIRECTORY_SEPARATOR . $file);
                            } else {
                                unlink($dirPath . DIRECTORY_SEPARATOR . $file);
                            }
                        }
                    }                                
                    reset($fileArr);
                    rmdir($dirPath);
                }
            }
            rmdir($Path);
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
