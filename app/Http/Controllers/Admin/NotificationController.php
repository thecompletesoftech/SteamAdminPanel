<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\NotificationRequest;
use App\Models\Notification;
use App\Models\User;
use App\Services\NotificationService;
use App\Services\HelperService;
use App\Services\CustomerService;
use App\Services\ManagerLanguageService;
use App\Services\UtilityService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Artisan;

class NotificationController extends Controller
{
    protected $mls, $change_password, $assign_role, $uploads_image_directory;
    protected $index_view, $create_view, $edit_view, $detail_view, $tabe_view, $product_history_view;
    protected $index_route_name, $create_route_name, $detail_route_name, $edit_route_name;
    protected $notificationService, $utilityService, $customerService;

    public function __construct()
    {

        $this->uploads_image_directory = 'files/notifications';
        //route
        $this->index_route_name = 'admin.notifications.index';
        $this->create_route_name = 'admin.notifications.create';
        $this->detail_route_name = 'admin.notifications.show';
        $this->edit_route_name = 'admin.notifications.edit';

        //view files
        $this->index_view = 'admin.notification.index';
        $this->create_view = 'admin.notification.create';
        $this->detail_view = 'admin.notification.details';
        $this->tabe_view = 'admin.notification.profile';
        $this->edit_view = 'admin.notification.edit';


        //service files
        $this->notificationService = new NotificationService();

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
        $items = $this->notificationService->datatable();

        if ($request->ajax()) {

            return view('admin.notification.notification_table',['notifications'=>$items]);
        } else {
            return view('admin.notification.index',['notifications'=>$items]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view($this->create_view);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  NotificationRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->except(['_token', 'proengsoft_jsvalidation']);

        $data=array();

        $data=User::where('role',$input['role'])->where('push_notification','1')->get();

        foreach($data as $datas){
            $input['user_id']=$datas->id;
            $this->notificationService->create($input);
        }
        return redirect()->route($this->index_route_name)
        ->with('success', $this->mls->messageLanguage('created', 'notification', 1));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Notification  $battle
     * @return \Illuminate\Http\Response
     */
    public function show(Notification $notification)
    {
        return view($this->detail_view, compact('notification'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Notification  $battle
     * @return \Illuminate\Http\Response
     */
    public function edit(Notification $notification)
    {


        return view($this->edit_view, compact('notification'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Notification  $promocode
     * @return \Illuminate\Http\Response
     */
    public function update(NotificationRequest $request, Notification $notification)
    {
        $input = $request->except(['_method', '_token', 'proengsoft_jsvalidation']);
        $this->notificationService->update($input, $notification);
        return redirect()->route($this->index_route_name)
            ->with('success', $this->mls->messageLanguage('updated', 'notification', 1));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Notification  $promocode
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result=Notification::find($id)->delete();

        return redirect()->back()->withSuccess('Data Delete Successfully!');
    }

    public function status($id, $status)
    {

        $status = ($status == 1) ? 0 : 1;
        $result =  $this->notificationService->updateById(['status' => $status], $id);
        if ($result) {
            return response()->json([
                'status' => 1,
                'message' => $this->mls->messageLanguage('updated', 'status', 1),
                'status_name' => 'success'
            ]);
        } else {
            return response()->json([
                'status' => 0,
                'message' => $this->mls->messageLanguage('not_updated', 'status', 1),
                'status_name' => 'error'
            ]);
        }
    }
}
