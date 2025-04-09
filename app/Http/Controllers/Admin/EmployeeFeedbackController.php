<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Http\Requests\Admin\EmployeeFeedbackRequest;
use Illuminate\Support\Facades\DB;
use App\Models\EmployeeFeedbackModel;
use App\Models\User;
use App\Models\LocationModel;
use App\Services\EmployeeFeedbackService;
use App\Services\FileService;
use App\Services\ManagerLanguageService;
use App\Services\UtilityService;
use App\Services\ManagerUserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;



class EmployeeFeedbackController extends Controller
{
    protected $mls, $change_password, $assign_role, $uploads_image_directory;
    protected $index_view, $create_view, $edit_view, $detail_view, $tabe_view, $product_history_view;
    protected $index_route_name, $create_route_name, $detail_route_name, $edit_route_name;
    protected $bookService, $utilityService, $intrestService,$managerservice;

    public function __construct()
    {

        //Data
        $this->uploads_image_directory = 'files/employeefeedbacks';

        //route

        $this->index_route_name  = 'admin.employeefeedbacks.index';
        $this->create_route_name = 'admin.employeefeedbacks.create';
        $this->detail_route_name = 'admin.employeefeedbacks.show';
        $this->edit_route_name   = 'admin.employeefeedbacks.edit';

        //view files

        $this->index_view  = 'admin.employeesfeedbackfolder.index';
        $this->create_view = 'admin.employeesfeedbackfolder.create';
        $this->edit_view   = 'admin.employeesfeedbackfolder.edit';



        //service files
        $this->employeefeedback = new EmployeeFeedbackService();
        // $this->managerservice = new ManagerUserService();
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
        $items = $this->employeefeedback->datatable();

        if($request->ajax())
        {
            return view('admin.employeesfeedbackfolder.feedback_table',['managerfeedback'=>$items]);
        } else {
            return view('admin.employeesfeedbackfolder.index',['managerfeedback'=>$items]);
        }

    }


    public function create()
    {
        return view($this->create_view);
    }

    public function store(EmployeeFeedbackRequest $request)
    {
        $input = $request->except(['_token', 'proengsoft_jsvalidation']);
        if(!empty($request->pictures)){
            $image=$request->file('pictures');
            $filename = time().$image->getClientOriginalName();
            $destinationPath = public_path('/employeefeedback/image/');
            $image->move($destinationPath, $filename);
            $input['pictures']=$filename;
                }

        $battle = $this->employeefeedback->create($input);
        return redirect()->route($this->index_route_name)->with('success',
        $this->mls->messageLanguage('created', 'managerfeedback add', 1));
    }


    public function show(EmployeeFeedbackModel $employeefeedback)
    {
        return view($this->detail_view,compact('employeefeedback'));
    }


    public function edit(EmployeeFeedbackModel $employeefeedback)
    {
        return view($this->edit_view,compact('employeefeedback'));
    }


    public function update(EmployeeFeedbackRequest $request, EmployeeFeedbackModel $employeefeedback)
    {
        $input = $request->except(['_method', '_token', 'proengsoft_jsvalidation']);



        $this->employeefeedback->update($input,$employeefeedback);
        return redirect()->route($this->index_route_name)->with('success',
        $this->mls->messageLanguage('updated', 'managerfeedback update', 1));
    }

    public function destroy($id)
    {

        $result=DB::table('employee_feedback')->where('id', $id)->delete();

        return redirect()->back()->withSuccess('Data Delete Successfully!');

        if ($result) {
            return response()->json([
                'status' => 1,
                'title' => $this->mls->onlyNameLanguage('deleted_title'),
                'message' => $this->mls->onlyNameLanguage('Employee Feedback delete'),
                'status_name' => 'success'
            ]);
        } else {
            return response()->json([
                'status' => 0,
                'title' => $this->mls->onlyNameLanguage('deleted_title'),
                'message' => $this->mls->onlyNameLanguage('Employee Feedback delete'),
                'status_name' => 'error'
            ]);
        }

    }





}
