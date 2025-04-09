<?php

namespace App\Services;

use App\Models\User;
use App\Models\Rating;
use App\Models\SetAvailability;
use App\Mail\SendEmail;
use App\Models\Advisorie;
use App\Models\BookAnAppointment;
use App\Models\Notification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserService
{
    /**
     * Create the specified resource.
     *
     * @param Request $request
     * @return User
     */
    public static function create(array $data)
    {
        $data = User::create($data);
        return $data;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return bool
     */
    public static function updateById(array $data, $user_id)
    {
        $data = User::where('id', $user_id)->update($data);
        return $data;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Array $data
     * @param  App\Models\User  $user
     * @return bool
     */
    public static function update(array $data, User $user)
    {
        $data = $user->update($data);
        return $data;
    }

    /**
     * Get the specified resource in storage.
     *
     * @param int $id
     * @return  App\Models\User  $user
     */
    public static function getById($id)
    {
        $data = User::with('roles')->find($id);
        return $data;
    }
    public static function getNameById($id)
    {
        $data = User::where('id',$id)->first(['name']);

        return $data->name;

    }



    /**
     * Get the specified resource in storage.
     *
     * @return  App\Models\User  $data
     */
    public static function getAdminUser()
    {

        $data = User::find(1);
        return $data;
    }

    /**
     * Get data by $parameters.
     *
     * @param Array $parameters
     * @return Model
     */
    public static function getByParameters($parameters)
    {
        $data = User::query();
        foreach ($parameters as $parameter) {
            $data = $data->where($parameter['column_name'], $parameter['value']);
        }
        return $data;
    }

    /**
     * Delete data by user.
     *
     * @param User $user
     * @return bool
     */
    public static function delete(User $user)
    {
        $data = $user->delete();
        return $data;
    }


    public static function datatable()
    {
        $data = User::orderBy('created_at', 'desc')->whereNotIn("name", ['name'])->paginate(10);
        return $data;
    }




    /**
     * update status.
     *
     * @param Array $data
     * @param int $id
     * @return bool
     */
    public static function status(array $data, $id)
    {

        $data = User::where('id', $id)->update($data);
        return $data;
    }

    /**
     * update Last Login details.
     *
     * @param int $id
     * @param Request $request = null
     * @return bool
     */
    public static function updateLastLogin($id, $request = null)
    {
        $input = [
            'last_login' => Carbon::now()
        ];

        if ($request) {
            $input = [
                'device_id' => $request->get('device_id'),
                'device_type' => $request->get('device_type'),
                'is_online' => 1
            ];
        }
        $data = User::where('id', $id)->update($input);
        return $data;
    }

    /**
     * Get user with relations
     *
     * @param Int $id
     * @param Array $relations
     * @return \App\Models\User
     */
    public static function getByIdWithRelations($id, $relations = [])
    {
        $data = User::where('id', $id);
        foreach ($relations as $relation) {
            $data = $data->with($relation);
        }
        $data = $data->first();
        return $data;
    }


    public static function user_search(Request $request)
    {


        $data = User::
        where('name', 'like', "%{$request->search}%")
        ->orwhere('email', 'like', "%{$request->search}%")
        ->orderBy('created_at', 'desc')->whereNotIn("name", ['Admin'])->paginate(10);
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


    public static function update_password(User $user, String $password,)
    {

        $data = $user->update([
            'password' => Hash::make($password)

        ]);
        return $data;
    }

    public static function getPushNotify($user_id)
    {
        $data = User::where('id', $user_id)
            ->select('push_notify')
            ->first();
        return $data;
    }

 /**
     * Send Mail
     *
     * @param Int $id
     * @param Array $relations

     */
    public static function send_forgetmail(array $detail, $request)
    {
        try{
        $details = [
            'title' => $detail['title'],
            'body' => $detail['body'],
            'url'=>$detail['url'],
        ];

        $data=Mail::to($request)->send(new \App\Mail\ForgetEmail($details));
        return $data;
    }
    catch(\Exception $e){
            return;
        }

    }




    public static function delete_user($id){
        $result=DB::table('users')->where('id',$id)->delete();
        $result1=DB::table('users')->where('manager_id',$id)->delete();
        $result2=DB::table('service_request')->where('manger_id',$id)->delete();
        $result3=DB::table('managerfeedback')->where('manager_feedback_id',$id)->delete();
        return $result.$result1.$result2.$result3;
    }


    public static function delete_employee($id){
        $result=DB::table('users')->where('id',$id)->delete();
        $result2=DB::table('service_request')->where('emp_id',$id)->delete();
        $result3=DB::table('employee_feedback')->where('employee_id',$id)->delete();
        return $result.$result2.$result3;
    }



    public static function delete_service_request($id){
        $result=DB::table('service_request')->where('id',$id)->delete();
        $result1=DB::table('managerfeedback')->where('Service_request_id',$id)->delete();
        $result2=DB::table('customerfeedback')->where('Service_request_id',$id)->delete();
        $result3=DB::table('employee_feedback')->where('Service_request_id',$id)->delete();
        return $result.$result1.$result2.$result3;
    }


    /**
     * Get data by $parameters.
     *
     * @param Array $parameters
     * @return Model
     */
    public static function getByRoleId($role_id)
    {
        $data = Role::where('id', $role_id)->first()->users()->get();
        return $data;
    }

    /**
     * Get data for download Report from storage.
     *
     * @return User with all its Client data
     */
    public static function downloaduserReport()
    {
        $data = User::whereHas("roles", function ($q) {
            $q->whereNotIn("name", ['Admin']);
        })->select(
            'id',
            'name',
            'email',
            'mobile_no',
            DB::raw("(CASE WHEN (is_active = 1) THEN 'Active' ELSE 'Inactive' END) as status"),
            DB::raw("(DATE_FORMAT(created_at,'%d-%M-%Y')) as created_date"),
            DB::raw("(DATE_FORMAT(updated_at,'%d-%M-%Y')) as updated_date"),
        )->orderBy('created_at', 'desc');
        return $data;
    }



    public static function delete_company($id){
        $result=DB::table('users')->where('id',$id)->delete();
        $result1=DB::table('service_request')->where('user_id',$id)->delete();
        return $result.$result1;
    }

    /**
     * Delete the old user image
     */
    public static function deleteOldImage(User $user)
    {
        FileService::removeImage($user, 'image', 'files/users');
        $result = $user->delete();
        return $result;
    }

}
