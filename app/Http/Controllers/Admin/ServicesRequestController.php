<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Http\Requests\Admin\ServiceRequest;
use Illuminate\Support\Facades\DB;
use App\Models\ServiceRequestModel;
use App\Models\User;
use App\Models\LocationModel;
use App\Services\ServiceRequestService;
use App\Services\UserService;
use App\Services\FileService;
use App\Services\ManagerLanguageService;
use App\Services\UtilityService;
// use App\Services\UserIntrestService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;



class ServicesRequestController extends Controller
{
    protected $mls, $change_password, $assign_role, $uploads_image_directory;
    protected $index_view, $create_view, $edit_view, $detail_view, $tabe_view, $product_history_view;
    protected $index_route_name, $create_route_name, $detail_route_name, $edit_route_name;
    protected $bookService, $utilityService, $intrestService,$servicerequest;

    public function __construct()
    {

        //Data
        $this->uploads_image_directory = 'files/servicerequests';

        //route

        $this->index_route_name  = 'admin.servicerequests.index';
        $this->create_route_name = 'admin.servicerequests.create';
        $this->detail_route_name = 'admin.servicerequests.show';
        $this->edit_route_name   = 'admin.servicerequests.edit';

        //view files

        $this->index_view = 'admin.servicerequestfolder.index';
        $this->create_view = 'admin.servicerequestfolder.create';
        $this->edit_view = 'admin.servicerequestfolder.edit';


        //service files
        $this->servicerequest = new ServiceRequestService();
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
        $items = $this->servicerequest->datatable();
        if($request->ajax())
        {
            return view('admin.servicerequestfolder.service_table',['servicerequest'=>$items]);
        } else {
            return view('admin.servicerequestfolder.index',['servicerequest'=>$items]);
        }

    }


    public function create()
    {
        $manager=user::where('role','1')->get();
        $company=user::where('role','0')->get();
        $location=LocationModel::get();
        return view($this->create_view, compact('manager','company','location'));
        // return view($this->create_view);
    }

    public function store(ServiceRequest $request)
    {


        $input = $request->except(['_token', 'proengsoft_jsvalidation']);
        // print_r( $input);
        // die;
        if(!empty($input['pictures']))
        {
            $manager_image=$request->file('pictures');
            $picture=FileService::fileUploaderWithoutRequest($manager_image,'servicerequest/image/');
            $input['pictures']= $picture;
    }


        $battle = $this->servicerequest->create($input);
        return redirect()->route($this->index_route_name)->with('success',
        $this->mls->messageLanguage('created', 'servicerequest add', 1));
    }


    public function show(ServiceRequestModel $servicerequest)
    {
        return view($this->detail_view,compact('servicerequest'));
    }


    public function edit(ServiceRequestModel $servicerequest)
    {
        $manager=User::where('role','1')->get();
        $location=LocationModel::get();
        $company=User::where('role','0')->get();
        return view($this->edit_view,compact('servicerequest','manager','company','location'));
    }


    public function update(ServiceRequest $request, ServiceRequestModel $servicerequest)
    {
        $input = $request->except(['_method', '_token', 'proengsoft_jsvalidation']);

        if(!empty($input['pictures']))
        {
            $manager_image=$request->file('pictures');
            $picture=FileService::fileUploaderWithoutRequest($manager_image,'servicerequest/image/');
            $input['pictures']= $picture;
    }
        $this->servicerequest->update($input,$servicerequest);
        return redirect()->route($this->index_route_name)->with('success',
        $this->mls->messageLanguage('updated', 'servicerequest update', 1));
    }

    public function destroy($id)
    {
        $result=UserService::delete_service_request($id);
        return redirect()->back()->withSuccess('Data Delete Successfully!');
    }

}