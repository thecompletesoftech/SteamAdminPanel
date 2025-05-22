<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Http\Requests\Admin\LocationRequest;
use Illuminate\Support\Facades\DB;
use App\Models\LocationModel;
use App\Models\Services;
use App\Services\ProductService;
use App\Services\FileService;
use App\Services\ManagerLanguageService;
use App\Services\UtilityService;
use Aws\Api\Service;
// use App\Services\UserIntrestService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Models\Category;


class Product extends Controller
{
    protected $mls, $change_password, $assign_role, $uploads_image_directory;
    protected $index_view, $create_view, $edit_view, $detail_view, $tabe_view, $product_history_view;
    protected $index_route_name, $create_route_name, $detail_route_name, $edit_route_name;
    protected $bookService, $utilityService, $intrestService;

    public function __construct()
    {

        //Data
        $this->uploads_image_directory = 'files/product';

        //route

        $this->index_route_name = 'admin.product.index';
        $this->create_route_name = 'admin.product.create';
        $this->detail_route_name = 'admin.product.show';
        $this->edit_route_name = 'admin.product.edit';

        //view files

        $this->index_view = 'admin.product.index';
        $this->create_view = 'admin.product.create';
        $this->edit_view = 'admin.product.edit';



        //service files
        $this->service = new ProductService();
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

        if ($request->ajax()) {
            return view('admin.product.location_table', ['location' => $items]);
        } else {
            return view('admin.product.index', ['location' => $items]);
        }
    }


    public function create()
    {
        $Category = Category::where(["status" => 0, 'deleted_at' => null])->get();
        return view($this->create_view, ['Category' => $Category]);
    }

    public function store(Request $request)
    {

        $input = $request->except(['_token', 'proengsoft_jsvalidation']);

        $image = $request->file('pictures');
        $filename = time() . $image->getClientOriginalName();
        $destinationPath = public_path($this->uploads_image_directory);
        $image->move($destinationPath, $filename);
        $input['product_image'] = $this->uploads_image_directory . "/" . $filename;



        $battle = $this->service->create($input);
        return redirect()->route($this->index_route_name)->with(
            'success',
            $this->mls->messageLanguage('created', 'Services Has Been Added', 1)
        );
    }


    public function show(Services $location)
    {
        return view($this->detail_view, compact('location'));
    }


    public function edit($id)
    {
        echo $location = $this->service->getById($id);
        return view($this->edit_view, compact('location'));
    }


    public function update(LocationRequest $request, Services $location)
    {
        $input = $request->except(['_method', '_token', 'proengsoft_jsvalidation']);



        $this->service->update($input, $location);
        return redirect()->route($this->index_route_name)->with(
            'success',
            $this->mls->messageLanguage('updated', 'Location update', 1)
        );
    }

    public function destroy($id)
    {

        $result = ProductService::deleteLocation($id);
        return redirect()->back()->withSuccess('Location Delete Successfully!');
    }

    public function status($id, $status)
    {

        $result = ProductService::updateById(['status' => $status], $id);
        return redirect()->back()->withSuccess('Location Delete Successfully!');
    }
}
