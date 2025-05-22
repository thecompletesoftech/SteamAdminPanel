<?php

namespace App\Services;

use App\Models\Services;
use Illuminate\Support\Facades\DB;

class LocationService
{

    public static function create(array $data)
    {
        $data = Services::create($data);
        return $data;
    }

    public static function update(array $data,Services $location)
    {
        $data = $location->update($data);
        return $data;
    }

    public static function updateById(array $data, $id)
    {
        $data = Services::whereId($id)->update($data);
        return $data;
    }

    public static function getById($id)
    {
        $data = Services::find($id);
        return $data;
    }

    public static function delete(Services $location)
    {
        $data = $location->delete();
        return $data;
    }

    public static function deleteLocation($id){
        $result=DB::table('services')->where('id',$id)->delete();
        return $result;
    }




    public static function deleteById($id)
    {
        $data = Services::whereId($id)->delete();
        return $data;
    }
    public static function where($data)
    {
        $data = Services::where($data)->get();
        return $data;
    }

    public static function datatable()
    {
        $data = DB::table('services')->orderBy('created_at', 'asc')->paginate(10);
        return $data;
    }

    

    public static function getServicesSubData()
    {
        $data = Services::get();

        foreach($data as $d){
            $d->label=DB::table('sub_services')->select('sub_service_name','sub_id')->where('id',$d->id)->first();
            $d->option=DB::table('sub_category_data')->where('sub_services_id',$d->label->sub_id)->get();
        }
        return $data;
        
    }



}
