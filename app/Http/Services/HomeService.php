<?php

namespace App\Http\Services;

use App\Http\Repositories\HistoryFileRepository;
use App\Http\Repositories\CsvDataImportRepository;
use App\Http\Repositories\CsvFileImportRepository;
use App\Http\Repositories\LineChartFileRepository;
use App\Http\Repositories\DetailsDataImportRepository;
use App\Http\Repositories\TemplateEmailRepository;
use App\Http\Repositories\ManageMailRepository;
use App\Http\Repositories\HistorySendMailRepository;
use App\Mail\SendEmail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use PDF;
use File;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use ZipArchive;
use App\Http\Common;
use App\Http\Constant;

class HomeService
{
    private $historyFileRepository;
    private $csvDataImportRepository;
    private $csvFileImportRepository;
    private $lineChartFileRepository;
    private $detailsDataImportRepository;
    private $templateEmailRepository;
    private $manageMailRepository;
    private $historySendMailRepository;

    /**
     * HomeService constructor.
     */
    public function __construct()
    {
        $this->historyFileRepository = new HistoryFileRepository();
        $this->csvDataImportRepository = new CsvDataImportRepository();
        $this->csvFileImportRepository = new CsvFileImportRepository();
        $this->lineChartFileRepository = new LineChartFileRepository();
        $this->detailsDataImportRepository = new DetailsDataImportRepository();
        $this->templateEmailRepository = new TemplateEmailRepository();
        $this->manageMailRepository = new ManageMailRepository();
        $this->historySendMailRepository = new HistorySendMailRepository();
    }

    /**
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function handle()
    {
        $dir = public_path() . '/files/';
        $files = glob($dir . '*');
        foreach ($files as &$file) {
            // get day of week
            $dateNew = date('Y-m-d H:i:s');
            // $dateNew = date('2018-12-24');
            $dayOfWeek = date("l", strtotime($dateNew));

            $strrpos = strrpos($file, '/');
            $filename = substr($file, $strrpos + 1);
            $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));

            $idFile = $this->historyFileRepository->maxIdFile('id');
            if ($idFile == "") {
                $idFile = 0;
            }
            $idFile += 1;
            $idFile = $idFile;

            if ($extension == 'csv') {
                $importMaxId = $this->csvDataImportRepository->importMaxId('id');
                if ($importMaxId == "") {
                    $importMaxId = 0;
                }
                $importMaxId += 1;
                $importId = $importMaxId;
                $subId = 1;
                // call function add data file import success
                $this->lineChartImportFile($dayOfWeek, 'success');
                $strrpos = strrpos($file, '/');
                $substr = substr($file, $strrpos + 1);
                $filename = explode('.', $substr);
                $fileReader = fopen($file, 'r');
                try {
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
                        $this->csvDataImportRepository->insertCsvDataImport($importId, $subId, $colA, $colB, $colC, $colD,
                            $colE, $colF, $colG, $colH, $colI, $colJ, $colK, $colL, $colM, $colN, $colO, $colP, $colQ);
                        $subId++;
                    }
                    fclose($fileReader);
                }
                catch (\Exception $e) {
                    $this->historyFileRepository->insertHistoryFile($idFile,  basename($file), $dateNew, 'fail');
                    fclose($fileReader);
                    unlink($dir . $substr);
                    continue;
                }
                
                // insert data into table csv_file_import
                $this->csvFileImportRepository->insertFile($importId, basename($file));
                // insert data into table history_file
                $this->historyFileRepository->insertHistoryFile($idFile,  basename($file), $dateNew, 'success');

                // call function add data file import success
                $this->lineChartImportFile($dayOfWeek, 'success');
                $strrpos = strrpos($file, '/');
                $substr = substr($file, $strrpos + 1);
                $filename = explode('.', $substr);
                // Create folder temp
                $path = public_path() . '/' . $filename[0];
                mkdir($path, 0777, true);
                // Create folder Excel
                $pathExcel = $path . '/EXCEL';
                mkdir($pathExcel, 0777, true);

                $this->exportFile1($importId, $pathExcel, $filename[0]);
                $this->exportFile2($importId, $pathExcel, $filename[0]);
                $this->zip($path, $filename[0], $substr, $dir);
                $this->sendMail($path, $filename[0], $importId, $dateNew);
                $this->deleteFileZip($filename[0]);
            } else {
                // insert data into table history_file
                $this->historyFileRepository->insertHistoryFile($idFile,  basename($file), $dateNew, 'fail');
                // call function add data file import fail
                $this->lineChartImportFile($dayOfWeek, 'fail');
            }
        }
    }

    /**
     * @param $dayOfWeek
     * @param $category
     */
    public function lineChartImportFile($dayOfWeek, $category)
    {
        // select total file import in day
        $line_chart_file = $this->lineChartFileRepository->getDay($dayOfWeek);
        if ($dayOfWeek == 'Monday' && ($line_chart_file[0]->total > 0)) {
            // select total file import in Tuesday
            $total_file = $this->lineChartFileRepository->getDay('Tuesday');
            if ($total_file[0]->total > 0) {
                $day = array(
                    "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday",
                );
                foreach ($day as $key => $value) {
                    // reset line_chart_file
                    $this->lineChartFileRepository->resetLineChartFile($value);
                }
                // select record empty
                $line_chart_file = $this->lineChartFileRepository->getDay($dayOfWeek);
            }
        }
        $line_chart_file_total = $line_chart_file[0]->total + 1;
        $line_chart_file_category = $line_chart_file[0]->$category + 1;
        // update line_chart_file
        $this->lineChartFileRepository->updateLineChartFile($dayOfWeek, $line_chart_file_total, $category, $line_chart_file_category);
    }

    /**
     * file 指示書
     * @param $importId
     * @param $pathExcel
     * @param $filename
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function exportFile1($importId, $pathExcel, $filename)
    {
        // Create folder PDF
        $pathPDF = public_path() . '/' . $filename . '/PDF';
        mkdir($pathPDF, 0777, true);

        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load(public_path() . "/template/Excel/template01.xlsx");
        //add data sheet 1-1
        $dataImport1_1 = $this->csvDataImportRepository->getDataCsv($importId, 'カベ', '1階', '−', '○', 'N DESC');

        $this->addDataToFile1($dataImport1_1, '先行1階2階', 3, $spreadsheet, 2395);
        $this->exportPDF($pathPDF, $dataImport1_1, '_１階先行壁', $filename, 'filepdf1');
        //add data sheet 1-2
        $dataImport1_2 = $this->csvDataImportRepository->getDataCsv($importId, 'カベ', '2階', '−', '○', 'N DESC');

        $this->addDataToFile1($dataImport1_2, '先行1階2階', 506, $spreadsheet, 2395);
        $this->exportPDF($pathPDF, $dataImport1_2, '_２階先行壁', $filename, 'filepdf1');
        // add data sheet 2
        $dataImport2 = $this->csvDataImportRepository->getDataCsv($importId, 'テンジョウ', '1階', '−', '−', 'K ASC, N DESC');

        $this->addDataToFile1($dataImport2, '天井1階', 3, $spreadsheet, 1820);
        $this->exportPDF($pathPDF, $dataImport2, '_１階天井', $filename, 'filepdf1');
        // add data sheet 3
        $dataImport3 = $this->csvDataImportRepository->getDataCsv($importId, 'テンジョウ', '2階', '−', '−', 'K ASC, N DESC');

        $this->addDataToFile1($dataImport3, '天井2階', 3, $spreadsheet, 1820);
        $this->exportPDF($pathPDF, $dataImport3, '_２階天井 ', $filename, 'filepdf1');
        // add data sheet 4-1
        $dataImport4_1 = $this->csvDataImportRepository->getDataCsv($importId, 'カベ', '1階', '−', '−', 'K ASC, N DESC');

        $this->addDataToFile1($dataImport4_1, '壁1階2階', 3, $spreadsheet, 2395);
        $this->exportPDF($pathPDF, $dataImport4_1, '_１階壁', $filename, 'filepdf1');
        // add data sheet 4-2
        $dataImport4_2 = $this->csvDataImportRepository->getDataCsv($importId, 'カベ', '2階', '−', '−', 'K ASC, N DESC');

        $this->addDataToFile1($dataImport4_2, '壁1階2階', 506, $spreadsheet, 2395);
        $this->exportPDF($pathPDF, $dataImport4_2, '_２階壁', $filename, 'filepdf1');
        $this->exportPDF($pathPDF, '', '_ラベル', $filename, 'filepdf2');
        $spreadsheet->setActiveSheetIndex(0);

        // Save file to folder
        // $filename = $dataImport1_1[0]->Q;
        $writer = new Xlsx($spreadsheet);
        $saveFile = $pathExcel . '/' . $filename . '_加工明細.xlsx';
        $writer->save($saveFile);
    }

    /**
     * file 指示書
     * @param $dataImport
     * @param $sheetName
     * @param $index
     * @param $spreadsheet
     * @param $tmpN
     */
    public function addDataToFile1($dataImport, $sheetName, $index, $spreadsheet, $tmpN)
    {
        $startCell = $index;
        $importId = $dataImport[0]->id;
        $floor = $dataImport[0]->B;
        $thickness = $dataImport[0]->L;
        $name = $dataImport[0]->K;
        $indexCell = $index;
        $total = 0;
        $totalCellJ = 0;
        // get max_sub_id in table details_data_import
        $maxSubId = $this->detailsDataImportRepository->getMaxId('sub_id');
        if ($maxSubId == "") {
            $maxSubId = 0;
        }
        $maxSubId += 1;

        $cellPos = array(
            "B", "C", "D", "E", "G", "H", "I", "J", "K", "M", "N", "O", "P", "Q", "R",
        );
        $spreadsheet->setActiveSheetIndexByName($sheetName);
        $sheet = $spreadsheet->getActiveSheet();
        $numCellR = 0;
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

                // insert data into table details_data_import
                $this->detailsDataImportRepository->insertDetailsData($importId,  $maxSubId, $sheetName, $floor, $name, $thickness, $totalx);

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
            foreach ($cellPos as $key => $value) {
                $num = (string) $index;
                $cellpos = $cellPos[$key] . $num;
                if ($key == 14) {
                    $numCellR += $cellValue[14];
                }
                $sheet->setCellValue($cellpos, $cellValue[$key]);
            }
            $index++;
        }
        $endCell = 0;
        if ($startCell == 3) {
            $endCell = 502;
        }

        if ($startCell == 506) {
            $endCell = 1005;
        }

        $this->closeEmptyExcel($index, $endCell, $spreadsheet);
        if ($sheetName == '天井1階' || $sheetName == '壁1階2階') {
            $sheet->setCellValue('S' . ((string) ($indexCell - 1)), $total);
        }
        if ($sheetName == '先行1階2階' || $sheetName == '壁1階2階') {
            if ($floor == "1階") {
                session(['numCellR503' => $numCellR]);
                $sheet->setCellValue('R503', $numCellR);
            }
            if ($floor == "2階") {
                $numCellR1008 = session('numCellR503') + $numCellR;
                $sheet->setCellValue('R1006', $numCellR);
                $sheet->setCellValue('R1008', $numCellR1008);
            }
        }
        if ($sheetName == '天井1階' || $sheetName == '天井2階') {
            $sheet->setCellValue('R503', $numCellR);
        }
        // insert data into table details_data_import
        $this->detailsDataImportRepository->insertDetailsData($importId,  $maxSubId, $sheetName, $floor, $name, $thickness, $totalx);
        $maxSubId++;
        $this->detailsDataImportRepository->insertDetailsData($importId,  $maxSubId, $sheetName, $floor, '総切断m', '0', ceil($totalCellJ));
    }

    /**
     * @param $pathPDF
     * @param $dataPDF
     * @param $file_extension
     * @param $filename
     * @param $templatePDF
     */
    public function exportPDF($pathPDF, $dataPDF, $file_extension, $filename, $templatePDF)
    {
        $pdf = PDF::loadView($templatePDF, compact('dataPDF', 'filename'));
        $pdf->setPaper('a4', 'landscape');
        $saveFile = $pathPDF . '/' . $filename . $file_extension . '.pdf';
        $pdf->save($saveFile);
    }

    /**
     * file 指示書
     * @param $importId
     * @param $pathExcel
     * @param $filename
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function exportFile2($importId, $pathExcel, $filename)
    {
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load(public_path() . "/template/Excel/template02.xlsx");

        // sheet 情報
        $cellPos = array(
            "B12", "C12", "B13", "C13", "B14", "C14",
        );

        $dataImport1 = $this->detailsDataImportRepository->getDataInformation($importId, '0');
        $spreadsheet->setActiveSheetIndexByName('情報');
        $sheet = $spreadsheet->getActiveSheet();
        foreach ($cellPos as $key => $value) {
            $cellpos = $cellPos[$key];
            $sheet->setCellValue($cellpos, $dataImport1[$key]->total);
        }
        // end sheet 情報

        // sheet 工場1便
        $dataImport2 = $this->detailsDataImportRepository->getDataFactory($importId, '先行1階2階', '0');
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
        $dataImport4 = $this->detailsDataImportRepository->getDataFactory($importId, '壁1階2階', '0');
        $numRec = 0;
        $this->addDataToFile2($dataImport4, $spreadsheet, '工場3便', 1, $numRec);
        // end sheet 工場3便

        // sheet 営業1便
        $sumG_Floor1 = "";
        $sumG_Floor1 = DB::table('csv_data_import')
            ->select(DB::raw('sum(G) as total'))
            ->where([
                ['id', '=', $importId],
                ['A', '=', 'カベ'],
                ['B', '=', '1階'],
                ['I', '=', '先行ボード'],
                ['K', '=', 'マーク付きベベル'],
                ['M', '=', '910'],
                ['N', '=', '2395'],
                ['O', '=', '○'],
            ]);
        $dataImport5 = DB::table('csv_data_import')
            ->select('K as name', 'L as thickness', 'Q', 'M', 'N', DB::raw('(' . $sumG_Floor1->toSql() . ') as F1'), DB::raw('sum(G) as total'))
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
            ->mergeBindings($sumG_Floor1)
            ->groupBy('K')
            ->get();

        $numRec = count($dataImport2);
        $this->addDataToFile2($dataImport2, $spreadsheet, '営業1便', 1, $numRec);
        $this->addDataToFile2($dataImport5, $spreadsheet, '営業1便', 2, $numRec);
        // end sheet 営業1便

        // sheet 営業2便
        $sumG_Floor1 = "";
        $sumG_Floor1 = DB::table('csv_data_import')
            ->select(DB::raw('sum(G) as total'))
            ->where([
                ['id', '=', $importId],
                ['A', '=', 'テンジョウ'],
                ['B', '=', '1階'],
                ['K', '=', 'べべル'],
                ['M', '=', '910'],
                ['N', '=', '1820'],
                ['O', '=', '○'],
            ]);
        $dataImport6 = DB::table('csv_data_import')
            ->select('K as name', 'L as thickness', 'M', 'N', DB::raw('(' . $sumG_Floor1->toSql() . ') as F1'), DB::raw('sum(G) as total'))
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
            ->mergeBindings($sumG_Floor1)
            ->groupBy('K')
            ->get();

        $numRec = count($dataImport3);
        $this->addDataToFile2($dataImport3, $spreadsheet, '営業2便', 1, $numRec);
        $this->addDataToFile2($dataImport6, $spreadsheet, '営業2便', 2, $numRec);
        // end sheet 営業2便

        // sheet 営業3便
        $sumG_Floor1 = "";
        $sumG_Floor1 = DB::table('csv_data_import')
            ->select(DB::raw('sum(G) as total'))
            ->where([
                ['id', '=', $importId],
                ['A', '=', 'カベ'],
                ['B', '=', '1階'],
                ['K', '=', 'マーク付きベベル'],
                ['M', '=', '910'],
                ['N', '=', '2395'],
                ['O', '=', '○'],
            ]);

        $dataImport7 = DB::table('csv_data_import')
            ->select('K as name', 'L as thickness', 'M', 'N', DB::raw('(' . $sumG_Floor1->toSql() . ') as F1'), DB::raw('sum(G) as total'))
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
            ->mergeBindings($sumG_Floor1)
            ->groupBy('K')
            ->get();

        $sumG_Floor1_1 = "";
        $sumG_Floor1_1 = DB::table('csv_data_import')
            ->select(DB::raw('sum(G) as total'))
            ->where([
                ['id', '=', $importId],
                ['A', '=', 'カベ'],
                ['B', '=', '1階'],
                ['D', '=', 'コーナーボード'],
                ['M', '=', '65'],
                ['N', '=', '2395'],
                ['O', '=', '○'],
            ]);

        $dataImport8 = DB::table('csv_data_import')
            ->select('K as name', 'L as thickness', 'M', 'N', DB::raw('(' . $sumG_Floor1_1->toSql() . ') as F1'), DB::raw('sum(G) as total'))
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
            ->mergeBindings($sumG_Floor1_1)
            ->groupBy('K')
            ->get();

        $numRec = count($dataImport4);
        $this->addDataToFile2($dataImport4, $spreadsheet, '営業3便', 1, $numRec);
        $this->addDataToFile2($dataImport7, $spreadsheet, '営業3便', 2, $numRec);
        $numRec += count($dataImport7);
        $this->addDataToFile2($dataImport8, $spreadsheet, '営業3便', 3, $numRec);
        // end sheet 営業3便

        $spreadsheet->setActiveSheetIndex(0);
        // Save file to folder
        $writer = new Xlsx($spreadsheet);
        $saveFile = $pathExcel . '/' . $filename . '_指示書.xlsx';
        // $saveFile = $path . '/' . $importId . '2.xlsx';
        $writer->save($saveFile);

        $spreadsheet1 = \PhpOffice\PhpSpreadsheet\IOFactory::load(public_path() . "/template/Excel/template03.xlsx");
        $this->addDataToFile3and4($dataImport2, $dataImport5, $spreadsheet1, '受注');
        $spreadsheet1->setActiveSheetIndex(0);
        // Save file to folder
        $writer1 = new Xlsx($spreadsheet1);
        $saveFile = $pathExcel . '/' . $filename . '_受注1便.xlsx';
        $writer1->save($saveFile);

        $spreadsheet2 = \PhpOffice\PhpSpreadsheet\IOFactory::load(public_path() . "/template/Excel/template03.xlsx");
        $this->addDataToFile3and4($dataImport3, $dataImport6, $spreadsheet2, '受注');
        $spreadsheet2->setActiveSheetIndex(0);
        // Save file to folder
        $writer2 = new Xlsx($spreadsheet2);
        $saveFile = $pathExcel . '/' . $filename . '_受注2便.xlsx';
        $writer2->save($saveFile);

        $spreadsheet3 = \PhpOffice\PhpSpreadsheet\IOFactory::load(public_path() . "/template/Excel/template03.xlsx");
        $this->addDataToFile5($dataImport4, $dataImport7, $dataImport8, $spreadsheet3, '受注');
        $spreadsheet3->setActiveSheetIndex(0);
        // Save file to folder
        $writer3 = new Xlsx($spreadsheet3);
        $saveFile = $pathExcel . '/' . $filename . '_受注3便.xlsx';
        $writer3->save($saveFile);

    }

    /**
     * @param $data1
     * @param $data2
     * @param $data3
     * @param $spreadsheet
     * @param $sheetName
     */
    private function addDataToFile5($data1, $data2, $data3, $spreadsheet, $sheetName)
    {
        $spreadsheet->setActiveSheetIndexByName($sheetName);
        $sheet = $spreadsheet->getActiveSheet();
        $num = 4;
        foreach ($data1 as $data) {
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
        foreach ($data2 as $data) {
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
        foreach ($data3 as $data) {
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
        $num += 10;
        $this->closeEmptyExcel($num, 21, $spreadsheet);
    }

    /**
     * file 指示書
     * @param $data
     * @param $spreadsheet
     * @param $sheetName
     * @param $numRow
     * @param $numRec
     */
    private function addDataToFile2($data, $spreadsheet, $sheetName, $numRow, $numRec)
    {
        $flag;
        $num = 0;
        $spreadsheet->setActiveSheetIndexByName($sheetName);
        $sheet = $spreadsheet->getActiveSheet();
        if ($numRow == 1) {
            if ($sheetName == '営業1便' || $sheetName == '営業2便' || $sheetName == '営業3便') {
                $num = 0;
                $flag = 0;
            } else {
                $num = 2;
                $flag = 1;
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
            if ($flag == 1 && $sheetName != '営業3便') {
                $num += 10;
                $this->closeEmptyExcel($num, 15, $spreadsheet);
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
            if ($numRow == 3 && $sheetName == '営業3便') {
                $num += 10;
                $this->closeEmptyExcel($num, 16, $spreadsheet);
            }
            if ($sheetName != '営業3便') {
                $num += 10;
                $this->closeEmptyExcel($num, 16, $spreadsheet);
            }
        }
    }

    /**
     * @param $startCell
     * @param $endCell
     * @param $spreadsheet
     */
    private function closeEmptyExcel($startCell, $endCell, $spreadsheet)
    {
        for ($i = $startCell; $i <= $endCell; $i++) {
            $spreadsheet->getActiveSheet()->getRowDimension($i)->setVisible(false);
        }
    }

    /**
     * @param $path
     * @param $filename
     * @param $fileCsv
     * @param $dir
     */
    public function zip($path, $filename, $fileCsv, $dir)
    {
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
                $files = glob($folder . '/' . '*');
                $position = strrpos($folder, '/');
                $nameDir = substr($folder, $position + 1);
                foreach ($files as $file) {
                    $position = strrpos($file, '/');
                    $nameFile = substr($file, $position + 1);
                    $zip->addFile($zip_folder . $nameDir . '/' . $nameFile);
                    continue;
                }
            }

            $isFinished = $zip->close();
            if ($isFinished) {
                // remove folder tmp
                $this->deleteDirectory($path);
                // delete file in folder files
                unlink($dir . $fileCsv);
            } else {
                throw new Exception("could not close zip file: " . $zip->getStatusString());
            }
        }
    }

    /**
     * @param $data1
     * @param $data2
     * @param $spreadsheet
     * @param $sheetName
     */
    private function addDataToFile3and4($data1, $data2, $spreadsheet, $sheetName)
    {
        $spreadsheet->setActiveSheetIndexByName($sheetName);
        $sheet = $spreadsheet->getActiveSheet();
        $num = 4;
        foreach ($data1 as $data) {
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
        $num += 11;
        $this->closeEmptyExcel($num++, 21, $spreadsheet);
    }

    /**
     * @param $number
     * @return float
     */
    private function roundNumber($number)
    {
        $val2 = round($number, 2);
        if ($val2 < $number) {
            $val2 += 0.01;
        }
        return $val2;
    }

    /**
     * @param $dirPath
     */
    public function deleteDirectory($dirPath)
    {
        $Path = $dirPath;
        if (is_dir($dirPath)) {
            $objects = scandir($dirPath);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    $dirPath = $Path . '/' . $object . '/';
                    $fileArr = scandir($dirPath);
                    foreach ($fileArr as $file) {
                        if ($file != "." && $file != "..") {
                            if (filetype($dirPath . DIRECTORY_SEPARATOR . $file) == "dir") {
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

    /**
     * @param $path
     * @param $filename
     * @param $importId
     * @param $dateNew
     */
    public function sendMail($path, $filename, $importId, $dateNew)
    {
        $templateEmail = $this->templateEmailRepository->getTemplateEmail();
        $objDemo = new \stdClass();

        $drawing_name = $this->csvDataImportRepository->getDrawing($importId);
        $drawing_name = $drawing_name[0]->Q;
        $subject = str_replace('$drawing_name', $drawing_name, $templateEmail[0]->subject);
        $body = str_replace('$drawing_name', $drawing_name, $templateEmail[0]->body);
        $objDemo->subject = $subject;
        $objDemo->body = $body;
        $objDemo->sender = $templateEmail[0]->sender;
        $objDemo->receiver = $templateEmail[0]->receiver;
        $objDemo->path = $path;
        $objDemo->filename = $filename;
        $emailArr = $this->manageMailRepository->getArrMail();

        $idMail = $this->historySendMailRepository->getMaxIdMail('id');
        if ($idMail == "") {
            $idMail = 0;
        }
        $idMail += 1;
        foreach ($emailArr as $sendTo) {
            try {
                Mail::to($sendTo->email)->send(new SendEmail($objDemo));
                $this->historySendMailRepository->insertHistorySendMail($idMail, $filename . '.zip', $sendTo->email, $dateNew, 'success');
            } catch (\Exception $e) {
                $this->historySendMailRepository->insertHistorySendMail($idMail, $filename . '.zip', $sendTo->email, $dateNew, 'fail');
            }
            $idMail++;
        }
    }

    /**
     * @param $importId
     */
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
