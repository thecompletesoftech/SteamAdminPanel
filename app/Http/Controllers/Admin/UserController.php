<?php

namespace App\Http\Controllers\Admin;

use App\Exports\Admin\UserExport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRequest;
use App\Models\PasswordReset;
use App\Models\User;
use App\Models\Rating;
use PDF;
use App\Services\FileService;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use App\Services\ManagerLanguageService;
use App\Services\UserService;
use App\Services\UserStatusService;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    protected $mls, $change_password;

    public function __construct()
    {
        //mls is used for manage language content based on keys in messages.php
        $this->mls = new ManagerLanguageService('messages');
        //view files
        $this->change_password = 'admin.admin_profile.change_password';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $items = UserService::datatable();


        if (!empty($request['search'])) {

            if (isset($request->search)) {

                $items = UserService::user_search($request);
                if(count($items)>0){
                    $roles = Role::whereNotIn('name', ['Admin', 'Admin'])->pluck('name', 'name');
                    return view('admin.user.index ',['users'=>$items,'roles'=>$roles,'search'=>$request->search]);
                }else{
                    return redirect()->back()->withSuccess('Search Data Not Found!');
                }
            }


        } else {
            $roles = Role::whereNotIn('name', ['Admin', 'Admin'])->pluck('name', 'name');
            return view('admin.user.index ',['users'=>$items,'roles'=>$roles,'search'=>'']);
        }
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::whereNotIn('name', ['Admin', 'Admin'])->pluck('name', 'name');
        return view('admin.user.create', compact('roles'));
    }




    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $image = FileService::imageUploader($request, 'profile', 'profile/image/');
        if ($image != null) {
            $input['profile'] = $image;
        }
        $user = User::create($input);



        $user->assignRole($request->input('roles'));

        return redirect()->route('admin.users.index')
            ->with('success', $this->mls->messageLanguage('created', 'user', 1));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {

        return view('admin.user.show', compact('user'));
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $roles = Role::whereNotIn('name', ['Admin', 'Admin'])->pluck('name', 'name');
        $userRole = $user->roles->pluck('name', 'name');

        return view('admin.user.edit', compact('user', 'roles', 'userRole'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request,$id)
    {
        $input = $request->all();
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, array('password'));
        }
        if (!empty($input['image'])) {
            $image = FileService::imageUploader($request, 'image', 'profile/image/');
            if ($image != null) {
                $input['image'] = $image;
            }
        } else {
            $input = Arr::except($input, array('image'));
        }

        $user = User::find($id);
        $user->update($input);
        //model_has_roles hasn't its modal file, so we have to use DB.
        DB::table('model_has_roles')->where('model_id', $id)->delete();

        $user->assignRole($request->input('roles'));

        // return redirect()->route('admin.users.index')
        return redirect()->back()
            ->with('success', $this->mls->messageLanguage('updated', 'user', 1));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        // $result=DB::table('users')->where('id', $id)->delete();
        $result=UserService::delete_user($id);

        return redirect()->back()->withSuccess('Data Delete Successfully!');


    }


    // public function createPDF() {
    //     // retreive all records from db
    //     $data = User::all();
    //     // share data to view
    //     view()->share('users',$data);
    //     $pdf = PDF::loadView('pdf_view', $data);
    //     // download PDF file with download method
    //     return $pdf->download('pdf_file.pdf');
    //   }



    public function status($id, $status)
    {

        $status = ($status == 1) ? 0 : 1;
        $result = UserService::update(['is_active' => $status], $id);
        if ($result) {
            return response()->json([
                'status' => 1,
                'message' => $this->mls->messageLanguage('updated', 'status', 1),
                'status_name' => 'success'
            ]);
        } else {
            return response()->json([
                'status' => 0,
                'message' => $this->mls->messageLanguage('not_updated', 'status', 1),
                'status_name' => 'error'
            ]);
        }
    }

    /**
     * Update the language in User.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateLanguage(User $user, $language)
    {
        $result = $user->update(['lang' => $language]);
        session()->put('locale', $language);
        if ($result) {
            return response()->json([
                'status' => 1,
                'message' => $this->mls->onlyNameLanguage('language_updated'),
                'status_name' => 'success'
            ]);
        } else {
            return response()->json([
                'status' => 0,
                'message' => $this->mls->onlyNameLanguage('language_not_updated'),
                'status_name' => 'error'
            ]);
        }
    }

    public function emailapprove($id,$status)
    {

        $update=array('email_status' => $status);
        $result = UserService::status($update, $id);
        return redirect()->back()->withSuccess('Email Status Update Successfully!');


        if ($result) {
            return response()->json([
                'status' => 1,
                'message' => $this->mls->messageLanguage('updated', 'status', 1),
                'status_name' => 'success'
            ]);
        } else {
            return response()->json([
                'status' => 0,
                'message' => $this->mls->messageLanguage('not_updated', 'status', 1),
                'status_name' => 'error'
            ]);
        }
    }


    public function phoneapprove($id,$phonestatus)
    {
        $update=array('phone_status' => $phonestatus);
        $result = UserService::status($update, $id);
        return redirect()->back()->withSuccess('Phone Status Update Successfully!');
        if ($result) {
            return response()->json([
                'status' => 1,
                'message' => $this->mls->messageLanguage('updated', 'status', 1),
                'status_name' => 'success'
            ]);
        } else {
            return response()->json([
                'status' => 0,
                'message' => $this->mls->messageLanguage('not_updated', 'status', 1),
                'status_name' => 'error'
            ]);
        }
    }




    public function popular($id,$popular)
    {
        $update=array('popular' => $popular);
        $result = UserService::status($update, $id);
        return redirect()->back()->withSuccess('Popular Status Update Successfully!');
        if ($result) {
            return response()->json([
                'status' => 1,
                'message' => $this->mls->messageLanguage('updated', 'status', 1),
                'status_name' => 'success'
            ]);
        } else {
            return response()->json([
                'status' => 0,
                'message' => $this->mls->messageLanguage('not_updated', 'status', 1),
                'status_name' => 'error'
            ]);
        }
    }


    public function trending($id,$trending)
    {
        $update=array('trending' => $trending);
        $result = UserService::status($update, $id);
        return redirect()->back()->withSuccess('Trending Status Update Successfully!');
        if ($result) {
            return response()->json([
                'status' => 1,
                'message' => $this->mls->messageLanguage('updated', 'status', 1),
                'status_name' => 'success'
            ]);
        } else {
            return response()->json([
                'status' => 0,
                'message' => $this->mls->messageLanguage('not_updated', 'status', 1),
                'status_name' => 'error'
            ]);
        }
    }





    // public function blockuser($id,$status,$email)
    // {

    //     $update=array('status' => $status);
    //     $result = UserService::status($update, $id);
    //     if($status==1){
    //         $detail=array();
    //         $detail['title']='Consultation';
    //         $detail['body']='Dear Sir/mam Your Account Has Been Temprory Blocked';
    //         UserService::status_update($detail,$email);
    //         return redirect()->back()->withSuccess('Account Blocked Successfully!');
    //     }
    //     else
    //     {
    //         $detail=array();
    //         $detail['title']='Consultation';
    //         $detail['body']='Dear Sir/mam Your Account Has Been Activated';
    //         UserService::status_update($detail,$email);
    //         return redirect()->back()->withSuccess('Account Unblocked !');
    //     }

    //     if ($result) {
    //         return response()->json([
    //             'status' => 1,
    //             'message' => $this->mls->messageLanguage('updated', 'status', 1),
    //             'status_name' => 'success'
    //         ]);
    //     } else {
    //         return response()->json([
    //             'status' => 0,
    //             'message' => $this->mls->messageLanguage('not_updated', 'status', 1),
    //             'status_name' => 'error'
    //         ]);
    //     }
    // }


/**
     * Forget Password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function resetPasswordLoad(Request $request){

        $resetData=DB::table('password_resets')->where('token',$request->token)->first();
       if($resetData){
        if(isset($request->token)){

            $user=User::where('email',$resetData->email)->get();

            return view('admin.email.resetPassword',compact('user'));
        }else{
            return view('admin.email.404');
        }
    }
    else{
        return view('admin.email.404');
    }

    }





    //Password Reset Functionality

    public function resetPassword(Request $request){

        $request->validate([
            'password' => 'required|string|min:6|confirmed'
        ]);
            $user = User::find($request->id);
            $user->password = Hash::make($request->password);
            $user->save();

        PasswordReset::where('email',$user->email)->delete();

            return "<div style='text-align:center;margin-top:20%;background-color:green;color:white;padding-top:10px;padding-bottom:10px'>

            <p style='font-size:50px'> Your password has been reset successfully.</p>
            </div>
            ";

    }

}
