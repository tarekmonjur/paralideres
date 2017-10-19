<?php

namespace App\Http\Controllers\Auth;

use App\Service\CommonService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use App\Http\Requests\Auth\AuthenticateRequest;
use App\Http\Controllers\Web\WebController;

class LoginController extends WebController
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

    use ThrottlesLogins, CommonService;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware('guest')->except('logout');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }


    public function authenticate(AuthenticateRequest $request)
    {
        if($request->has('login')) {
            // User is locked out
            if ($lockedOut = $this->hasTooManyLoginAttempts($request)) {
                $this->fireLockoutEvent($request);
                return $this->sendLockoutResponse($request);
            }

            // grab credentials from the request
            if ($request->has('username')) {
                $username = 'username';
            } else {
                $username = 'email';
            }
            $credentials = $request->only($username, 'password');

            if ($this->guard()->attempt($credentials, true)) {
                $user = Auth::user();
                $success['access_token'] = $user->createToken(env('PASSPORT_CLIENT_SECRET'))->accessToken;
                return $this->setResponse($success, 'success', 'OK', '200', 'Success!', 'Welcome ' . env('APP_NAME'));
            } else {
                $this->incrementLoginAttempts($request);
                return $this->setResponse([], 'error', 'NotOK', '500', 'Error!', $username . '/password invalid');
            }
        }
    }

    /**
     * Redirect the user after determining they are locked out.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendLockoutResponse(Request $request)
    {
        $seconds = $this->secondsRemainingOnLockout($request);

        return response()->json($this->getLockoutErrorMessage($seconds), 403);
    }


    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return property_exists($this, 'username') ? $this->username : 'email';
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->flush();

        $request->session()->regenerate();

        return redirect('/');
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('web');
    }



}
