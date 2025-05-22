<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductService
{

    public static function create(array $data)
    {
        $data = Product::create($data);
        return $data;
    }

    public static function update(array $data,Product $location)
    {
        $data = $location->update($data);
        return $data;
    }

    public static function updateById(array $data, $id)
    {
        $data = Product::whereId($id)->update($data);
        return $data;
    }

    public static function getById($id)
    {
        $data = Product::find($id);
        return $data;
    }

    public static function delete(Product $location)
    {
        $data = $location->delete();
        return $data;
    }

    public static function deleteLocation($id){
        $result=DB::table('Product')->where('id',$id)->delete();
        return $result;
    }




    public static function deleteById($id)
    {
        $data = Product::whereId($id)->delete();
        return $data;
    }
    public static function where($data)
    {
        $data = Product::where($data)->get();
        return $data;
    }

    public static function datatable()
    {
        $data = DB::table('product')
            ->join('category', 'category.id', '=', 'product.product_category')
        ->orderBy('product.created_at', 'asc')->paginate(10);
        return $data;
    }

}
