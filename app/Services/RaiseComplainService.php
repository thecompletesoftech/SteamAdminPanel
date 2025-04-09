<?php

namespace App\Services;
use Hash;
use App\Models\RaiseComplainModel;
use Illuminate\Support\Facades\DB;

class RaiseComplainService
{

    public static function create(array $data)
    {

        $data = RaiseComplainModel::create($data);
        return $data;

    }

    public static function update(array $data,RaiseComplainModel $raisecomplain)
    {
        $data = $raisecomplain->update($data);
        return $data;
    }

    public static function updateById(array $data, $id)
    {
        $data = RaiseComplainModel::whereId($id)->update($data);
        return $data;
    }

    public static function getById($id)
    {
        $data = RaiseComplainModel::find($id);
        return $data;
    }

    public static function delete(RaiseComplainModel $raisecomplain)
    {
        $data = $raisecomplain->delete();
        return $data;
    }

    public static function deleteById($id)
    {
        $data = RaiseComplainModel::whereId($id)->delete();
        return $data;
    }

    public static function datatable()
    {
        $data = DB::table('raise_complain')->orderBy('created_at', 'asc')->get();
        // $user = DB::table('users')->where('name', 'John')->first();
        // $data = DB::select('select * from raise_complain where id = id');
        // $data = DB::table('raise_complain')->where('id', 'id')->first();
        // $data = DB::table('raise_complain')->whereIn('id', 'user_id')->get();
        // DB::table('raise_complain')
        //     ->whereExists(function($query)
        //     {
        //         $query->select(DB::raw(id))
        //               ->from('orders')
        //               ->whereRaw('orders.id =id');
        //     })
        //     ->get();
        // $data = RaiseComplainModel::where('id', $id)->get();
        return $data;
    }

}
