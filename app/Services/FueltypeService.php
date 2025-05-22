<?php

namespace App\Services;

use App\Models\FueltypeModal;
use Illuminate\Support\Facades\DB;

class FueltypeService
{

    public static function create(array $data)
    {
        $data = FueltypeModal::create($data);
        return $data;
    }

    public static function update(array $data,FueltypeModal $location)
    {
        
        $data = $location->update($data);
        
        return $data;
    }

    public static function updateById(array $data, $id)
    {
        $data = FueltypeModal::whereId($id)->update($data);
        return $data;
    }

    public static function getById($id)
    {
        $data = FueltypeModal::find($id);
        return $data;
    }

    public static function delete(FueltypeModal $location)
    {
        $data = $location->delete();
        return $data;
    }




    public static function deleteById($id)
    {
        $data = FueltypeModal::whereId($id)->delete();
        return $data;
    }
    public static function where($data)
    {
        $data = FueltypeModal::where($data)->get();
        return $data;
    }

    public static function datatable()
    {
        $data = DB::table('fuel_type')->where('deleted_at',null)->orderBy('created_at', 'asc')->paginate(10);
        return $data;
    }

    public static function deleteLocation($id){
        $result=DB::table('fuel_type')->where('id',$id)->delete();
        return $result;
    }

}
