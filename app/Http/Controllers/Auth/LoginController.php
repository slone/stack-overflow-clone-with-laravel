<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Route;

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
    protected $redirectTo = RouteServiceProvider::HOME;

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
	 * get token for api authentication
	 * @param Request   $request 
	 * 
	 * @return Response
	 */
	public function getToken(Request $request) {
		$request->request->add([
			'grant_type' => 'password',
			'client_id' => 4, 
			'client_secret' => 'eVTjWLbHadYDXvFi4mQAesjpNlzMblbgVDnFUMue',
			'username' => $request->username,
			'password' => $request->password,
		]);

		$requestToken = Request::create(env('APP_URL') . '/oauth/token', 'post');
		$response = Route::dispatch($requestToken);

		return $response;
	}
}

/**
 * 
 * Personal access client created successfully.
 * Client ID: 3
 * Client secret: zGbU894f2XHfOnKslN34eCUAS3YQhXQvwySP6iwc
 * Password grant client created successfully.
 * Client ID: 4
 * Client secret: eVTjWLbHadYDXvFi4mQAesjpNlzMblbgVDnFUMue
 * 
 */