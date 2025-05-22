<?php

namespace App\Services;

use App\Models\VehicleDetailsModal;
use Illuminate\Support\Facades\DB;

class VehicleDetailsService
{

    public static function create(array $data)
    {
        $data = VehicleDetailsModal::create($data);
        return $data;
    }

    public static function update(array $data,VehicleDetailsModal $location)
    {
        $data = $location->update($data);
        return $data;
    }

    public static function updateById(array $data, $id)
    {
        $data = VehicleDetailsModal::whereId($id)->update($data);
        return $data;
    }

    public static function getById($id)
    {
        $data = VehicleDetailsModal::find($id);
        return $data;
    }

    public static function delete(VehicleDetailsModal $location)
    {
        $data = $location->delete();
        return $data;
    }

    public static function deleteLocation($id){
        $result=DB::table('vehicle')->where('id',$id)->delete();
        return $result;
    }




    public static function deleteById($id)
    {
        $data = VehicleDetailsModal::whereId($id)->delete();
        return $data;
    }
    public static function where($data)
    {
        $data = VehicleDetailsModal::where($data)->get();
        return $data;
    }

    public static function datatable()
    {
        $data = DB::table('vehicle')
        ->select('*','vehicle_type.vehicle_type as VehicleType')
         ->join('vehicle_type', 'vehicle.vehicle_type', '=', 'vehicle_type.id')
        
        ->where('vehicle.deleted_at',null)->orderBy('vehicle.created_at', 'asc')->paginate(10);
        return $data;
    }

}
