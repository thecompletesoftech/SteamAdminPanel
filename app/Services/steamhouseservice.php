<?php

namespace App\Services;

use App\Models\SteamHouseModel;
use Illuminate\Support\Facades\DB;

class steamhouseservice
{

    public static function create(array $data)
    {
        $data = SteamHouseModel::create($data);
        return $data;
    }

    public static function update(array $data,SteamHouseModel $steamhouse)
    {
        $data = $steamhouse->update($data);
        return $data;
    }

    public static function updateById(array $data, $id)
    {
        $data = SteamHouseModel::whereId($id)->update($data);
        return $data;
    }

    public static function getById($id)
    {
        $data = SteamHouseModel::find($id);
        return $data;
    }

    public static function delete(SteamHouseModel $steamhouse)
    {
        $data = $steamhouse->delete();
        return $data;
    }

    public static function deleteById($id)
    {
        $data = SteamHouseModel::whereId($id)->delete();
        return $data;
    }

    public static function datatable()
    {
        $data = DB::table('steamhouse')->orderBy('created_at', 'asc')->get();
        return $data;
    }

}
