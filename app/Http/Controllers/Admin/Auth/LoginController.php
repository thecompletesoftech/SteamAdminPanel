<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::ADMIN_HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if ($user->hasRole(roleName('admin'))) {

                return redirect()->intended('admin/dashboard');
            } else {
                Auth::logout();
                return redirect()->route('admin.login')->with('error', 'Opps! You are unauthorized user.');
            }
        }

        return redirect()->route('admin.login')->with('error', 'Opps! You have entered invalid credentials');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        // $request->session()->invalidate();
        // $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }
    public function livedata(Request $request){
//  echo $request->getContent();die;
$employees = DB::connection('sqlsrv_secondary')
->select('
SELECT 
    MeterID,
    LocationName,
    CompanyName,
    LastReadingTime,
    Totalizer,
    Flow 
FROM (
    SELECT 
        r.MeterID,
        u.LocationName,
        u.CompanyName,
        r.LastReadingTime,
        r.Totalizer,
        r.Flow,
        ROW_NUMBER() OVER (
            PARTITION BY u.CompanyName 
            ORDER BY r.CreatedDate DESC
        ) AS row_num
    FROM 
        tbl_User_Mst u
    INNER JOIN 
        tbl_Meter_Reading_Mst r ON u.ID = r.MeterID
    WHERE 
        r.CreatedDate >= DATEADD(SECOND, -2, GETDATE())
) AS subquery
WHERE  
    row_num = 1
ORDER BY 
    MeterID ASC');
echo $employees;die;
        try {
       $input = [

                'livedata'=>$employees,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];

                $updatedata=DB::table('livedata')->where('id',1)->update($input);

        } catch (exception $e) {

            return response()->json('error', $e);

        }

    }

    protected function guard() // And now finally this is our custom guard name
    {
        return Auth::guard('admin');
    }
}
