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
     * @param $id
     * @return mixed
     */
    public function deleteInfomation($id)
    {
        return $this->dataInformationModel->where('id', '=', $id)->delete();
    }

    /**
     * @param $maxId
     * @param $subId
     * @param $sheetname
     * @param $property_name
     * @param $billing_address
     * @param $billing_name
     * @param $proud_first
     * @param $proud_first_name
     * @param $secondary_store_1
     * @param $secondary_store_name_1
     * @param $secondary_store_2
     * @param $secondary_store_name_2
     * @param $factory
     * @param $delivery_time_1
     * @param $delivery_time_2
     * @param $delivery_time_3
     * @param $on_site_residence
     * @param $car_model
     * @param $person_in_charge
     * @param $street_address
     * @param $tel
     * @param $fax
     * @param $branch_office
     * @param $responsible
     * @param $request_no1
     * @param $request_no2
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
            'proud_first_name' => $proud_first_name, 'secondary_store_1' => $secondary_store_1, 'secondary_store_name_1' => $secondary_store_name_1,
            'secondary_store_2' => $secondary_store_2, 'secondary_store_name_2' => $secondary_store_name_2, 'factory' => $factory,
            'delivery_time_1' => $delivery_time_1, 'delivery_time_2' => $delivery_time_2, 'delivery_time_3' => $delivery_time_3,
            'on_site_residence' => $on_site_residence, 'car_model' => $car_model, 'person_in_charge' => $person_in_charge,
            'street_address' => $street_address, 'tel' => $tel, 'fax' => $fax, 'branch_office' => $branch_office, 'responsible' => $responsible,
            'request_no1' => $request_no1, 'request_no2' => $request_no2
        ]);
    }

    /**
     * @param $property_name
     * @return mixed
     */
    public function getDataInformation($property_name)
    {
        return $this->dataInformationModel->where([
            ['property_name', '=', $property_name],
        ])
        ->get();
    }

    /**
     * @param $property_name
     * @return mixed
     */
    public function getDataPdfLabel($property_name)
    {
        return $this->dataInformationModel->select('billing_name', 'property_name', 'request_no1', 'request_no2', 'delivery_time_1')
        ->where([
            ['property_name', '=', $property_name],
        ])
        ->get();
    }
}
