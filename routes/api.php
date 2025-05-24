<?php

use App\Http\Controllers\Api\V1\Customer\CTestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/v1/test', 'Api\V1\TestController@test');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::group(['middleware' => ['optimizeImages'], 'prefix' => '/v1/customer', 'namespace' => 'Api\V1\Customer'], function () {
    Route::get('/test', [CTestController::class, 'test']);

    // -------- Register And Login API ----------
    Route::controller(AuthController::class)->group(function () {
        Route::post('login', 'login');
        // Route::get('managerCompany', 'managerCompany');
        // Route::get('livedata', 'livedata'); 
        Route::post('userRegister', 'userRegister');
        // Route::post('UserList', 'UserList');
        // Route::post('userUpdate/{id}', 'userUpdate');
        // Route::post('allUserintrest', 'allUserintrest');
     
        Route::post('contactUs', 'contactUs');
        Route::post('forgetPassword', 'forgetPassword');
       









         // steam house(home)
         Route::post('steamhouses', 'steamhouseslist');
         // Employee Feedback
         Route::post('employeefeedbacklist', 'employeefeedbacklistapi');
         // Map location
         Route::post('locations', 'locationsapi');
         Route::post('locationslist', 'locationslist');
         // Company List
         Route::post('companylistsaddapi', 'companylistsaddapi');
         Route::post('companylistsapilist', 'companylistsapilist');

         // Employee Data
         Route::post('employees', 'employeesapi');

         Route::post('employeeupdateapi/{id}', 'employeeupdateapi');
         // Live Data(customerdatas)
         Route::post('customerdatas', 'customerdatasapi');
         Route::post('customerdataslist', 'customerdataslistapi');
         Route::post('customerdatasupdate/{id}', 'customerdatasupdate');

    });

    // -------- Register And Login API ----------
    Route::group(['middleware' => ['jwt.auth']], function () {
        /* logout APi */
        Route::controller(AuthController::class)->group(function () {


   Route::post('sendOtp', 'sendOtp');
        Route::post('verifyOtp', 'verifyOtp');

 //list all vehicle type like car bike
        Route::post('VehicleType', 'VehicleType');
       
        //list all vehicle Menufacturer
        Route::post('VehicleManufacturer', 'VehicleManufacturer');
       
        //list all vehicle Menufacturer
        Route::post('VehicleBrandService', 'VehicleBrandService');
       
        //list all vehicle Menufacturer
        Route::post('FueltypeService', 'FueltypeService');
       
        //list all getServicesSubData where user select on immidate assistance screen on map
        Route::post('getServicesSubData', 'getServicesSubData');
       
        //list all vehicle Menufacturer
        Route::post('ProductCategory', 'ProductCategory');
        //list all vehicle Menufacturer
        Route::post('ProductAdd', 'ProductAdd');
        //list all product by categoryId Menufacturer
        Route::post('listProduct', 'listProduct');
        //Add user vehicle details 
        Route::post('addUserVehicle', 'addUserVehicle');
        //List user vehicle details 
        Route::post('listUserVehicle', 'listUserVehicle');





            Route::post('addRating', 'addRating');
            Route::post('listavdRating', 'listavdRating');
            Route::post('updateStatus', 'updateStatus');

            Route::post('addQuestion', 'addQuestion');
            Route::post('adventureById', 'adventureById');
            Route::post('listBook', 'listBook');
            

            Route::post('adventureByuserIntrest', 'adventureByuserIntrest');
            Route::post('profileUpdate', 'profileUpdate');
            Route::post('userProfile', 'userProfile');
            Route::post('editProfile', 'editProfile');

            Route::post('updatePushNotification', 'updatePushNotification');
            Route::post('travel', 'travel');
            Route::post('getPlaceByid', 'getPlaceByid');
            Route::post('userAdventure', 'userAdventure');

            Route::post('placeById', 'placeById');
            Route::post('deleteAccount', 'deleteAccount');
            Route::post('logout', 'logout');
             Route::post('employeeslist', 'employeeslistapi');

            //Service Request Api
             Route::post('servicerequestlist', 'servicerequestlistapi');
             Route::post('ServiceRequestBYUserId', 'ServiceRequestBYUserId');
             Route::post('ServiceRequestBYManagerID', 'ServiceRequestBYManagerID');
             Route::post('ServiceRequestBYEmpId', 'ServiceRequestBYEmpId');

             Route::post('servicesrequestupdate/{id}', 'servicesrequestupdate');
             Route::post('servicesrequeststatusupdate/{id}', 'servicesrequeststatusupdate');
             Route::post('servicesrequest', 'servicesrequestapi');

             // Customer Feedback Api
             Route::post('reviews', 'reviewapi');
             Route::post('reviewslist', 'reviewapilist');
             Route::post('review', 'review');
             Route::post('customerfeedbackupdate/{id}', 'customerfeedbackupdate');
            // Tracker Status
             Route::post('trackingstatus', 'trackingstatusapi');
             Route::post('trackingstatusupdate/{id}', 'trackingstatusupdate');
             Route::post('trackingstatuslist', 'trackingstatuslistapi');
            // Manager Feedback
             Route::post('managerfeedbacks', 'managerfeedbacksapi');
             Route::post('managerfeedbackslist', 'managerfeedbackslistapi');
             Route::post('managerfeedbackupdate/{id}', 'managerfeedbackupdate');
            // Employee Feedback
             Route::post('employeefeedback', 'employeefeedbackaddapi');


        });

        /* Profile Controller */
        Route::controller(CProfileController::class)->group(function () {
            /*Profile API */
            Route::get('profile', 'profile');
            Route::put('update-profile', 'updateProfile');
            Route::post('update-profile-image', 'updateProfileImage');
        });
    });
});
