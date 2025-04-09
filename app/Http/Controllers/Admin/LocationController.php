<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Http\Requests\Admin\LocationRequest;
use Illuminate\Support\Facades\DB;
use App\Models\LocationModel;
use App\Services\LocationService;
use App\Services\FileService;
use App\Services\ManagerLanguageService;
use App\Services\UtilityService;
// use App\Services\UserIntrestService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;



class LocationController extends Controller
{
    protected $mls, $change_password, $assign_role, $uploads_image_directory;
    protected $index_view, $create_view, $edit_view, $detail_view, $tabe_view, $product_history_view;
    protected $index_route_name, $create_route_name, $detail_route_name, $edit_route_name;
    protected $bookService, $utilityService, $intrestService;

    public function __construct()
    {

        //Data
        $this->uploads_image_directory = 'files/locations';

        //route

        $this->index_route_name = 'admin.locations.index';
        $this->create_route_name = 'admin.locations.create';
        $this->detail_route_name = 'admin.locations.show';
        $this->edit_route_name = 'admin.locations.edit';

        //view files

        $this->index_view = 'admin.locationfolder.index';
        $this->create_view = 'admin.locationfolder.create';
        $this->edit_view = 'admin.locationfolder.edit';



        //service files
        $this->location = new LocationService();
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
        $items = $this->location->datatable();

        if($request->ajax())
        {
            return view('admin.locationfolder.location_table',['location'=>$items]);
        } else {
            return view('admin.locationfolder.index',['location'=>$items]);
        }

    }


    public function create()
    {
        return view($this->create_view);
    }

    public function store(LocationRequest $request)
    {
        $input = $request->except(['_token', 'proengsoft_jsvalidation']);

        $battle = $this->location->create($input);
        return redirect()->route($this->index_route_name)->with('success',
        $this->mls->messageLanguage('created', 'steam house add', 1));
    }


    public function show(LocationModel $location)
    {
        return view($this->detail_view,compact('location'));
    }


    public function edit(LocationModel $location)
    {
        return view($this->edit_view,compact('location'));
    }


    public function update(LocationRequest $request, LocationModel $location)
    {
        $input = $request->except(['_method', '_token', 'proengsoft_jsvalidation']);



        $this->location->update($input,$location);
        return redirect()->route($this->index_route_name)->with('success',
        $this->mls->messageLanguage('updated', 'Location update', 1));
    }

    public function destroy($id)
    {

        $result=LocationService::deleteLocation($id);
        return redirect()->back()->withSuccess('Location Delete Successfully!');

    }





}
