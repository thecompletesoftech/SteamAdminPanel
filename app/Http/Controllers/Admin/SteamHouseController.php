<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Http\Requests\Admin\SteamHouseRequest;
use Illuminate\Support\Facades\DB;
use App\Models\SteamHouseModel;
use App\Services\steamhouseservice;
use App\Services\FileService;
use App\Services\ManagerLanguageService;
use App\Services\UtilityService;
// use App\Services\UserIntrestService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;



class SteamHouseController extends Controller
{
    protected $mls, $change_password, $assign_role, $uploads_image_directory;
    protected $index_view, $create_view, $edit_view, $detail_view, $tabe_view, $product_history_view;
    protected $index_route_name, $create_route_name, $detail_route_name, $edit_route_name;
    protected $bookService, $utilityService, $intrestService;

    public function __construct()
    {

        //Data
        $this->uploads_image_directory = 'files/managerregistrations';
        //route
        $this->index_route_name = 'admin.steamhouses.index';
        $this->create_route_name = 'admin.steamhouses.create';
        $this->detail_route_name = 'admin.steamhouses.show';
        $this->edit_route_name = 'admin.steamhouses.edit';
        //view files
        $this->index_view = 'admin.steamhousefolder.index';
        $this->create_view = 'admin.steamhousefolder.create';
        $this->edit_view = 'admin.steamhousefolder.edit';




        //service files
        $this->steamhouse = new steamhouseservice();
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
        $items = $this->steamhouse->datatable();

        if($request->ajax())
        {
            return view('admin.steamhousefolder.steamhouse_table',['steamhouse'=>$items]);
        } else {
            return view('admin.steamhousefolder.index',['steamhouse'=>$items]);
        }

    }


    public function create()
    {
        return view($this->create_view);
    }

    public function store(SteamHouseRequest $request)
    {
        $input = $request->except(['_token', 'proengsoft_jsvalidation']);

        $battle = $this->steamhouse->create($input);
        return redirect()->route($this->index_route_name)->with('success',
        $this->mls->messageLanguage('created', 'steam house add', 1));
    }


    public function show(SteamHouseModel $steamhouse)
    {
        return view($this->detail_view,compact('steamhouse'));
    }


    public function edit(SteamHouseModel $steamhouse)
    {
        return view($this->edit_view,compact('steamhouse'));
    }


    public function update(SteamHouseRequest $request, SteamHouseModel $steamhouse)
    {
        $input = $request->except(['_method', '_token', 'proengsoft_jsvalidation']);



        $this->steamhouse->update($input,$steamhouse);
        return redirect()->route($this->index_route_name)->with('success',
        $this->mls->messageLanguage('updated', 'steam house update', 1));
    }

    public function destroy($id)
    {

        $result=DB::table('steamhouse')->where('steamhouse_id', $id)->delete();

        return redirect()->back()->withSuccess('Data Delete Successfully!');

        if ($result) {
            return response()->json([
                'status' => 1,
                'title' => $this->mls->onlyNameLanguage('deleted_title'),
                'message' => $this->mls->onlyNameLanguage('steam house delete'),
                'status_name' => 'success'
            ]);
        } else {
            return response()->json([
                'status' => 0,
                'title' => $this->mls->onlyNameLanguage('deleted_title'),
                'message' => $this->mls->onlyNameLanguage('steam house delete'),
                'status_name' => 'error'
            ]);
        }

    }





}
