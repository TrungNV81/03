<?php

namespace App\Http\Repositories;

use App\Http\Models\DataInformationModel;

class DataInformationRepository extends BaseRepository
{
    /**
     * @var DataInformationModel
     */
    protected $dataInformationModel;

    /**
     * HistoryFileRepository constructor.
     */
    public function __construct()
    {
        $this->dataInformationModel = new DataInformationModel();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function maxId($id)
    {
        return $this->dataInformationModel->max($id);
    }

    /**
     * @param $idFile
     * @param $fileName
     * @param $dateNew
     * @param $category
     * @return mixed
     */
    public function insertInfomation($maxId, $subId, $sheetname, $property_name,
        $billing_address, $billing_name, $proud_first, $proud_first_name, $secondary_store_1,
        $secondary_store_name_1, $secondary_store_2, $secondary_store_name_2, $factory, $delivery_time_1,
        $delivery_time_2, $delivery_time_3, $on_site_residence, $car_model, $person_in_charge, $street_address,
        $tel, $fax, $branch_office, $responsible, $request_no1, $request_no2)
    {
        return $this->dataInformationModel->insert([
            'id' => $maxId, 'sub_id' => $subId, 'sheet_name' => $sheetname, 'property_name' => $property_name, 'billing_address' => $billing_address,
            'billing_address' => $billing_address, 'billing_name' => $billing_name, 'proud_first' => $proud_first,
            'proud_first_name' => $proud_first_name, 'proud_first_name' => $secondary_store_1, 'secondary_store_name_1' => $secondary_store_name_1,
            'secondary_store_2' => $secondary_store_2, 'secondary_store_name_2' => $secondary_store_name_2, 'factory' => $factory,
            'delivery_time_1' => $delivery_time_1, 'delivery_time_2' => $delivery_time_2, 'delivery_time_3' => $delivery_time_3,
            'on_site_residence' => $on_site_residence, 'car_model' => $car_model, 'person_in_charge' => $person_in_charge,
            'street_address' => $street_address, 'tel' => $tel, 'fax' => $fax, 'branch_office' => $branch_office, 'responsible' => $responsible,
            'request_no1' => $request_no1, 'request_no2' => $request_no2
        ]);
    }
}
