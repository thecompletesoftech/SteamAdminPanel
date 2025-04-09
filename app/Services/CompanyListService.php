<?php

namespace App\Services;
use Hash;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class CompanyListService
{

    public static function create(array $data)
    {
        $data = User::create($data);
        return $data;
    }

    public static function update(array $data, User $user)
    {

        $data = User::where('id',$data['id'])->update($data);


        return $data;
    }

    public static function updateById(array $data, $id)
    {
        $data = User::whereId($id)->update($data);

        return $data;
    }


    public static function company_search(Request $request)
    {


        $data = User::
        where('name', 'like', "%{$request->search}%")
        ->orwhere('email', 'like', "%{$request->search}%")
        ->orderBy('created_at', 'desc')->whereNotIn("name", ['Admin'])->paginate(10);
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
        // $data = DB::select('select * from users where role = ?', [0]);
        // $data = DB::table('users')
        // ->select('users.*','users.id as id')
        // // ->join('location','location.location_id','=','users.id')
        // ->orderBy('users.created_at', 'asc')->where('role','0')->get();


        $data = DB::table('users')
        ->select('users.*','users.id as id','location.location as address',)
        ->join('location','location.location_id','=','users.address')
        ->orderBy('users.created_at', 'desc')->where('role','0')->paginate(10);
        return $data;
    }

}
