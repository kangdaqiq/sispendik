<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AddressController extends Controller
{
    public function getProvinces()
    {
        $provinces = DB::connection('sqlite_wilayah')->table('provinces')
            ->select('prov_id as id', 'prov_name as name')
            ->orderBy('prov_name', 'asc')
            ->get();

        return response()->json($provinces);
    }

    public function getRegencies($provId)
    {
        $regencies = DB::connection('sqlite_wilayah')->table('city')
            ->select('city_id as id', 'city_name as name')
            ->where('prov_id', $provId)
            ->orderBy('city_name', 'asc')
            ->get();

        return response()->json($regencies);
    }

    public function getDistricts($cityId)
    {
        $districts = DB::connection('sqlite_wilayah')->table('district')
            ->select('dis_id as id', 'dis_name as name')
            ->where('city_id', $cityId)
            ->orderBy('dis_name', 'asc')
            ->get();

        return response()->json($districts);
    }

    public function getVillages($disId)
    {
        $villages = DB::connection('sqlite_wilayah')->table('subdistrict')
            ->leftJoin('postal_code', 'subdistrict.subdis_id', '=', 'postal_code.subdis_id')
            ->select('subdistrict.subdis_id as id', 'subdistrict.subdis_name as name', 'postal_code.postal_code')
            ->where('subdistrict.dis_id', $disId)
            ->orderBy('subdistrict.subdis_name', 'asc')
            ->get();

        return response()->json($villages);
    }
}
