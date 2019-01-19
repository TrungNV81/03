<?php

namespace App\Http\Services;

use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use Validator;
use File;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use App\Http\Repositories\DataInformationRepository;

set_time_limit(600);
ini_set('memory_limit', '4095M');
class UploadFileService
{
    private $dataInformationRepository;

    /**
     * UploadFileService constructor.
     */
    public function __construct()
    {
        $this->dataInformationRepository = new DataInformationRepository();
    }
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

    /**
     * @param $request
     * @return mixed
     */
    public function deleteFile($request)
    {
        $filename = $request->get('filename');
        $dir = public_path() . '/files/'.$filename;
        if (file_exists($dir)) {
            unlink($dir);
        }
        return $filename;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function uploadFileConfig()
    {
        return view('upload_file_form');
    }

    /**
     * @param $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     */
    public function uploadFileConfigSubmit($request)
    {
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        if($request->hasFile('file')) {
            $extension = File::extension($request->file->getClientOriginalName());
            if ($extension == "xlsm") {
                $path = $request->file->getRealPath();
                $spreadsheet = $reader->load($path);
                // get sheet name end
                $sheetname = array_values(array_slice($spreadsheet->getSheetNames(), -1))[0];
                $spreadsheet->setActiveSheetIndexByName($sheetname);
                $sheetData = $spreadsheet->getActiveSheet()->toArray();
                $dataTargetFlg = false;

                // $maxId = $this->dataInformationRepository->maxId('id');
                // if ($maxId == "") {
                //     $maxId = 0;
                // }
                $maxId = 1;
                $subId = 1;
                $this->dataInformationRepository->deleteInfomation($maxId);
                $building = $sheetData[2][11];
                // delete db before insert file mew
                foreach ($sheetData as $key => $value) {
                    $col9 = $value[9];
                    $col11 = $value[11];
                    // sheetname
                    $property_name = $col9 . '・' . $col11 . $building; // J + L + L3 ok - B2
                    $billing_address = $value[27];
                    $billing_name = $value[48]; // AW ok - D2
                    $proud_first = $value[14];
                    $proud_first_name = $value[46];
                    $secondary_store_1 = $value[47];
                    $secondary_store_name_1 = $value[17];
                    $secondary_store_2 = $value[28];
                    $secondary_store_name_2 = $value[19];
                    $factory = $value[20];
                    // 
                    $numCell = $key+1;
                    $valueCellS = $spreadsheet->getActiveSheet()->getCell('S'.$numCell)->getValue();
                    $getDateCellS = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($valueCellS);
                    $delivery_time_1 = date('Y/m/d', $getDateCellS); // S ok - L2

                    // handle delivery time 2 and 3
                    $dates1 = array();
                    $dates7 = array();
                    if ($delivery_time_1 != "") {
                        $dateReplace = str_replace('/', '-', $delivery_time_1);
                        $dateFormat = date('Y-m-d H:i:s', strtotime($dateReplace));
                        $date = new \DateTime($dateFormat);
                        $date1 = $date;
                        while (count($dates1) < 1)
                        {
                            $date1->add(new \DateInterval('P1D'));
                            if ($date1->format('N') < 6)
                                $dates1[]=$date1->format('Y-m-d');
                        }
                        // handle delivery_time_2
                        $delivery_time_2 = $dates1[0]; // M2
                        $date = new \DateTime($dateFormat);
                        $date7 = $date;
                        while (count($dates7) < 7)
                        {
                            $date7->add(new \DateInterval('P1D'));
                            if ($date7->format('N') < 6)
                                $dates7[]=$date7->format('Y-m-d');
                        }
                        // handle delivery_time_3
                        $delivery_time_3 = $dates7[6]; // N2
                    } else {
                        $delivery_time_2 = "";
                        $delivery_time_3 = "";
                    }
                    $on_site_residence = $value[24];
                    $car_model = $value[25];
                    $person_in_charge = $value[13];
                    $street_address = $value[27];
                    $tel = $value[28];
                    $fax = $value[29];
                    $branch_office = $value[48];
                    $responsible = $value[40];
                    $request_no1 = $value[41];
                    $request_no2 = $value[42];

                    if ($col9 == '現場名') {
                        $dataTargetFlg = true;
                    }
                    if ($dataTargetFlg) {
                        $this->dataInformationRepository->insertInfomation($maxId, $subId, $sheetname, $property_name, 
                            $billing_address, $billing_name, $proud_first, $proud_first_name, $secondary_store_1,
                            $secondary_store_name_1, $secondary_store_2, $secondary_store_name_2, $factory, $delivery_time_1,
                            $delivery_time_2, $delivery_time_3, $on_site_residence, $car_model, $person_in_charge, $street_address,
                            $tel, $fax, $branch_office, $responsible, $request_no1, $request_no2);
                        $subId ++;
                    }
                }
            }
        }
        return 'Insert data information success!';
    }
}
