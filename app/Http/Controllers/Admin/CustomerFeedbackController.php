<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Http\Requests\Admin\ReviewRequest;
use Illuminate\Support\Facades\DB;
use App\Models\CustomerFeedbackModel;
use App\Services\CustomerFeedbackService;
use App\Services\FileService;
use App\Services\ManagerLanguageService;
use App\Services\UtilityService;
// use App\Services\UserIntrestService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;



class CustomerFeedbackController extends Controller
{
    protected $mls, $change_password, $assign_role, $uploads_image_directory;
    protected $index_view, $create_view, $edit_view, $detail_view, $tabe_view, $product_history_view;
    protected $index_route_name, $create_route_name, $detail_route_name, $edit_route_name;
    protected $bookService, $utilityService, $intrestService;

    public function __construct()
    {

        //Data
        $this->uploads_image_directory = 'files/reviews';

        //route

        $this->index_route_name  = 'admin.reviews.index';
        $this->create_route_name = 'admin.reviews.create';
        $this->detail_route_name = 'admin.reviews.show';
        $this->edit_route_name   = 'admin.reviews.edit';

        //view files

        $this->index_view  = 'admin.reviewsfolder.index';
        $this->create_view = 'admin.reviewsfolder.create';
        $this->edit_view   = 'admin.reviewsfolder.edit';




        //service files
        $this->review = new CustomerFeedbackService();
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
        $items = $this->review->datatable();

        if($request->ajax())
        {
            return view('admin.reviewsfolder.reviews_table',['review'=>$items]);
        } else {
            return view('admin.reviewsfolder.index',['review'=>$items]);
        }

    }


    public function create()
    {
        return view($this->create_view);
    }

    public function store(ReviewRequest $request)
    {
        $input = $request->except(['_token', 'proengsoft_jsvalidation']);

        $battle = $this->review->create($input);
        return redirect()->route($this->index_route_name)->with('success',
        $this->mls->messageLanguage('created', 'Review add', 1));
    }


    public function show(CustomerFeedbackModel $review)
    {
        return view($this->detail_view,compact('review'));
    }


    public function edit(CustomerFeedbackModel $review)
    {
        return view($this->edit_view,compact('review'));
    }


    public function update(ReviewRequest $request, CustomerFeedbackModel $review)
    {
        $input = $request->except(['_method', '_token', 'proengsoft_jsvalidation']);



        $this->review->update($input,$review);
        return redirect()->route($this->index_route_name)->with('success',
        $this->mls->messageLanguage('updated', 'Review update', 1));
    }

    public function destroy($id)
    {

        $result=DB::table('customerfeedback')->where('id', $id)->delete();

        return redirect()->back()->withSuccess('Data Delete Successfully!');

        if ($result) {
            return response()->json([
                'status' => 1,
                'title' => $this->mls->onlyNameLanguage('deleted_title'),
                'message' => $this->mls->onlyNameLanguage('Review delete'),
                'status_name' => 'success'
            ]);
        } else {
            return response()->json([
                'status' => 0,
                'title' => $this->mls->onlyNameLanguage('deleted_title'),
                'message' => $this->mls->onlyNameLanguage('Review delete'),
                'status_name' => 'error'
            ]);
        }

    }





}
