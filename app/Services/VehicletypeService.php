<?php

namespace App\Services;

use App\Models\VehicletypeModal;
use Illuminate\Support\Facades\DB;

class VehicletypeService
{

    public static function create(array $data)
    {
        $data = VehicletypeModal::create($data);
        return $data;
    }

    public static function update(array $data,VehicletypeModal $location)
    {
        
        $data = $location->update($data);
        
        return $data;
    }

    public static function updateById(array $data, $id)
    {
        $data = VehicletypeModal::whereId($id)->update($data);
        return $data;
    }

    public static function getById($id)
    {
        $data = VehicletypeModal::find($id);
        return $data;
    }

    public static function delete(VehicletypeModal $location)
    {
        $data = $location->delete();
        return $data;
    }




    public static function deleteById($id)
    {
        $data = VehicletypeModal::whereId($id)->delete();
        return $data;
    }
    public static function where($data)
    {
        $data = VehicletypeModal::where($data)->get();
        return $data;
    }

    public static function datatable()
    {
        $data = DB::table('vehicle_type')->where('deleted_at',null)->orderBy('created_at', 'asc')->paginate(10);
        return $data;
    }

    public static function deleteLocation($id){
        $result=DB::table('vehicle_type')->where('id',$id)->delete();
        return $result;
    }

}
