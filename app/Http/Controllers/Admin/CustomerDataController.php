<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Http\Requests\Admin\CustomerDataRequest;
use Illuminate\Support\Facades\DB;
use App\Models\CustomerDataModel;
use App\Models\User;
use App\Services\CustomerDataService;
use App\Services\FileService;
use App\Services\ManagerLanguageService;
use App\Services\UtilityService;
// use App\Services\UserIntrestService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;



class CustomerDataController extends Controller
{
    protected $mls, $change_password, $assign_role, $uploads_image_directory;
    protected $index_view, $create_view, $edit_view, $detail_view, $tabe_view, $product_history_view;
    protected $index_route_name, $create_route_name, $detail_route_name, $edit_route_name;
    protected $bookService, $utilityService, $intrestService;

    public function __construct()
    {

        //Data
        $this->uploads_image_directory = 'files/customerdatas';

        //route

        $this->index_route_name  = 'admin.customerdatas.index';
        $this->create_route_name = 'admin.customerdatas.create';
        $this->detail_route_name = 'admin.customerdatas.show';
        $this->edit_route_name   = 'admin.customerdatas.edit';

        //view files

        $this->index_view  = 'admin.customerdatafolder.index';
        $this->create_view = 'admin.customerdatafolder.create';
        $this->edit_view   = 'admin.customerdatafolder.edit';



        //service files
        $this->customerdata = new CustomerDataService();
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
        $items = $this->customerdata->datatable();
        if($request->ajax())
        {
            return view('admin.customerdatafolder.customerdata_table',['customerdata'=>$items]);
        } else {
            return view('admin.customerdatafolder.index',['customerdata'=>$items]);
        }

    }


    public function create()
    {
        return view($this->create_view);

    }

    public function store(CustomerDataRequest $request)
    {
        $input = $request->except(['_token', 'proengsoft_jsvalidation']);

        $battle = $this->customerdata->create($input);
        return redirect()->route($this->index_route_name)->with('success',
        $this->mls->messageLanguage('created', 'customerdata add', 1));
    }


    public function show(CustomerDataModel $customerdata)
    {
        return view($this->detail_view,compact('customerdata'));
    }


    public function edit(CustomerDataModel $customerdata)
    {

        return view($this->edit_view,compact('customerdata'));
    }


    public function update(CustomerDataRequest $request, CustomerDataModel $customerdata)
    {
        $input = $request->except(['_method', '_token', 'proengsoft_jsvalidation']);



        $this->customerdata->update($input,$customerdata);
        return redirect()->route($this->index_route_name)->with('success',
        $this->mls->messageLanguage('updated', 'customerdata update', 1));
    }

    public function destroy($id)
    {

        $result=DB::table('customerdata')->where('id', $id)->delete();

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
