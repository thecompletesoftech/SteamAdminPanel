<?php

namespace App\Http\Controllers\Api\V1\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApiLoginRequest;
use App\Http\Requests\ApiRegisterRequest;
use App\Http\Requests\Admin\ContactUsRequest;
use App\Services\Api\AuthService;
use App\Services\Api\ApiRatingService;
use App\Services\Api\ApiCommonService;

use App\Services\HelperService;
use App\Services\UserService;
use App\Services\VehicletypeService;
use App\Services\VehicleDetailsService;
use App\Services\VehicleBrandService;
use App\Services\FueltypeService;
use App\Services\ProductService;
use App\Services\CategoryService;

//user end services
use App\Services\LocationService;
use App\Services\UserVehicleService;

use App\Http\Requests\Admin\ServiceRequest;
use App\Http\Requests\Admin\ReviewRequest;
use App\Http\Requests\Admin\LocationRequest;
use App\Http\Requests\Admin\CompanyListRequest;
use App\Http\Requests\Admin\CustomerTrackingRequest;
use App\Http\Requests\Admin\ManagerFeedbackRequest;
use App\Http\Requests\Admin\EmployeesRequest;
use App\Http\Requests\Admin\EmployeeFeedbackRequest;
use App\Http\Requests\Admin\CustomerDataRequest;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    protected $helperService, $userService, $apiAuthService, $walletService, $apiratingService, $apicommonService;
    protected $VehicleType, $VehicleManufacturer, $VehicleBrandService, $FueltypeService, $ProductService, $ProductCategory;
    protected $ListOfServices, $UserVehicleService;


    public function __construct()
    {
        $this->helperService = new HelperService();
        $this->userService = new UserService();
        $this->apiratingService = new ApiRatingService();
        $this->apicommonService = new ApiCommonService();
        $this->apiAuthService = new AuthService();
        $this->VehicleType = new VehicletypeService();
        $this->VehicleManufacturer = new VehicleDetailsService();
        $this->VehicleBrandService = new VehicleBrandService();
        $this->FueltypeService = new FueltypeService();
        $this->ProductService = new ProductService();
        $this->ProductCategory = new CategoryService();
        $this->ListOfServices = new LocationService();
        $this->UserVehicleService = new UserVehicleService();
    }

    /**
     * Authenticate user Check.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(ApiLoginRequest $request)
    {

        return $this->apiAuthService->login($request);
    }



    /**
     * Send Otp
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sendOtp(Request $request)
    {
        return $this->apiAuthService->sendOtp($request);
    }

    /**
     * Verify Otp
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function verifyOtp(Request $request)
    {
        $request->merge(['role' => 'customer']);
        return $this->apiAuthService->verifyOtp($request);
    }


    public function userUpdate(Request $request, $id)
    {
        return $this->apiAuthService->userUpdate($request, $id);
    }



    /**
     * Register user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function userRegister(ApiRegisterRequest $request)
    {

        //    request->merge(['role' => 'Customer']);
        return $this->apiAuthService->userRegister($request);
    }

    /**
     * List Vehicle types
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function VehicleType()
    {

        return $this->VehicleType->datatable();
    }

    /**
     *List VehicleManufacturer
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function VehicleManufacturer(Request $request)
    {
        $data = ['vehicle_type' => $request->vehicle_type];
        return $this->VehicleManufacturer->where($data);
    }

    /**
     *List VehicleBrand / Modal Name
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function VehicleBrandService(Request $request)
    {
        $data = ['vehicle_id' => $request->vehicle_id];
        return $this->VehicleBrandService->where($data);
    }

    /**
     * List Vehicle types
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function FueltypeService()
    {

        return $this->FueltypeService->datatable();
    }



    /**
     * Add user vehicle details
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addUserVehicle(Request $request)
    {
        $input = $request->except(['_token', 'proengsoft_jsvalidation']);
        return $this->UserVehicleService->create($input);
    }

    /**
     * List user vehicle details
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function listUserVehicle(Request $request)
    {
         $user = auth()->user();
         
        // $input = $request->except(['_token', 'proengsoft_jsvalidation']);
        return $this->UserVehicleService->Listvehicle( $user->id);
    }

    /**
     * List Product Categoey
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getServicesSubData()
    {

        return $this->ListOfServices->getServicesSubData();
    }



    /**
     * List Product Categoey
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function ProductCategory()
    {

        return $this->ProductCategory->datatable();
    }



    /**
     * List Product Categoey
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function ProductAdd(Request $request)
    {
        $input = $request->except(['_token', 'proengsoft_jsvalidation']);

        $image = $request->file('product_image');
        $filename = time() . $image->getClientOriginalName();
        $destinationPath = public_path('files/product');
        $image->move($destinationPath, $filename);
        $input['product_image'] = 'files/product' . "/" . $filename;
        $input['uploaded_by'] = 1;


        return $this->ProductService->create($input);
    }
    /**
     * List Product by Categoey
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function listProduct(Request $request)
    {
        $input = $request->except(['_token', 'proengsoft_jsvalidation']);

        return $this->ProductService->where(['product_category'=> $input['product_category']]);
    }



    /**
     * Add Rating
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addRating(Request $request)
    {

        return $this->apiratingService->addRating($request);
    }


    /**
     * List Rating by adventure
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function listavdRating(Request $request)
    {

        return $this->apiratingService->listavdRating($request);
    }



    /**
     * Add Question
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addQuestion(Request $request)
    {

        return $this->apiratingService->addQuestion($request);
    }

    /**
     * List All Books
     *
     * @return \Illuminate\Http\Response
     */
    public function listBook(Request $request)
    {
        return $this->apiratingService->listBook($request);
    }





    /**
     * Profile By Token
     *
     * @return \Illuminate\Http\Response
     */
    public function userProfile()
    {

        return $this->apiAuthService->userProfile();
    }


    /**
     * Update User Profile
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function profileUpdate(Request $request)
    {

        return $this->apiAuthService->profileUpdate($request);
    }


    /**
     * Update User Profile
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function editProfile(Request $request)
    {

        return $this->apiAuthService->editProfile($request);
    }




    /**
     * Update Push Notification
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updatePushNotification(Request $request)
    {

        return $this->apiAuthService->updatePushNotification($request);
    }





    /**
     * Update  Status
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request)
    {

        return $this->apicommonService->updateStatus($request);
    }

    /**
     * Forget Password
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function forgetPassword(Request $request)
    {

        return $this->apiAuthService->forgetPassword($request);
    }

    /**
     * Get All User Insert
     *
     * @return \Illuminate\Http\Response
     */
    public function allUserintrest(Request $request)
    {
        return $this->apiAuthService->allUserintrest($request);
    }

    /**
     * Get Adventure By User Intrest
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function adventureByuserIntrest(Request $request)
    {

        return $this->apiAuthService->adventureByuserIntrest($request);
    }

    /**
     * Adventure By ID
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function adventureById(Request $request)
    {
        return $this->apicommonService->adventureById($request);
    }


    /**
     * Get Places By Id
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getPlaceByid(Request $request)
    {

        return $this->apicommonService->getPlaceByid($request);
    }



    /**
     * Place By Adventure
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function placeById(Request $request)
    {
        return $this->apicommonService->placeById($request);
    }

    /**
     * Add Travel
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function travel(Request $request)
    {
        return $this->apicommonService->travel($request);
    }

    /**
     * User  Adventures
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function userAdventure(Request $request)
    {
        return $this->apicommonService->userAdventure($request);
    }

    /**
     * Delete User
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function deleteAccount(Request $request)
    {
        return $this->apicommonService->deleteAccount($request);
    }


    /**
     * Add Contact Us
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function contactUs(ContactUsRequest $request)
    // {
    //     return $this->apicommonService->contactUs($request);
    // }


    /**
     * Logout user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function logout(Request $request)
    {
        return $this->apiAuthService->steamlogout($request);
    }



    // --------------------------------------------------------------------------------------------

    // User List
    public function UserList()
    {
        return $this->apiAuthService->UserList();
    }

    // Service Request Add And Delete And List Api
    //add
    public function servicesrequestapi(Request $request)
    {
        return $this->apiAuthService->servicesrequestapi($request);
    }
    //list
    public function servicerequestlistapi()
    {
        return $this->apiAuthService->ServiceRequestServicelist();
    }
    //list by UserId
    public function ServiceRequestBYUserId(Request $request)
    {
        return $this->apiAuthService->ServiceRequestBYUserId($request);
    }
    //list by ManagerID
    public function ServiceRequestBYManagerID(Request $request)
    {
        return $this->apiAuthService->ServiceRequestBYManagerID($request);
    }
    //list by EmpId
    public function ServiceRequestBYEmpId(Request $request)
    {
        return $this->apiAuthService->ServiceRequestBYEmpId($request);
    }
    //Update status
    public function servicesrequeststatusupdate(Request $request, $id)
    {

        return $this->apiAuthService->servicesrequeststatusupdate($request, $id);
    }
    //Update
    public function servicesrequestupdate(Request $request, $id)
    {

        return $this->apiAuthService->servicesrequestupdate($request, $id);
    }


    // Customer Feedback Add And Delete And List Api
    //add
    public function reviewapi(ReviewRequest $request)
    {
        return $this->apiAuthService->ReviewRatingServices($request);
    }
    //update
    public function customerfeedbackupdate(ReviewRequest $request, $id)
    {
        return $this->apiAuthService->customerfeedbackupdate($request, $id);
    }
    //list
    public function reviewapilist(Request $request)
    {
        return $this->apiAuthService->ReviewRatingServiceslist($request);
    }


    // steam house
    //list
    public function steamhouseslist()
    {
        return $this->apiAuthService->steamhouseservicelist();
    }
    // Map Location
    //list
    public function locationslist()
    {
        return $this->apiAuthService->locationslist();
    }
    //add
    public function locationsapi(LocationRequest $request)
    {
        return $this->apiAuthService->locationsapiadd($request);
    }


    //list
    public function managerCompany()
    {
        return $this->apiAuthService->livedata();
    }

    // Company List
    //list
    public function companylistsapilist(Request $request)
    {
        return $this->apiAuthService->companylistsapilist($request);
    }
    //add
    public function companylistsaddapi(CompanyListRequest $request)
    {
        return $this->apiAuthService->companylistsaddapi($request);
    }

    // Tracker Status
    //list
    public function trackingstatuslistapi(Request $request)
    {
        return $this->apiAuthService->trackingstatuslistapi($request);
    }
    //add
    public function trackingstatusapi(CustomerTrackingRequest $request)
    {
        return $this->apiAuthService->trackingstatusapi($request);
    }
    //add
    // public function trackingstatusupdate(Request $request, $id)
    // {
    //     return $this->apiAuthService->trackingstatusupdate($request, $id);
    // }

    // Manager Feedback
    //list
    public function managerfeedbackslistapi()
    {
        return $this->apiAuthService->managerfeedbackslistapi();
    }
    //add
    public function managerfeedbacksapi(ManagerFeedbackRequest $request)
    {
        return $this->apiAuthService->managerfeedbacksapi($request);
    }
    //update
    public function managerfeedbackupdate(ManagerFeedbackRequest $request, $id)
    {
        return $this->apiAuthService->managerfeedbackupdate($request, $id);
    }
    // Employee Feedback
    //list
    public function employeefeedbacklistapi()
    {
        return $this->apiAuthService->employeefeedbacklistapi();
    }
    //add
    public function employeefeedbackaddapi(EmployeeFeedbackRequest $request)
    {
        return $this->apiAuthService->employeefeedbackaddapi($request);
    }
    //update
    public function employeefeedbackupdate(EmployeeFeedbackRequest $request, $id)
    {
        return $this->apiAuthService->employeefeedbackupdate($request, $id);
    }

    // Employee
    //list
    public function employeeslistapi(Request $request)
    {
        return $this->apiAuthService->employeeslistapi($request);
    }
    //add
    public function employeesapi(EmployeesRequest $request)
    {
        return $this->apiAuthService->employeesapi($request);
    }
    //update
    // public function employeeupdateapi(EmployeesRequest $request, $id)
    // {
    //     return $this->apiAuthService->employeeupdateapi($request, $id);
    // }

    // Live Data (Customer Data)
    //list
    public function customerdataslistapi()
    {
        return $this->apiAuthService->customerdataslistapi();
    }
    //add
    public function customerdatasapi(CustomerDataRequest $request)
    {
        return $this->apiAuthService->customerdatasapi($request);
    }
    public function customerdatasupdate(Request $request, $id)
    {
        return $this->apiAuthService->customerdatasupdate($request, $id);
    }
}
