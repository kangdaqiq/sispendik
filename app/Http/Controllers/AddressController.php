<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AddressController extends Controller
{
    public function getProvinces()
    {
        $provinces = DB::connection('sqlite_wilayah')->table('ms_kode_pos_wilayah')
            ->select('prov_id as id', 'prov_name as name')
            ->distinct()
            ->orderBy('prov_name', 'asc')
            ->get();

        return response()->json($provinces);
    }

    public function getRegencies($provId)
    {
        $regencies = DB::connection('sqlite_wilayah')->table('ms_kode_pos_wilayah')
            ->select('city_id as id', 'city_name as name')
            ->where('prov_id', $provId)
            ->distinct()
            ->orderBy('city_name', 'asc')
            ->get();

        return response()->json($regencies);
    }

    public function getDistricts($cityId)
    {
        $districts = DB::connection('sqlite_wilayah')->table('ms_kode_pos_wilayah')
            ->select('dis_id as id', 'dis_name as name')
            ->where('city_id', $cityId)
            ->distinct()
            ->orderBy('dis_name', 'asc')
            ->get();

        return response()->json($districts);
    }

    public function getVillages($disId)
    {
        $villages = DB::connection('sqlite_wilayah')->table('ms_kode_pos_wilayah')
            ->select('subdis_id as id', 'subdis_name as name', 'postal_code')
            ->where('dis_id', $disId)
            ->distinct()
            ->orderBy('subdis_name', 'asc')
            ->get();

        return response()->json($villages);
    }
}
