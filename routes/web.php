<?php

use App\Http\Controllers\Admin\AdminErrorPageController;

use App\Http\Controllers\Admin\Auth\LoginController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

    Route::get('/', function () {
         return redirect()->route('admin.dashboard');
    });

    Auth::routes(['register' => false]);




    Route::group(['middleware' => ['optimizeImages'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/home', function () {
        return redirect()->route('admin.dashboard');
    });

    Route::controller(LoginController::class)->group(function () {
        Route::get('/login', 'showLoginForm')->name('login');
        Route::post('/login', 'login')->name('login');
        Route::post('/logout', 'logout')->name('logout');
        Route::get('/logout', 'logout')->name('logout');
        Route::post('/livedata', 'livedata')->name('livedata');
    });
    Route::controller(AdminErrorPageController::class)->group(function () {
        Route::get('/404', 'pageNotFound')->name('notfound');
        Route::get('/500', 'serverError')->name('server_error');
    });
    Route::group(['middleware' => ['auth'], 'namespace' => 'Admin'], function () {

        Route::controller(DashboardController::class)->group(function () {
            Route::get('/test', 'test')->name('test');
            Route::get('/dashboard', 'index')->name('dashboard');
            Route::get('dashboard-counts', 'dashboardCountsData')->name('dashboard-counts');
        });

        Route::controller(AdminProfileController::class)->group(function () {
            Route::get('/profile', 'profile')->name('profile');
            Route::get('change-password', 'changePassword')->name('change_password');
            Route::put('change-password/{user}', 'updatePassword')->name('update.password');
        });

        Route::resource('roles', RoleController::class);
        Route::resource('permissions', PermissionController::class);




        Route::controller(UserController::class)->group(function () {
            Route::get('/update_language/{user}/{language}', 'updateLanguage')->name('users.update_language');
            Route::get('/users/status/{id}/{status}', 'status')->name('users.status');
            Route::get('/users/edit/{id}/{edit}', 'edit')->name('users.edit');



            Route::post('/users/download', 'export')->name('users.download');


        });

        Route::resource('/users', UserController::class);
// End




// Steam House

Route::controller(SteamHouseController::class)->group(function () {
    Route::get('/steamhouses/status/{id}/{status}','status')->name('steamhouses.status');
    Route::get('/steamhouses/destroy/{id}/','destroy')->name('steamhouses.destroy');
    });
    Route::resource('/steamhouses',SteamHouseController::class);

    // Map Location

    Route::controller(CategoryController::class)->group(function () {
    Route::get('/category/status/{id}/{status}','status')->name('category.status');
    Route::get('/category/destroy/{id}/','destroy')->name('category.destroy');
    Route::get('/category/edit/{id}/','edit')->name('category.edit');
    });
    Route::resource('/category',CategoryController::class);

    // Map Location

    Route::controller(LocationController::class)->group(function () {
    Route::get('/locations/status/{id}/{status}','status')->name('locations.status');
    Route::get('/locations/destroy/{id}/','destroy')->name('locations.destroy');
    Route::get('/locations/edit/{id}/','edit')->name('locations.edit');
    });
    Route::resource('/locations',LocationController::class);

    // Sub Services

    Route::controller(SubServices::class)->group(function () {
    Route::get('/subservices/status/{id}/{status}','status')->name('subservices.status');
    Route::get('/subservices/destroy/{id}/','destroy')->name('subservices.destroy');
    Route::get('/subservices/edit/{id}/','edit')->name('subservices.edit');
    });
    Route::resource('/subservices',SubServices::class);

    //product manage

    Route::controller(Product::class)->group(function () {
    Route::get('/product/status/{id}/{status}','status')->name('product.status');
    Route::get('/product/destroy/{id}/','destroy')->name('product.destroy');
    Route::get('/product/edit/{id}/','edit')->name('product.edit');
    });
    Route::resource('/product',Product::class);

    //vehicle manufacturer like maruti tata manage

    Route::controller(VehicleDetails::class)->group(function () {
    Route::get('/vehicle/status/{id}/{status}','status')->name('vehicle.status');
    Route::get('/vehicle/destroy/{id}/','destroy')->name('vehicle.destroy');
    Route::get('/vehicle/edit/{id}/','edit')->name('vehicle.edit');
    });
    Route::resource('/vehicle',VehicleDetails::class);

    //vehicle brand manage 

    Route::controller(VehicleBrandController::class)->group(function () {
    Route::get('/vehiclebrand/status/{id}/{status}','status')->name('vehiclebrand.status');
    Route::get('/vehiclebrand/destroy/{id}/','destroy')->name('vehiclebrand.destroy');
    Route::get('/vehiclebrand/edit/{id}/','edit')->name('vehiclebrand.edit');
    });
    Route::resource('/vehiclebrand',VehicleBrandController::class);

//fuel Type
    
    Route::controller(FuelTypeController::class)->group(function () {
    Route::get('/fueltype/status/{id}/{status}','status')->name('fueltype.status');
    Route::get('/fueltype/destroy/{id}/','destroy')->name('fueltype.destroy');
    Route::get('/fueltype/edit/{id}/','edit')->name('fueltype.edit');
    });
    Route::resource('/fueltype',FuelTypeController::class);
    // Coompany List

//VehicleTypeController Type
    
    Route::controller(VehicleTypeController::class)->group(function () {
    Route::get('/vehicletype/status/{id}/{status}','status')->name('vehicletype.status');
    Route::get('/vehicletype/destroy/{id}/','destroy')->name('vehicletype.destroy');
    Route::get('/vehicletype/edit/{id}/','edit')->name('vehicletype.edit');
    });
    Route::resource('/vehicletype',VehicleTypeController::class);
    // Coompany List

    Route::controller(CompanyListController::class)->group(function () {
        Route::get('/companylists/status/{id}/{status}','status')->name('companylists.status');
        Route::get('/companylists/destroy/{id}/','destroy')->name('companylists.destroy');
        Route::get('/companylists/edit/{id}/','edit')->name('companylists.edit');
    });
    Route::resource('/companylists',CompanyListController::class);



    // Manager Registration

    Route::controller(ManagerRegistrationController::class)->group(function () {
    Route::get('/managerregistrations/status/{id}/{status}','status')->name('managerregistrations.status');
    Route::get('/managerregistrations/destroy/{id}/','destroy')->name('managerregistrations.destroy');
    Route::get('/managerregistrations/edit/{id}/','edit')->name('managerregistrations.edit');
    Route::get('/managerregistrations/locationdata/{id}', 'locationdata')->name('managerregistrations.locationdata');
    

    });
    Route::resource('/managerregistrations',ManagerRegistrationController::class);

    // Engineer Registration
    Route::controller(EmployeeRegistrationController::class)->group(function () {
        Route::get('/employeeregistrations/status/{id}/{status}','status')->name('employeeregistrations.status');
        Route::get('/employeeregistrations/destroy/{id}/','destroy')->name('employeeregistrations.destroy');
        Route::get('/employeeregistrations/edit/{id}/','edit')->name('employeeregistrations.edit');
        });
        Route::resource('/employeeregistrations',EmployeeRegistrationController::class);

//Notification

Route::controller(NotificationController::class)->group(function () {
    Route::get('/notifications/status/{id}/{status}', 'status')->name('notifications.status');
    Route::get('/notifications/destroy/{id}/', 'destroy')->name('notifications.destroy');
});
Route::resource('/notifications', NotificationController::class);


    // Services Request

    Route::controller(ServicesRequestController::class)->group(function () {
    Route::get('/servicerequests/status/{id}/{status}','status')->name('servicerequests.status');
    Route::get('/servicerequests/destroy/{id}/','destroy')->name('servicerequests.destroy');
    });
    Route::resource('/servicerequests',ServicesRequestController::class);

    // Customer Feedback

    Route::controller(CustomerFeedbackController::class)->group(function () {
    Route::get('/reviews/status/{id}/{status}','status')->name('reviews.status');
    Route::get('/reviews/destroy/{id}/','destroy')->name('reviews.destroy');
    });
    Route::resource('/reviews',CustomerFeedbackController::class);
    // Manager Feedback

    Route::controller(ManagerFeedbackController::class)->group(function () {
    Route::get('/managerfeedbacks/status/{id}/{status}','status')->name('managerfeedbacks.status');
    Route::get('/managerfeedbacks/destroy/{id}/','destroy')->name('managerfeedbacks.destroy');
    });
    Route::resource('/managerfeedbacks',ManagerFeedbackController::class);

    // Employee Feedback

    Route::controller(EmployeeFeedbackController::class)->group(function () {
    Route::get('/employeefeedbacks/status/{id}/{status}','status')->name('employeefeedbacks.status');
    Route::get('/employeefeedbacks/destroy/{id}/','destroy')->name('employeefeedbacks.destroy');
    });
    Route::resource('/employees',EmployeeFeedbackController::class);
    // customer data

    Route::controller(CustomerDataController::class)->group(function () {
    Route::get('/customerdatas/status/{id}/{status}','status')->name('customerdatas.status');
    Route::get('/customerdatas/destroy/{id}/','destroy')->name('customerdatas.destroy');
    });
    Route::resource('/customerdatas',CustomerDataController::class);

    // customer Tracking

    Route::controller(CustomertrackingController::class)->group(function () {
    Route::get('/customertrackings/status/{id}/{status}','status')->name('customertrackings.status');
    Route::get('/customertrackings/destroy/{id}/','destroy')->name('customertrackings.destroy');
    });
    Route::resource('/customertrackings',CustomertrackingController::class);















        //Setting manager
        Route::controller(SettingController::class)->group(function () {
            Route::get('/settings/general', 'edit_general')->name('settings.edit_general');
            Route::post('/settings/general', 'update_general')->name('settings.update_general');

        });
    });
});




Route::get('/reset-password',[UserController::class,'resetPasswordLoad']);
Route::post('/reset-password',[UserController::class,'resetPassword']);



