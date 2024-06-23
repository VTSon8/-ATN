<?php
namespace App\Services;

use App\Models\District;
use App\Models\Province;
use App\Models\Ward;

class LocationService {

    public function getProvinces()
    {
        return Province::get()->toArray();
    }


    public function getDistricts($id)
    {
        return District::where('province_id', $id)->get()->toArray();
    }


    public function getWards($id)
    {
        return Ward::where('district_id', $id)->get()->toArray();
    }

}
