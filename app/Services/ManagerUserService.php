<?php

namespace App\Services;
use Hash;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ManagerUserService
{

    public static function create(array $data)
    {


        $data = User::create($data);
        return $data;
    }

    public static function update(array $data,User $user)
    {



        $data = User::where('id',$data['id'])->update($data);

        return $data;
    }
    public static function updateById(array $data, $id)
    {

        $data = User::whereId($id)->update($data);
        return $data;
    }


    public static function searchManager(Request $request)
    {

        $data = User::where('name', 'like', "%{$request->search}%")
        ->orwhere('email', 'like', "%{$request->search}%")
        ->orderBy('created_at', 'desc')->paginate(10);
        return $data;

    }


    public static function getById($id)
    {
        $data = User::find($id);
        return $data;
    }

    public static function delete(User $user)
    {
        $data = $user->delete();
        return $data;
    }

    public static function deleteById($id)
    {
        $data = User::whereId($id)->delete();
        return $data;
    }

    public static function datatable()
    {
        // $data = DB::select('select * from users where role = ?', [1]);

        $data = DB::table('users')
        ->select('users.*','location.location')
        ->join('location','location.location_id','=','users.address',)
        ->where('role',1)
        ->orderBy('users.created_at', 'desc')->paginate(10);
       
        return $data;
    }




}
