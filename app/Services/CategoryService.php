<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Support\Facades\DB;

class CategoryService
{

    public static function create(array $data)
    {
        $data = Category::create($data);
        return $data;
    }

    public static function update(array $data,Category $location)
    {
        
        $data = $location->update($data);
        
        return $data;
    }

    public static function updateById(array $data, $id)
    {
        $data = Category::whereId($id)->update($data);
        return $data;
    }

    public static function getById($id)
    {
        $data = Category::find($id);
        return $data;
    }

    public static function delete(Category $location)
    {
        $data = $location->delete();
        return $data;
    }

    public static function deleteLocation($id){
        $result=DB::table('category')->where('id',$id)->delete();
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
        $data = DB::table('category')->orderBy('created_at', 'asc')->paginate(10);
        return $data;
    }

}
