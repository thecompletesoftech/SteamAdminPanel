<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Http\Requests\Admin\CustomerTrackingRequest;
use Illuminate\Support\Facades\DB;
use App\Models\TrackingModel;
use App\Services\CustomerTrackingService;
use App\Services\FileService;
use App\Services\ManagerLanguageService;
use App\Services\UtilityService;
// use App\Services\UserIntrestService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;



class CustomertrackingController extends Controller
{
    protected $mls, $change_password, $assign_role, $uploads_image_directory;
    protected $index_view, $create_view, $edit_view, $detail_view, $tabe_view, $product_history_view;
    protected $index_route_name, $create_route_name, $detail_route_name, $edit_route_name;
    protected $bookService, $utilityService, $intrestService;

    public function __construct()
    {

        //Data
        $this->uploads_image_directory = 'files/customertrackings';

        //route

        $this->index_route_name  = 'admin.customertrackings.index';
        $this->create_route_name = 'admin.customertrackings.create';
        $this->detail_route_name = 'admin.customertrackings.show';
        $this->edit_route_name   = 'admin.customertrackings.edit';

        //view files

        $this->index_view  = 'admin.customertrackingfolder.index';
        $this->create_view = 'admin.customertrackingfolder.create';
        $this->edit_view   = 'admin.customertrackingfolder.edit';



        //service files
        $this->customertrack = new CustomerTrackingService();
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

        $items = $this->customertrack->datatable();
        if($request->ajax())
        {
            return view('admin.customertrackingfolder.tracking_table',['customertrack'=>$items]);
        } else {
            return view('admin.customertrackingfolder.index',['customertrack'=>$items]);
        }

    }


    public function create()
    {

        return view($this->create_view);
    }

    public function store(CustomerTrackingRequest $request)
    {

        $input = $request->except(['_token', 'proengsoft_jsvalidation']);

        $battle = $this->customertrack->create($input);
        return redirect()->route($this->index_route_name)->with('success',
        $this->mls->messageLanguage('created', 'Tracking Address add', 1));
    }


    public function show(TrackingModel $customertrack)
    {
        return view($this->detail_view,compact('customertrack'));
    }


    public function edit(TrackingModel $customertrack)
    {

        return view($this->edit_view,compact('customertrack'));
    }


    public function update(CustomerTrackingRequest $request, TrackingModel $customertrack)
    {
        $input = $request->except(['_method', '_token', 'proengsoft_jsvalidation']);



        $this->customertrack->update($input,$customertrack);
        return redirect()->route($this->index_route_name)->with('success',
        $this->mls->messageLanguage('updated', 'customerdata update', 1));
    }

    public function destroy($id)
    {

        $result=DB::table('customertrack')->where('track_id', $id)->delete();

        return redirect()->back()->withSuccess('Data Delete Successfully!');

        if ($result) {
            return response()->json([
                'status' => 1,
                'title' => $this->mls->onlyNameLanguage('deleted_title'),
                'message' => $this->mls->onlyNameLanguage('customerdata delete'),
                'status_name' => 'success'
            ]);
        } else {
            return response()->json([
                'status' => 0,
                'title' => $this->mls->onlyNameLanguage('deleted_title'),
                'message' => $this->mls->onlyNameLanguage('customerdata delete'),
                'status_name' => 'error'
            ]);
        }

    }





}
