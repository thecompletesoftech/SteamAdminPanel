<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Http\Requests\Admin\LocationRequest;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use App\Models\LocationModel;
use App\Models\Services;
use App\Services\VehicletypeService;
use App\Services\FileService;
use App\Services\ManagerLanguageService;
use App\Services\UtilityService;
use Aws\Api\Service;
// use App\Services\UserIntrestService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;



class VehicleTypeController extends Controller
{
    protected $mls, $change_password, $assign_role, $uploads_image_directory;
    protected $index_view, $create_view, $edit_view, $detail_view, $tabe_view, $product_history_view;
    protected $index_route_name, $create_route_name, $detail_route_name, $edit_route_name;
    protected $bookService, $utilityService, $intrestService;

    public function __construct()
    {

        //Data
        $this->uploads_image_directory = 'files/vehicletype';

        //route

        $this->index_route_name = 'admin.vehicletype.index';
        $this->create_route_name = 'admin.vehicletype.create';
        $this->detail_route_name = 'admin.vehicletype.show';
        $this->edit_route_name = 'admin.vehicletype.edit';

        //view files

        $this->index_view = 'admin.vehicletype.index';
        $this->create_view = 'admin.vehicletype.create';
        $this->edit_view = 'admin.vehicletype.edit';



        //service files
        $this->service = new VehicletypeService();
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
        $items = $this->service->datatable();

        if($request->ajax())
        {
            return view('admin.vehicletype.location_table',['location'=>$items]);
        } else {
            return view('admin.vehicletype.index',['location'=>$items]);
        }

    }


    public function create()
    {
        return view($this->create_view);
    }

    public function store(Request $request)
    {
           
        $input = $request->except(['_token', 'proengsoft_jsvalidation']);
        
        $image = $request->file('type_image');
        $filename = time() . $image->getClientOriginalName();
        $destinationPath = public_path($this->uploads_image_directory);
        $image->move($destinationPath, $filename);
        $input['type_image'] = $this->uploads_image_directory . "/" . $filename;

        $battle = $this->service->create($input);
        return redirect()->route($this->index_route_name)->with('success',
        $this->mls->messageLanguage('created', 'Services Has Been Added', 1));

    }


    public function show(Services $location)
    {
        return view($this->detail_view,compact('location'));
    }


    public function edit($id)
    {
        echo $location = $this->service->getById($id);
        return view($this->edit_view,compact('location'));
    }


    public function update(Request $request,  $location)
    {
        $input = $request->except(['_method', '_token', 'proengsoft_jsvalidation']);

        $image = $request->file('type_image');
        $filename = time() . $image->getClientOriginalName();
        $destinationPath = public_path($this->uploads_image_directory);
        $image->move($destinationPath, $filename);
        $input['type_image'] = $this->uploads_image_directory . "/" . $filename;


        $this->service->updateById($input,$location);
        return redirect()->route($this->index_route_name)->with('success',
        $this->mls->messageLanguage('updated', 'Category update', 1));
    }

    public function destroy($id)
    {

        $result=$this->service->deleteLocation($id);
        return redirect()->back()->withSuccess('Location Delete Successfully!');

    }

    public function status($id,$status)
    {

        $result=$this->service->updateById(['status'=>$status],$id);
        return redirect()->back()->withSuccess('Location Delete Successfully!');

    }





}
