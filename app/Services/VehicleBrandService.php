<?php

namespace App\Services;

use App\Models\VehicleBrandModal;
use Illuminate\Support\Facades\DB;

class VehicleBrandService
{

    public static function create(array $data)
    {
        $data = VehicleBrandModal::create($data);
        return $data;
    }

    public static function update(array $data,VehicleBrandModal $location)
    {
        $data = $location->update($data);
        return $data;
    }

    public static function updateById(array $data, $id)
    {
        $data = VehicleBrandModal::whereId($id)->update($data);
        return $data;
    }

    public static function getById($id)
    {
        $data = VehicleBrandModal::find($id);
        return $data;
    }

    public static function delete(VehicleBrandModal $location)
    {
        $data = $location->delete();
        return $data;
    }

    public static function deleteLocation($id){
        $result=DB::table('vehicle_brand')->where('id',$id)->delete();
        return $result;
    }




    public static function deleteById($id)
    {
        $data = VehicleBrandModal::whereId($id)->delete();
        return $data;
    }
    public static function where($data)
    {
        $data = VehicleBrandModal::where($data)->get();
        return $data;
    }

    public static function datatable()
    {
        $data = DB::table('vehicle_brand')
         ->join('vehicle', 'vehicle.id', '=', 'vehicle_brand.vehicle_id')
        ->where('vehicle_brand.deleted_at',null)->orderBy('vehicle_brand.created_at', 'asc')->paginate(10);
        return $data;
    }

}
