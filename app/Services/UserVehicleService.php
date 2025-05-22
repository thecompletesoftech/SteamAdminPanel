<?php

namespace App\Services;

use App\Models\UserVehicleModal;
use Illuminate\Support\Facades\DB;

class UserVehicleService
{

    public static function create(array $data)
    {
        $data = UserVehicleModal::create($data);
        return $data;
    }

    public static function update(array $data,UserVehicleModal $location)
    {
        
        $data = $location->update($data);
        
        return $data;
    }

    public static function updateById(array $data, $id)
    {
        $data = UserVehicleModal::whereId($id)->update($data);
        return $data;
    }

    public static function getById($id)
    {
        $data = UserVehicleModal::find($id);
        return $data;
    }

    public static function delete(UserVehicleModal $location)
    {
        $data = $location->delete();
        return $data;
    }




    public static function deleteById($id)
    {
        $data = UserVehicleModal::whereId($id)->delete();
        return $data;
    }
    public static function where($data)
    {
        $data = UserVehicleModal::where($data)->get();
        return $data;
    }

    public static function datatable()
    {
        $data = DB::table('user_vehicle')->where('deleted_at',null)->orderBy('created_at', 'asc')->paginate(10);
        return $data;
    }

    public static function deleteLocation($id){
        $result=DB::table('user_vehicle')->where('id',$id)->delete();
        return $result;
    }

    public static function Listvehicle($id){
        $result=DB::table('user_vehicle')
         ->join('vehicle_type', 'vehicle_type.id', '=', 'user_vehicle.vehicle_type_id')
         ->join('vehicle', 'vehicle.id', '=', 'user_vehicle.manufacturer_id')
         ->join('vehicle_brand', 'vehicle_brand.id', '=', 'user_vehicle.brand_id')
         ->join('fuel_type', 'fuel_type.id', '=', 'user_vehicle.fuel_type_id')
         ->join('users', 'users.id', '=', 'user_vehicle.user_id')
        ->select('user_vehicle.default_vehicle','user_vehicle.id','vehicle_name','vehicle_image','brand_name','brand_image','fuel_type','vehicle_type.vehicle_type as vehicleType')
        ->where("user_vehicle.user_id",$id)->get();
        return $result;
    }

}
