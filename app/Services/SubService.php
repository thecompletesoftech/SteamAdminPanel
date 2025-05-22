<?php

namespace App\Services;

use App\Models\Sub_services;
use Illuminate\Support\Facades\DB;

class SubService
{

    public static function create(array $data)
    {
        $data = Sub_services::create($data);
        return $data;
    }

    public static function update(array $data,Sub_services $location)
    {
        $data = $location->update($data);
        return $data;
    }

    public static function updateById(array $data, $id)
    {
        $data = Sub_services::where($id)->update($data);
        return $data;
    }

    public static function getById($id)
    {
        $data = Sub_services::find($id);
        return $data;
    }

    public static function delete(Sub_services $location)
    {
        $data = $location->delete();
        return $data;
    }

    public static function deleteLocation($id){
        $result=DB::table('sub_services')->where('sub_id',$id)->delete();
        return $result;
    }




    public static function deleteById($id)
    {
        $data = Sub_services::whereId($id)->delete();
        return $data;
    }

    public static function datatable()
    {
        $data =
        
         DB::table('sub_services')
        ->join('services', 'services.id', '=', 'sub_services.id')
   
        ->get()
        ->paginate(20);
        
        
        return $data;
    }

}
