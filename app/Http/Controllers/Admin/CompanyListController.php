<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CompanyEditRequest;
use App\Models\User;
use App\Services\CompanyListService;
use App\Services\FileService;
use App\Services\ManagerLanguageService;
use App\Services\UserService;
use App\Services\UtilityService;
use Illuminate\Http\Request;
// use App\Services\UserIntrestService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CompanyListController extends Controller
{
    protected $mls, $change_password, $assign_role, $uploads_image_directory;
    protected $index_view, $create_view, $edit_view, $detail_view, $tabe_view, $product_history_view;
    protected $index_route_name, $create_route_name, $detail_route_name, $edit_route_name;
    protected $bookService, $utilityService, $intrestService,$user;

    public function __construct()
    {

        //Data
        $this->uploads_image_directory = 'files/companylists';
        //route
        $this->index_route_name = 'admin.companylists.index';
        $this->create_route_name = 'admin.companylists.create';
        $this->detail_route_name = 'admin.companylists.show';
        $this->edit_route_name = 'admin.companylists.edit';

        //view files
        $this->index_view = 'admin.companylistfolder.index';
        $this->create_view = 'admin.companylistfolder.create';
        $this->edit_view = 'admin.companylistfolder.edit';

        $this->detail_view = 'admin.companylistfolder.details';
        $this->tabe_view = 'admin.companylistfolder.profile';

        //service files
        $this->user = new CompanyListService();
        // $this->intrestService = new UserIntrestService();
        $this->utilityService = new UtilityService();

        //mls is used for manage language content based on keys in messages.php
        $this->mls = new ManagerLanguageService('messages');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $items = $this->user->datatable();

        if (!empty($request['search'])) {

            $items = UserService::company_search($request);

            if (count($items) > 0) {
                return view('admin.companylistfolder.index', ['user' => $items, 'search' => $request->search]);
            }
            return redirect()->back()->withSuccess('Search Data Not Found');
        }
        return view('admin.companylistfolder.index', ['user' => $items, 'search' => $request->search]);

    }

    public function create()
    {

        $location = DB::table('location')->get();
        $manager = User::where('role', '1')->get();

        return view($this->create_view, compact('manager', 'location'));

    }

    public function store(Request $request)
    {

        $input = $request->except(['_token', 'proengsoft_jsvalidation']);
        if (!empty($input['image'])) {
            $company_image = $request->file('image');
            $picture = FileService::fileUploaderWithoutRequest($company_image, 'company/image/');
            $input['image'] = $picture;
        }
        $haspassword = Hash::make($request->password);
        $input['password'] = $haspassword;

        $username = DB::table('users')->where('username', $input['username'])->get();

        if (count($username) > 0) {
            return redirect()->back()->with('success', 'Username Allready Exist');
        }

        $battle = $this->user->create($input);
        return redirect()->route($this->index_route_name)->with('success',
            $this->mls->messageLanguage('created', 'company', 1));

    }

    public function show(User $user)
    {

        return view($this->detail_view, compact('user'));
    }

    public function edit($id)
    {

        $user = User::where('id', $id)->first();
        $manager = User::where('role', '1')->get();
        $location = DB::table('location')->get();
        return view($this->edit_view, compact('manager', 'user', 'location'));

    }

    public function update(Request $request, User $user)
    {

        $input = $request->except(['_method', '_token', 'proengsoft_jsvalidation']);
       
        $id = $input['id'];
        if (!empty($input['image'])) {
            $company_image = $request->file('image');
            $picture = FileService::fileUploaderWithoutRequest($company_image, 'company/image/');
            $input['image'] = $picture;
        }   
        $details=User::where('id',$id)->first();
        if($details->password===$input['password']) {
            $input['password'] = $details->password;
            // $input['c_password'] = Hash::make($request->c_password);
        }else{
                 $input['password'] = Hash::make($request->password);
        }
        // print_r("New Password");
            // die;
        // if (!empty($input['username'])) {

        //     $newuser = User::where('username', $request->username)->get();
        //     if (count($newuser) > 0) {
        //         return redirect()->back()->withSuccess('Company Username Allready Exists!');
        //     }

        // }

        $this->user->update($input, $user);
        return redirect()->route($this->index_route_name)->with('success', $this->mls->messageLanguage('updated', 'company', 1));

        // return redirect()->route($this->index_route_name)->with('success',$this->mls->messageLanguage('updated', 'User update', 1));
    }

    public function destroy($id)
    {

        $result = UserService::delete_company($id);

        return redirect()->back()->withSuccess('Data Delete Successfully!');

    }

}
