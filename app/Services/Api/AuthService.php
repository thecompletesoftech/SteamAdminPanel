<?php

namespace App\Services\Api;

use App\Models\CustomerDataModel;
use App\Models\CustomerFeedbackModel;
use App\Models\EmployeeFeedbackModel;
use App\Models\Livedata;
use App\Models\LocationModel;
use App\Models\ManagerFeedbackModel;
use App\Models\MasterOtp;
use App\Models\PasswordReset;
use App\Models\ServiceRequestModel;
use App\Models\TrackingModel;
use App\Models\User;
use App\Services\FileService;
use App\Services\HelperService;
use App\Services\NotificationService;
use App\Services\UserService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService
{
    /**
     * Authenticate user Check and login.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public static function login(Request $request)
    {

        $user = User::where('email', $request->username)
            ->orwhere('phone', $request->username)
            ->orwhere('username', $request->username)
            ->first();

        if (!$user) {
            return response()->json(
                [
                    'status' => false,
                    'message' => "You don't have an account with us, Please create your account with us and then login.",
                    'type' => 'unauthorized',
                ],
                200
            );
        }

        $credentials = $request->only(['password']);

        $credentials['status'] = 0;
        $credentials['username'] = $user->username;
        $token = auth('api')->attempt($credentials, ['exp' => Carbon::now()->timestamp]);

        if (!$token) {
            if ($user->status == 1) {

                return response()->json(
                    [
                        'status' => false,
                        'message' => 'Your account has been deactivated by admin. Please contact to Support Team.',
                        'type' => 'blocked',
                    ],
                    200
                );
            } else {
                return response()->json(
                    [
                        'status' => false,
                        'message' => 'Oops!, You have provide incorrect credentials.',
                        'type' => 'unauthorized',
                    ],
                    200
                );
            }
        }
        $user = JWTAuth::setToken($token)->toUser();

        if (!empty($user->profile)) {
            $user->profile = FileService::image_path($user->profile);
        }

        if ($user->status == 0) {
            // UserService::updateLastLogin($user->id, $request);
            if (!empty($request->fcm_token)) {
                $data = array('fcm_token' => $request->fcm_token);

                $result = DB::table('users')->where('username', $request->username)->update($data);

            }

            $location_data = DB::table('users')->select('users.id', 'users.address', 'location.location_id', 'location.contact_no as helpline_no')
                ->join('location', 'location.location_id', '=', 'users.address')->where('users.id', $user->id)->first();
            $user['helpline_no'] = $location_data->helpline_no;
            // Artisan::call('livedata:update');
            return response()->json(
                [
                    'status' => true,
                    'message' => 'Login Successfully',
                    'token' => $token,
                    'data' => $user,
                    // 'location'=>$location_data->helpline_no
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Your Account is Blocked or Unverify Please Connect with Support!',
                    'type' => 'blocked',
                ],
                200
            );
        }
    }

    /**
     * Register user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public static function userRegister(Request $request)
    {

        $is_register = false;
        $user = User::where('email', $request->email)->first();
        if ($user) {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'You have an account, Please login with same credentials.',
                    'type' => 'unauthorized',
                ],
                200
            );
        } else {
            $is_register = true;
            $input = array_merge(
                $request->except(['_token']),
                [
                    'meter_id' => $request->meter_id,
                    'manager_id' => $request->manager_id,
                    'username' => $request->username,
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'latitude' => $request->latitude,
                    'longitude' => $request->longitude,
                    'address' => $request->address,
                    'image' => $request->image,
                    'emo_expert' => $request->emo_expert,
                    'password' => Hash::make($request->password),
                    'c_password' => Hash::make($request->c_password),
                    'about' => $request->about,
                    'role' => $request->role,
                    'fcm_token' => $request->fcm_token,
                    'status' => 0,

                ]
            );

            if (!empty($input['image'])) {
                $image = FileService::ImageUploader($request, 'image', 'employees/image/');
                $input['image'] = json_encode($image);
            }

            if (!empty($input['profile'])) {
                $picture = FileService::imageUploader($request, 'profile', 'profile/image/');
                $input['profile'] = $picture;
            }

            $user = UserService::create($input);

            $token = auth('api')->login($user, ['exp' => Carbon::now()->addDays(120)->timestamp]);
            if (!$token) {
                return response()->json(
                    [
                        'status' => false,
                        'message' => 'unauthorized',
                        'type' => 'unauthorized',
                    ],
                    200
                );
            }

            $user = JWTAuth::setToken($token)->toUser();

            if (!empty($user->profile)) {
                $user->profile = FileService::image_path($user->profile);
            }

            if ($user->status == 0) {
                return response()->json(
                    [
                        'status' => true,
                        'message' => 'User Registerd Successfully',
                        'is_register' => $is_register,
                        'token' => $token,

                    ],
                    200
                );

            } else {
                return response()->json(
                    [
                        'status' => false,
                        'message' => 'Deactive user',
                        'type' => 'unauthorized',
                    ],
                    200
                );
            }
        }
    }
    //User Update
    public static function userUpdate(Request $request, $id)
    {

        $input = array();
        if (!empty($request->meter_id)) {
            $input['meter_id'] = $request->meter_id;
        }
        //  if(!empty($request->meter_id))
        //  {
        //  $input['meter_id']=$request->meter_id;
        //  }
        //  if(!empty($request->manager_id))
        //  {
        //  $input['manager_id']=$request->manager_id;
        //  }
        //  if(!empty($request->username))
        //  {
        //  $input['username']=$request->username;
        //  }
        //  if(!empty($request->name))
        //  {
        //  $input['name']=$request->name;
        //  }
        //  if(!empty($request->email))
        //  {
        //  $input['email']=$request->email;
        //  }
        //  if(!empty($request->phone))
        //  {
        //  $input['phone']=$request->phone;
        //  }
        //  if(!empty($request->about))
        //  {
        //  $input['about']=$request->about;
        //  }
        //  if(!empty($request->password))
        //  {
        //  $input['password']=$request->password;
        //  }
        //  if(!empty($request->c_password))
        //  {
        //  $input['c_password']=$request->c_password;
        //  }
        //  if(!empty($request->status))
        //  {
        //  $input['status']=$request->status;
        //  }
        //  if(!empty($request->role))
        //  {
        //  $input['role']=$request->role;
        //  }

        //  $result = DB::table('users')->whereId($id)->update($input);
        $result = User::where('id', auth()->user()->id)->update($input);
        if ($result) {
            return response()->json(
                [
                    'status' => true,
                    'message' => 'Profile Update Successfully',

                ],
                200
            );
        } else {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Profile not Updated',
                    'data' => [],
                ],
                200
            );
        }
    }
    //list
    public static function UserList()
    {

        // $status = DB::table('users')->get();
        $status = DB::select('select * from users where role = :role', ['role' => 0]);

        if (count($status) > 0) {
            return response()->json(
                [
                    'status' => true,
                    'message' => 'Data Find successfully',
                    'data' => $status,
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Data not Found',
                    'data' => [],
                ],
                200
            );
        }
    }

    /**
     * Send Otp
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public static function sendOtp(Request $request)
    {

        $user = ServiceRequestModel::where('phone', $request->phone)->first();

        if ($user) {
            $otp = HelperService::createOtp();
            $input = [
                'phone' => $user->phone,
                'service_request_id' => $user->id,
                'otp' => $otp,
                'role' => 0,
            ];

            if (env('PRODUCTION', false)) {
                HelperService::sendMessage($request->phone, 'Your Verification OTP Is', $otp);
            } else {
                MasterOtp::create($input);

            }
            $input1['otp'] = $otp;
            $data = DB::table('service_request')->where('id', $request->service_request_id)->update($input1);

            $user_service = ServiceRequestModel::where('id', $request->service_request_id)->first();

            $input = [
                'notification' => 'OTP',
                'message' => 'Share the OTP with our Engineer' . ' ' . $otp,
                'user_id' => $user_service->user_id,
            ];

            NotificationService::create($input);
            // $data = DB::table('customertrack')->where('Service_request_id',$request->Service_request_id)->update($input1);

            return response()->json(
                [
                    'status' => true,

                    'message' => 'Otp Sent Successfully',

                ],
                200
            );
        } else {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Incorrect Phone Number',
                    'type' => 'unauthorized',
                ],
                200
            );

        }
    }

/**
 * Verify Otp
 *
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\Response
 */
    public static function verifyOtp(Request $request)
    {

        $request->validate([
            'otp' => 'required',
            'phone' => 'required',

        ]);

        $user = ServiceRequestModel::where('id', $request->service_request_id)->first();
        if ($user) {

            $data = ServiceRequestModel::where('id', $request->service_request_id)
                ->where('phone', $user->phone)
                ->where('otp', $request->otp)
                ->orderBy('created_at', 'desc')
                ->first();
            if (!empty($data)) {

                $old_track =
                    [
                    'status' => "2",
                ];
                $trackingold = TrackingModel::where('Service_request_id', $request->service_request_id)->where('text', 'Engineer Check-In')->update($old_track);

                $track =
                    [
                    'Service_request_id' => $request->service_request_id,
                    'text' => "Service in process",
                    'status' => 1,
                ];
                $tracking = TrackingModel::create($track);

                $resolved =
                    [
                    'Service_request_id' => $request->service_request_id,
                    'text' => "Resolved By Engineer",
                    'status' => 1,
                ];
                $trackingday = TrackingModel::create($resolved);
                // $service_request=TrackingModel::where('text',$track['text'])->get();
                // if(count($service_request)>0){
                // }else{
                //     $tracking = TrackingModel::create($track);
                // }
                $input = [];
                $input =
                    [
                    // 'Service_request_id' =>$request->service_request_id,
                    'status' => 2,
                ];
                $tracking = ServiceRequestModel::where('id', $request->service_request_id)->update($input);

                $service = ServiceRequestModel::where('id', $request->service_request_id)->first();

                if ($user) {

                    return response()->json(
                        [
                            'status' => true,
                            'message' => 'Verification successfully',
                            'data' => $service,
                        ],
                        200
                    );
                } else {

                    return response()->json(
                        [
                            'status' => false,
                            'message' => 'Deactive user',
                            'type' => 'unauthorized',
                        ],
                        200
                    );

                }
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Wrong OTP',
                    'errors' => ['otp' => ['Wrong OTP']],
                ], 200);
            }
        } else {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Unauthorized User',
                    'type' => 'unauthorized',
                ],
                200
            );

        }

    }

    /**
     * Get Profile By Token
     *
     * @return \Illuminate\Http\Response
     */

    public static function userProfile()
    {
        $profile = User::where('id', auth()->user()->id)->get();
        foreach ($profile as $data) {
            if (!empty($data->profile)) {
                $data->profile = FileService::image_path($data->profile);
            }
        }

        if ($profile) {
            return response()->json(
                [
                    'status' => true,
                    'message' => 'Profile Find successfully',
                    'data' => $profile,

                ],
                200
            );
        } else {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Data not Found',
                    'data' => [],
                ],
                200
            );
        }
    }

    /**
     * API For Forget Password
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public static function forgetPassword(Request $request)
    {
        try {

            $user = User::where('email', $request->email)->first();

            if ($user) {

                $token = Str::random(40);
                $domain = url('/');
                $url = $domain . '/reset-password?token=' . $token;

                $details['url'] = $url;
                $details['email'] = $request->email;
                $details['title'] = "Password Reset";
                $details['body'] = "Please click on below link to reset your password";

                UserService::send_forgetmail($details, $request->email);

                $datetime = Carbon::now()->format('Y-m-d H:i:s');
                PasswordReset::updateorCreate(
                    ['email' => $request->email],
                    [
                        'email' => $request->email,
                        'token' => $token,
                        'created_at' => $datetime,
                    ]
                );

                return response()->json([
                    'status' => true,
                    'message' => 'Pleasen Check your mail to reset your password.!',
                ]);

            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'User Not Found!',
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

/**
 * Get All User Insert
 *
 * @return \Illuminate\Http\Response
 */

    public static function allUserintrest(Request $request)
    {

        $header = $request->header('Accept-Language');

        $languge_id = $header == "en-Us" ? 0 : 1;

        if ($languge_id == 0) {
            $intrest = DB::table('user_intrests')
                ->select('*', 'user_intrests.adv_english as intrest_name')
                ->where('status', '0')
                ->get();
        } else {
            $intrest = DB::table('user_intrests')
                ->select('*', 'user_intrests.adv_french as intrest_name')
                ->where('status', '0')
                ->get();
        }
        if (!empty($intrest)) {
            return response()->json(
                [
                    'status' => true,
                    'message' => 'Data Find Successfully',
                    'data' => $intrest,
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Data Not Found',
                    'data' => [],
                ],
                200
            );
        }

    }

/**
 * Get Adventure By User Intrest
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\Response
 */

    public static function adventureByuserIntrest(Request $request)
    {

        $header = $request->header('Accept-Language');

        $languge_id = $header == "en-Us" ? 0 : 1;

        if ($languge_id == 0) {
            $adventure_data = DB::table('adventures')
                ->select('*', 'adventures.id as id', 'adventures.name_eng as adventure_name', 'user_intrests.adv_english as adv_intrest', 'adventures.discription_eng as avd_discription', 'adventures.highlight_eng as highlights')
                ->join('user_intrests', 'user_intrests.id', '=', 'adventures.intrest')
                ->where('user_intrests.status', '0')
                ->where('adventures.intrest', $request->user_intrest)
                ->orderBy('adventures.id', 'desc')
                ->get();
        } else {
            $adventure_data = DB::table('adventures')
                ->select('*', 'adventures.id as id', 'adventures.name_fren as adventure_name', 'user_intrests.adv_french as adv_intrest', 'adventures.discription_fren as avd_discription', 'adventures.highlight_fren as highlights')
                ->join('user_intrests', 'user_intrests.id', '=', 'adventures.intrest')
                ->where('user_intrests.status', '0')
                ->where('adventures.intrest', $request->user_intrest)
                ->orderBy('adventures.id', 'desc')
                ->get();

        }

        foreach ($adventure_data as $result) {
            if (!empty($result->thumbnail)) {
                $result->thumbnail = FileService::image_path($result->thumbnail);
            }

            if (!empty($result->slider)) {
                $image_aws = [];
                foreach (json_decode($result->slider, true) as $image) {
                    array_push($image_aws, FileService::image_path($image));
                }
                $aws_multiple_slider = json_encode($image_aws);
                $result->slider = $aws_multiple_slider;
            }
            if (!empty($result->audio)) {
                $result->audio = FileService::image_path($result->audio);
            }
        }

        if ((count($adventure_data) > 0)) {
            return response()->json(
                [
                    'status' => true,
                    'message' => 'Data Find Successfully',
                    'data' => $adventure_data,
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Data Not Found',
                    'data' => [],
                ],
                200
            );
        }

    }

    /**
     * Update User Profile
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public static function profileUpdate(Request $request)
    {

        $input = array();
        if (!empty($request->name)) {
            $input['name'] = $request->name;
        }
        if (!empty($request->email)) {
            $input['email'] = $request->email;
        }

        if (!empty($request->phone)) {
            $input['phone'] = $request->phone;
        }

        if (!empty($request->image)) {
            $profile = FileService::imageUploader($request, 'image', 'profile/image/');
            $input['image'] = $profile;

        }

        $result = User::where('id', auth()->user()->id)->update($input);
        if ($result) {
            return response()->json(
                [
                    'status' => true,
                    'message' => 'Profile Update Successfully',

                ],
                200
            );
        } else {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Profile not Updated',
                    'data' => [],
                ],
                200
            );
        }
    }

    //Api For Update Push_Notification
    public static function updatePushNotification(Request $request)
    {

        $request->validate([
            'push_notification' => 'required',

        ]);
        $data = array('push_notification' => $request->push_notification);

        $result = DB::table('users')->where('id', auth()->user()->id)->update($data);

        if ($result) {
            return response()->json(
                [
                    'status' => true,
                    'message' => 'Push Notification Update Successfully',

                ],
                200
            );
        } else {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Data not  Updated',
                    'data' => [],
                ],
                200
            );
        }
    }

    public static function logouttest(Request $request)
    {
        self::getAuthUser();
        JWTAuth::invalidate(JWTAuth::getToken());
        return response()->json([
            'status' => true,
            'message' => 'Successfully logged out',
        ]);
    }

    public static function getAuthUsertest()
    {
        return JWTAuth::parseToken()->authenticate();
    }

    public static function steamlogout(Request $request)
    {
        $data=self::steamAuth();
        
        if($data){
            $input = array();
            $input['fcm_token'] = NULL;
       

        $updatedata = DB::table('users')->where('id',$data->id)->update($input);
        }
        JWTAuth::invalidate(JWTAuth::getToken());
        return response()->json([
            'status' => true,
            'message' => 'Successfully logged out',
        ]);
    }

    public static function steamAuth()
    {
        return JWTAuth::parseToken()->authenticate();
    }

// ----------------------------------------------------------------------------------------------

//Customer Feedback

    //Add
    public static function ReviewRatingServices(Request $request)
    {

        $input =
            [
            'Service_request_id' => $request->Service_request_id,
            'customer_feedback_id' => auth()->user()->id,
            'star' => $request->star,
            'discription' => $request->discription,
        ];

        $review = CustomerFeedbackModel::create($input);

        // if (count($review)>0)
        if ($review) {
            return response()->json(
                [
                    'status' => true,
                    'message' => 'Data Insert successfully',
                    'data' => $review,
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Data not Inserted',
                    'data' => [],
                ],
                200
            );
        }
    }

    public static function ReviewRatingServiceslist(Request $request)
    {
        // $status=CustomerFeedbackModel::where('id',$request->ID)->get();

        $status = DB::table('customerfeedback')->where('id', $request->ID)->get();

        if (count($status) > 0) {
            return response()->json(
                [
                    'status' => true,
                    'message' => 'Data Find successfully',
                    'data' => $status,
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Data not Found',
                    'data' => [],
                ],
                200
            );
        }
    }
    // update
    public static function customerfeedbackupdate(Request $request, $id)
    {

        $input = array();
        if (!empty($request->Service_request_id)) {
            $input['Service_request_id'] = $request->Service_request_id;
        }
        if (!empty($request->star)) {
            $input['star'] = $request->star;
        }
        if (!empty($request->discription)) {
            $input['discription'] = $request->discription;
        }

        $updatedata = DB::table('customerfeedback')->where('id', $id)->update($input);
        // $result = ServiceRequestModel::where('id',auth()->user()->id)->update($input);
        if ($updatedata) {
            return response()->json(
                [
                    'status' => true,
                    'message' => 'Profile Update Successfully',

                ],
                200
            );
        } else {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Profile not Updated',
                    'data' => [],
                ],
                200
            );
        }
    }

    public static function updateServiceRequestStatus(Request $request, $id)
    {

        $input = array();
        if (!empty($request->Service_request_id)) {
            $input['status'] = $request->status;
        }

        $updatedata = DB::table('service_request')->where('id', $id)->update($input);
        // $result = ServiceRequestModel::where('id',auth()->user()->id)->update($input);
        if ($updatedata) {
            return response()->json(
                [
                    'status' => true,
                    'message' => 'Data Update Successfully',

                ],
                200
            );
        } else {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Data not Updated',
                    'data' => [],
                ],
                200
            );
        }
    }

//Services Request

    //Add Compla+in
    public static function servicesrequestapi(Request $request)
    {
        $input =
            [
            'user_id' => auth()->user()->id,
            'emp_id' => $request->emp_id,
            'manger_id' => $request->manger_id,
            'Service_request' => $request->Service_request,
            'phone' => $request->phone,
            'discription' => $request->discription,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'address' => $request->address,
            'status' => $request->status,
            'otp' => $request->otp,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];

        if (!empty($request->pictures)) {
            $picture = FileService::multipleImageUploader($request, 'pictures', 'servicerequests/image/');
            $input['pictures'] = json_encode($picture);

        }

        $servicerequest = ServiceRequestModel::create($input);

        $input = [
            'notification' => auth()->user()->name,
            'message' => 'A new service request for ' . auth()->user()->name . ' is raised',
            'user_id' => $request->manger_id,
        ];

        NotificationService::create($input);

        $userss = DB::table('users')->where('id', $servicerequest->user_id)->select('name', 'address', 'phone')->first();
        $location = DB::table('users')->select('location.location')->join('location', 'location.location_id', '=', 'users.address')->where('users.id', $servicerequest->user_id)->first();

        $track =
            [
            'Service_request_id' => $servicerequest->id,
            'text' => "Ticket Generated," . "$userss->name," . "$userss->phone,",
            'status' => "2",
            'created_at' => date('Y-m-d H:i:s'),

        ];
        $tracking = TrackingModel::create($track);
        $track =
            [
            'Service_request_id' => $servicerequest->id,
            'text' => "Pending For Assignment",
            'status' => "1",
            'created_at' => date('Y-m-d H:i:s'),
        ];
        $tracking = TrackingModel::create($track);

        if ($servicerequest) {
            return response()->json(
                [
                    'status' => true,
                    'message' => 'Data Insert successfully',
                    'data' => $servicerequest,
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Data not Inserted',
                    'data' => [],
                ],
                200
            );
        }
    }
// List BY All
    public static function ServiceRequestServicelist()
    {

        $status = DB::table('service_request')->orderBy('created_at', 'desc')->get();
        // print_r($status);
        // die;
        // $status=DB::table('service_request')
        // ->select('*')
        // ->where('service_request.otp',$request->UserId)->orderBy('created_at', 'desc')
        // ->get();

        foreach ($status as $data) {

            // if(!empty($status->pictures)){
            //     $image_aws=[];
            //             foreach(json_decode($consultant->pictures,true) as $users){
            //             array_push($image_aws,FileService::image_path($users));
            //             }
            //             $aws_multiple_certificate= json_encode($image_aws);
            //             $consultant->pictures= $aws_multiple_certificate;
            //         }
            // 'pictures' => $request->pictures,

            // $data->otp = DB::table('master_otps')->where('User_id',$data->id)->get();
            $data->managerfeedback = DB::table('managerfeedback')->where('manager_feedback_id', $data->id)->get();
            $data->customerfeedback = DB::table('customerfeedback')->where('customer_feedback_id', $data->id)->get();
        }

        if (count($status) > 0) {
            return response()->json(
                [
                    'status' => true,
                    'message' => 'Data Find successfully',
                    'data' => $status,
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Data not Found',
                    'data' => [],
                ],
                200
            );
        }
    }

    // list by UserId
    public static function ServiceRequestBYUserId(Request $request)
    {

        $status = DB::table('service_request')
            ->select('*')
            ->where('service_request.user_id', $request->UserId)->orderBy('created_at', 'desc')
            ->get();

        foreach ($status as $data) {
            // $data->otp= DB::table('master_otps')->select('otp')->where('service_request_id',$data->id)->orderBy('service_request_id', 'desc')->first();
            $data->employee = DB::table('users')->select('id', 'name', 'emo_expert', 'image', 'phone', 'latitude', 'longitude', 'address')->where('id', $data->emp_id)->where('role', '2')->get();
            $data->user = DB::table('users')->select('id', 'meter_id', 'name', 'address', 'phone')->where('id', $request->UserId)->get();
            $data->managerfeedback = DB::table('managerfeedback')->where('manager_feedback_id', $data->manger_id)->where('Service_request_id', $data->id)->get();
            $data->employeefeedback = DB::table('employee_feedback')->where('employee_id', $data->emp_id)->where('Service_request_id', $data->id)->get();
            $data->customerfeedback = DB::table('customerfeedback')->where('customer_feedback_id', $data->user_id)->where('Service_request_id', $data->id)->get();

        }

        if (count($status) > 0) {
            return response()->json(
                [
                    'status' => true,
                    'message' => 'Data Find successfully',
                    'data' => $status,
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Data not Found',
                    'data' => [],
                ],
                200
            );
        }
    }
    // list by ManagerID
    public static function ServiceRequestBYManagerID(Request $request)
    {
        $status = DB::table('service_request')->where('manger_id', $request->ManagerID)->orderBy('id', 'DESC')->get();

        foreach ($status as $data) {

            $data->employee = DB::table('users')->select('id', 'name', 'emo_expert', 'image', 'phone')->where('id', $data->emp_id)->where('role', '2')->get();

            $data->user = DB::table('users')->select('*')
                ->where('id', $data->user_id)
                ->where('role', '0')
                ->get();

            $data->managerfeedback = DB::table('managerfeedback')->where('manager_feedback_id', $data->manger_id)->where('Service_request_id', $data->id)->get();
            $data->customerfeedback = DB::table('customerfeedback')->where('customer_feedback_id', $data->user_id)->where('Service_request_id', $data->id)->get();
            $data->employeefeedback = DB::table('employee_feedback')->where('employee_id', $data->emp_id)->where('Service_request_id', $data->id)->get();
        }
        // if (!empty($status))
        if (!empty($status)) {

            return response()->json(
                [
                    'status' => true,
                    'message' => 'Data Find successfully',
                    'data' => $status,
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Data not Found',
                    'data' => [],
                ],
                200
            );
        }
    }
    // list by EmpId
    public static function ServiceRequestBYEmpId(Request $request)
    {

        if ($request->EmpId != '') {

            $status = DB::table('service_request')->where('emp_id', $request->EmpId)->orderBy('id', 'DESC')->get();

            foreach ($status as $data) {

                $data->managerfeedback = DB::table('managerfeedback')->where('manager_feedback_id', $data->manger_id)->where('Service_request_id', $data->id)->get();
                $data->user = DB::table('users')->select('*')
                    ->where('id', $data->user_id)
                    ->where('role', '0')
                    ->get();

                $data->customerfeedback = DB::table('customerfeedback')->where('customer_feedback_id', $data->user_id)->where('Service_request_id', $data->id)->get();
                $data->employeefeedback = DB::table('employee_feedback')->where('Service_request_id', $data->id)->where('employee_id', $request->EmpId)->get();

            }
            if (!empty($status)) {
                return response()->json(
                    [
                        'status' => true,
                        'message' => 'Data Find successfully',
                        'data' => $status,
                    ],
                    200
                );
            } else {
                return response()->json(
                    [
                        'status' => false,
                        'message' => 'Data not Found',
                        'data' => [],
                    ],
                    200
                );
            }
        }

    }

    // update
    public static function servicesrequeststatusupdate(Request $request, $id)
    {

        $data = DB::table('service_request')->where('id', $id)->where('emp_id', $request->emp_id)->first();

        if (!empty($data)) {
            return response()->json(
                [
                    'status' => true,
                    'message' => 'Status Update Successfully',
                    'data' => $data,
                ],
                200
            );
        }

        $input = array();
        if (!empty($request->emp_id)) {
            $input['emp_id'] = $request->emp_id;
        }
        if (!empty($request->status)) {
            $input['status'] = $request->status;
        }

        $inputdata = DB::table('service_request')->where('id', $id)->update($input);
        $userdata = DB::table('service_request')->where('id', $id)->first();
        $user = DB::table('users')->where('id', $userdata->user_id)->first();
        $engineer = DB::table('users')->where('id', $request->emp_id)->first();

        $new = [
            'notification' => $user->name,
            'message' => 'A new service request for ' . $user->name . ' is assigned to you',
            'user_id' => $request->emp_id,
        ];

        $employee_notification = NotificationService::create($new);
        $input = [
            'notification' => 'Engineer Assigned',
            'message' => $engineer->name . ' is assigned for your service request',
            'user_id' => $userdata->user_id,
        ];

        NotificationService::create($input);

        $emp = DB::table('users')->where('id', $request->emp_id)->select('name', 'phone')->first();

        $track =
            [
            'Service_request_id' => $id,
            'text' => "Assign To Engineer," . "$emp->name," . "$emp->phone",
            'status' => 2,
        ];
        $tracking = TrackingModel::create($track);

        $old_track =
            [
            'status' => "2",
        ];
        $trackingold = TrackingModel::where('Service_request_id', $id)->where('text', 'Pending For Assignment')->update($old_track);

        $track =
            [
            'Service_request_id' => $id,
            'text' => "Engineer Check-In",
            'status' => 1,
        ];
        $tracking = TrackingModel::create($track);

        if ($inputdata) {
            return response()->json(
                [
                    'status' => true,
                    'message' => 'Status Update Successfully',
                    'data' => $inputdata,
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Data not Updated',
                    'data' => [],
                ],
                200
            );
        }

    }
    public static function servicesrequestupdate(Request $request, $id)
    {

        $input = array();
        if (!empty($request->emp_id)) {
            $input['emp_id'] = $request->emp_id;
        }
        if (!empty($request->manger_id)) {
            $input['manger_id'] = $request->manger_id;
        }
        if (!empty($request->Service_request)) {
            $input['Service_request'] = $request->Service_request;
        }
        if (!empty($input['pictures'])) {
            $pictures = FileService::multipleImageUploader($request, 'pictures', 'servicerequests/image/');
            $input['pictures'] = json_encode($pictures);
        }
        if (!empty($request->phone)) {
            $input['phone'] = $request->phone;
        }
        if (!empty($request->discription)) {
            $input['discription'] = $request->discription;
        }
        if (!empty($request->latitude)) {
            $input['latitude'] = $request->latitude;
        }
        if (!empty($request->longitude)) {
            $input['longitude'] = $request->longitude;
        }
        if (!empty($request->address)) {
            $input['address'] = $request->address;
        }

        $inputdata = DB::table('service_request')->where('id', $id)->update($input);
        $employee_details = DB::table('service_request')->where('emp_id', $request->emp_id)->get();
        if ($inputdata) {
            return response()->json(
                [
                    'status' => true,
                    'message' => 'Status Update Successfully',
                    'employe_data' => $employee_details,
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Data not Updated',
                    'data' => [],
                ],
                200
            );
        }
    }

//steam house(home)
    //list
    public static function steamhouseservicelist()
    {

        $status = DB::table('steamhouse')->get();

        if (count($status) > 0) {
            return response()->json(
                [
                    'status' => true,
                    'message' => 'Data Find successfully',
                    'data' => $status,
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Data not Found',
                    'data' => [],
                ],
                200
            );
        }
    }

    //Map List
    //list
    public static function locationslist()
    {

        $status = DB::table('location')->get();

        if (count($status) > 0) {
            return response()->json(
                [
                    'status' => true,
                    'message' => 'Data Find successfully',
                    'data' => $status,
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Data not Found',
                    'data' => [],
                ],
                200
            );
        }
    }
    //Add
    public static function locationsapiadd(Request $request)
    {

        $input =
            [
            'location' => $request->location,

        ];

        $location = LocationModel::create($input);

        if ($location) {
            return response()->json(
                [
                    'status' => true,
                    'message' => 'Data Insert successfully',
                    'data' => $location,
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Data not Inserted',
                    'data' => [],
                ],
                200
            );
        }
    }
    //Company List
    //list
    public static function companylistsapilist(Request $request)
    {

        $status = User::where('manager_id', $request->ManagerID)->where('role', '0')->orderBy('created_at', 'desc')->get();
        // $status = DB::table('company_list')->get();

        if (count($status) > 0) {
            return response()->json(
                [
                    'status' => true,
                    'message' => 'Data Find successfully',
                    'data' => $status,
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Data not Found',
                    'data' => [],
                ],
                200
            );
        }
    }
    //Add
    public static function companylistsaddapi(Request $request)
    {

        $input =
            [
            'company_name' => $request->company_name,
            'location' => $request->location,
            'manager_id' => $request->manager_id,

        ];

        // $company = CompanyListModel::create($input);
        $company = User::create($input);

        if ($company) {
            return response()->json(
                [
                    'status' => true,
                    'message' => 'Data Insert successfully',
                    'data' => $company,
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Data not Inserted',
                    'data' => [],
                ],
                200
            );
        }
    }

    //Tracker Status
    //list
    public static function trackingstatuslistapi(Request $request)
    {

        // $status = DB::table('customertrack')->get();
        $status = DB::table('customertrack')->where('Service_request_id', $request->Service_request_id)->orderBy('created_at', 'desc')->get();

        if (!empty($status)) {
            return response()->json(
                [
                    'status' => true,
                    'message' => 'Data Find successfully',
                    'data' => $status,
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Data not Found',
                    'data' => [],
                ],
                200
            );
        }
    }
    //Add
    public static function trackingstatusapi(Request $request)
    {

        $input =
            [
            'Service_request_id' => $request->Service_request_id,
            'service_generated' => $request->service_generated,
            'Pending_assignment' => $request->Pending_assignment,
            'assign_engineer' => $request->assign_engineer,
            'engineer_checkin' => $request->engineer_checkin,
            'service_process' => $request->service_process,
            'solve_by_engineer' => $request->solve_by_engineer,
            'service_closed' => $request->service_closed,

        ];

        $trackingservice = TrackingModel::create($input);
        // $result=DB::table('service_request')->where('phone', $request->phone)->update(array('otp' => $otp));

        if ($trackingservice) {
            return response()->json(
                [
                    'status' => true,
                    'message' => 'Data Insert successfully',
                    'data' => $trackingservice,
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Data not Inserted',
                    'data' => [],
                ],
                200
            );
        }
    }
    // update

    //Manager Feedback
    //list
    public static function managerfeedbackslistapi()
    {

        $status = DB::table('managerfeedback')->get();

        if (count($status) > 0) {
            return response()->json(
                [
                    'status' => true,
                    'message' => 'Data Find successfully',
                    'data' => $status,
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Data not Found',
                    'data' => [],
                ],
                200
            );
        }
    }
    //Add
    public static function managerfeedbacksapi(Request $request)
    {

        $input =
            [
            'Service_request_id' => $request->Service_request_id,
            'manager_feedback_id' => $request->manager_feedback_id,
            'discription' => $request->discription,
        ];
        $managerfeedback = ManagerFeedbackModel::create($input);
        $closedticket =
            [
            'status' => 2,

        ];
        $service_request = TrackingModel::where('Service_request_id', $request->Service_request_id)->where('text', "Service Request Closed")->update($closedticket);

        $manager_service = ServiceRequestModel::where('id', $request->Service_request_id)->first();
        $input = [
            'notification' => 'Request resolved',
            'message' => 'Your service request has been resolved. Please share your feedback.',
            'user_id' => $manager_service->user_id,
        ];

        NotificationService::create($input);

        $service_status =
            [
            'status' => 4,
        ];
        $feedback = ServiceRequestModel::where('id', $request->Service_request_id)->update($service_status);

        if ($managerfeedback) {
            return response()->json(
                [
                    'status' => true,
                    'message' => 'Data Insert successfully',
                    'data' => $managerfeedback,
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Data not Inserted',
                    'data' => [],
                ],
                200
            );
        }
    }
    // update
    public static function managerfeedbackupdate(Request $request, $id)
    {

        $input = array();
        if (!empty($request->Service_request_id)) {
            $input['Service_request_id'] = $request->Service_request_id;
        }
        if (!empty($request->discription)) {
            $input['discription'] = $request->discription;
        }

        $updatedata = DB::table('managerfeedback')->where('id', $id)->update($input);
        // $result = ServiceRequestModel::where('id',auth()->user()->id)->update($input);
        if ($updatedata) {
            return response()->json(
                [
                    'status' => true,
                    'message' => 'Profile Update Successfully',

                ],
                200
            );
        } else {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Profile not Updated',
                    'data' => [],
                ],
                200
            );
        }
    }
    //Employee Feedback
    //list
    public static function employeefeedbacklistapi()
    {

        $status = DB::table('employee_feedback')->get();

        if (count($status) > 0) {
            return response()->json(
                [
                    'status' => true,
                    'message' => 'Data Find successfully',
                    'data' => $status,
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Data not Found',
                    'data' => [],
                ],
                200
            );
        }
    }
    //Add
    public static function employeefeedbackaddapi(Request $request)
    {

        $request->validate([
            'pictures' => 'required',
        ]);

        $input =
            [
            'Service_request_id' => $request->Service_request_id,
            'employee_id' => $request->employee_id,
            'pictures' => $request->pictures,
            'remark' => $request->remark,

        ];
        if (!empty($input['pictures'])) {
            $pictures = FileService::multipleImageUploader($request, 'pictures', 'employeefeedback/image/');
            $input['pictures'] = json_encode($pictures);
        }

        $employeefeedback = EmployeeFeedbackModel::create($input);

        $service =
            [
            'status' => 2,
        ];

        $service_request = TrackingModel::where('Service_request_id', $request->Service_request_id)->where('text', "Service in process")->update($service);

        $resolve =
            [
            'status' => 2,
        ];

        $service_request = TrackingModel::where('Service_request_id', $request->Service_request_id)->where('text', "Resolved by Engineer")->update($resolve);

        $closed =
            [
            'Service_request_id' => $request->Service_request_id,
            'text' => "Service Request Closed",
            'status' => 1,
        ];

        $service_request = TrackingModel::create($closed);
        $manager_service = ServiceRequestModel::where('id', $request->Service_request_id)->first();
        $input = [
            'notification' => 'Work Complete',
            'message' => 'The Engineer has completed the work. Please check and close the ticket.',
            'user_id' => $manager_service->manger_id,
        ];

        NotificationService::create($input);

        $service_status =
            [
            'status' => 3,
        ];
        $feedback = ServiceRequestModel::where('id', $request->Service_request_id)->update($service_status);

        // if(count($service_request)>0){

        // }else{
        //     $tracking = TrackingModel::create($track);
        // }

        if ($employeefeedback) {
            return response()->json(
                [
                    'status' => true,
                    'message' => 'Data Insert successfully',
                    'data' => $employeefeedback,
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Data not Inserted',
                    'data' => [],
                ],
                200
            );
        }
    }
    // update
    public static function employeefeedbackupdate(Request $request, $id)
    {

        $input = array();
        if (!empty($request->Service_request_id)) {
            $input['Service_request_id'] = $request->Service_request_id;
        }
        if (!empty($request->discription)) {
            $input['discription'] = $request->discription;
        }

        $updatedata = DB::table('employee_feedback')->where('id', $id)->update($input);
        // $result = ServiceRequestModel::where('id',auth()->user()->id)->update($input);
        if ($updatedata) {
            return response()->json(
                [
                    'status' => true,
                    'message' => 'Profile Update Successfully',

                ],
                200
            );
        } else {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Profile not Updated',
                    'data' => [],
                ],
                200
            );
        }
    }
    //Employee
    //list
    public static function employeeslistapi(Request $request)
    {

        // $status = DB::table('users')->get();
        // $status = DB::select('select * from users where role = :role', ['role' => 2]);
        $data = DB::table('users')->where('id', auth()->user()->id)->first();

        $status = DB::table('users')->where('manager_id', $data->id)->where('role', 2)->get();
        if (count($status) > 0) {
            return response()->json(
                [
                    'status' => true,
                    'message' => 'Data Find successfully',
                    'data' => $status,
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Data not Found',
                    'data' => [],
                ],
                200
            );
        }
    }
    //Add
    public static function employeesapi(Request $request)
    {

        $input =
            [
            'manager_id' => $request->manager_id,
            'location_id' => $request->location_id,
            'manager' => $request->manager,
            'location' => $request->location,
            'emo_name' => $request->emo_name,
            'emp_img' => $request->emp_img,
            'emo_expert' => $request->emo_expert,
            'emo_contact' => $request->emo_contact,
        ];
        if (!empty($input['emp_img'])) {
            $emp_img = FileService::ImageUploader($request, 'emp_img', 'employees/image/');
            $input['emp_img'] = json_encode($emp_img);
        }

        //Changes when server is down
        // $employee = EmployeeModel::create($input);
        $employee = User::create($input);

        if ($employee) {
            return response()->json(
                [
                    'status' => true,
                    'message' => 'Data Insert successfully',
                    'data' => $employee,
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Data not Inserted',
                    'data' => [],
                ],
                200
            );
        }
    }
    // update

    public static function editProfile(Request $request)
    {

        $request->validate([
            'old_password' => '',

        ]);

        $input = array();

        if (!empty($request->phone)) {
            $input['phone'] = $request->phone;
        }
        if (!empty($request->email)) {
            $input['email'] = $request->email;
        }
        if (!empty($request->c_address)) {
            $input['c_address'] = $request->c_address;
        }

        if (!empty($request->old_password)) {

            if (!Hash::check($request->old_password, auth()->user()->password)) {
                // return back()->with("error", "Old Password Doesn't match!");
                return response()->json(
                    [
                        'status' => false,
                        'message' => "Old Password Doesn't match!'",

                    ],
                    200
                );
            }
            $input['password'] = Hash::make($request->new_password);

        }

        $result = User::where('id', auth()->user()->id)->update($input);
        $user_details = User::where('id', auth()->user()->id)->first();
        if ($result) {
            return response()->json(
                [
                    'status' => true,
                    'message' => 'Profile Update Successfully',
                    'data' => $user_details,
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Profile not Updated',
                    'data' => [],
                ],
                200
            );
        }
    }

    //Customer Data (Live DAta)
    //list
    public static function customerdataslistapi()
    {

        $status = DB::table('customerdata')->get();

        if (count($status) > 0) {
            return response()->json(
                [
                    'status' => true,
                    'message' => 'Data Find successfully',
                    'data' => $status,

                ],
                200
            );
        } else {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Data not Found',
                    'data' => [],
                ],
                200
            );
        }
    }
    //Add
    public static function customerdatasapi(Request $request)
    {

        $input =
            [
            'customer_name' => $request->customer_name,
            'flow' => $request->flow,
            'pressure' => $request->pressure,
            'temprature' => $request->temprature,
            'totalizer' => $request->totalizer,
            'Last_reading_time' => $request->Last_reading_time,

        ];

        $customerdata = CustomerDataModel::create($input);

        if ($customerdata) {
            return response()->json(
                [
                    'status' => true,
                    'message' => 'Data Insert successfully',
                    'data' => $customerdata,
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Data not Inserted',
                    'data' => [],
                ],
                200
            );
        }
    }
    // update
    public static function customerdatasupdate(Request $request, $id)
    {

        $input = array();
        if (!empty($request->customer_name)) {
            $input['customer_name'] = $request->customer_name;
        }

        if (!empty($request->flow)) {
            $input['flow'] = $request->flow;
        }

        if (!empty($request->pressure)) {
            $input['pressure'] = $request->pressure;
        }

        if (!empty($request->temprature)) {
            $input['temprature'] = $request->temprature;
        }

        if (!empty($request->totalizer)) {
            $input['totalizer'] = $request->totalizer;
        }
        if (!empty($request->Last_reading_time)) {
            $input['Last_reading_time'] = $request->Last_reading_time;
        }

        //   $updatedata = CustomerDataModel::where('id',auth()->user()->id)->update($input);
        // $updatedata = CustomerDataModel::where('id',auth()->user()->id)->update($input);
        // $updatedata = DB::table('customerdata')->whereId($id)->update($input);
        $updatedata = DB::table('customerdata')->where('id', $id)->update($input);

        if ($updatedata) {
            return response()->json(
                [
                    'status' => true,
                    'message' => 'Profile Update Successfully',

                ],
                200
            );
        } else {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Profile not Updated',
                    'data' => [],
                ],
                200
            );
        }
    }

    public static function livedata()
    {

        $livedata = DB::table('livedata')->get();

        if (!empty($livedata)) {
            return response()->json(
                [
                    'status' => true,
                    'message' => 'Data Find successfully',
                    'data' => json_decode($livedata),
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Data not Found',
                    'data' => [],
                ],
                200
            );
        }
    }

}
