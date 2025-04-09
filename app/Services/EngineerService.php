<?php

namespace App\Services;
use Hash;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class EngineerService
{

    public static function create(array $data)
    {

        return User::create([
            'fullname' => $data['fullname'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'about' => $data['about'],
            'password' => Hash::make($data['password']),
            'c_password' => Hash::make($data['c_password']),
            'role' => $data['role'],
          ]);
    }

    public static function update(array $data,User $user)
    {
        $data = $user->update($data);
        return $data;
    }

    public static function updateById(array $data, $id)
    {
        $data = User::whereId($id)->update($data);
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
        // $data = DB::select('select * from users where user_type = ?', [1]);
        $data = DB::select('select * from users where role = :role', ['role' => 2]);
        // $data = DB::table('users')->orderBy('created_at', 'asc')->get();
        return $data;
    }

}
