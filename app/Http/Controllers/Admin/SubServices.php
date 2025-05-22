<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Http\Requests\Admin\LocationRequest;
use Illuminate\Support\Facades\DB;
use App\Models\LocationModel;
use App\Models\Sub_services;
use App\Models\Sub_category_data;
use App\Models\Category;
use App\Services\LocationService;
use App\Services\SubService;
use App\Services\FileService;
use App\Services\ManagerLanguageService;
use App\Services\UtilityService;
use Aws\Api\Service;
// use App\Services\UserIntrestService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;



class SubServices extends Controller
{
    protected $mls, $change_password, $assign_role, $uploads_image_directory;
    protected $index_view, $create_view, $edit_view, $detail_view, $tabe_view, $product_history_view;
    protected $index_route_name, $create_route_name, $detail_route_name, $edit_route_name;
    protected $bookService, $utilityService, $intrestService;

    public function __construct()
    {

        //Data
        $this->uploads_image_directory = 'files/subservices';

        //route

        $this->index_route_name = 'admin.subservices.index';
        $this->create_route_name = 'admin.subservices.create';
        $this->detail_route_name = 'admin.subservices.show';
        $this->edit_route_name = 'admin.subservices.edit';

        //view files

        $this->index_view = 'admin.Subservices.index';
        $this->create_view = 'admin.Subservices.create';
        $this->edit_view = 'admin.Subservices.edit';



        //service files
        $this->services = new SubService();
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
        $items = $this->services->datatable();

        foreach ($items as $d) {


            $sub_category = DB::select("SELECT sub_service_data FROM `sub_category_data` where sub_services_id = $d->sub_id");
            $link_with_product = DB::select("SELECT link_with_product FROM `sub_category_data` where sub_services_id = $d->sub_id");
            $link_with_category = DB::select("SELECT cat_name FROM sub_category_data inner join category on category.id=sub_category_data.product_category where link_with_product=0 and sub_services_id = $d->sub_id");
            $v = json_encode($sub_category);
            $v1 = json_encode($link_with_product);
            $v2 = json_encode($link_with_category);
            //    $data[$i]['sub_category']=$v;
            $d->sub_services_data = $v;
            $d->link_with_product = $v1;
            $d->link_with_category = $v2;
        }
        // print_r($items);die;

        if ($request->ajax()) {
            return view('admin.Subservices.location_table', ['location' => $items]);
        } else {
            return view($this->index_view, ['location' => $items]);
        }
    }


    public function create()
    {
        $items = LocationService::where(["status" => 0, 'deleted_at' => null]);
        $Category = Category::where(["status" => 0, 'deleted_at' => null])->get();

        return view($this->create_view, ['data' => $items, 'Category' => $Category]);
    }

    public function store(Request $request)
    {

        $input = $request->except(['_token', 'proengsoft_jsvalidation']);


        $battle = $this->services->create($input);

        // echo count($request->sub_service_data);die;
        $i = 0;
        // echo $battle->sub_id;die;
        $id = $battle->sub_id;
        foreach ($request->sub_service_data as $data) {
            $sub_data = [
                'sub_services_id' => $id,
                'sub_service_data' => $data,
                'link_with_product' => $request['link_with_product' . $i],
                'product_category' => $request['link_with_product' . $i] == 0 ? $request['product_category' . $i] : 0,
            ];

            // print_r( $sub_data);
            $battle = Sub_category_data::create($sub_data);
            $i++;
        }
        return redirect()->route($this->index_route_name)->with(
            'success',
            $this->mls->messageLanguage('created', 'Services Has Been Added', 1)
        );
    }


    public function show(Sub_services $location)
    {
        return view($this->detail_view, compact('location'));
    }


    public function edit($id)
    {
         $sub_services = $this->services->getById($id);
         $data = LocationService::where(["status" => 0, 'deleted_at' => null]);
            $Category = Category::where(["status" => 0, 'deleted_at' => null])->get();

            $sub_category_data=Sub_category_data::where(['deleted_at'=>null,'sub_services_id'=>$id])->get();

        return view($this->edit_view, compact('data','Category','sub_services','sub_category_data'));
    }


    public function update(Request $request,$id)
    {
        $input = $request->except(['_method', '_token', 'proengsoft_jsvalidation']);


        $update=['sub_service_name'=>$request->sub_service_name,
    'id'=>$request->id];
        $this->services->updateById($update, ['sub_id'=>$id]);
        
        // $battle = $this->services->create($input);

    
        return redirect()->route($this->index_route_name)->with(
            'success',
            $this->mls->messageLanguage('updated', 'Location update', 1)
        );
    }

    public function destroy($id)
    {

        $result = SubService::deleteLocation($id);
        return redirect()->back()->withSuccess('Location Delete Successfully!');
    }
}
