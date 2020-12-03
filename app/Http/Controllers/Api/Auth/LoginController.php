<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class LoginController extends Controller
{
	/**
	 * get token for api authentication
	 * @param Request   $request 
	 * 
	 * @return Response
	 */
	public function store(Request $request) {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string'
        ]);

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

    /**
     * Revoke session token to termine user's session
     * 
     * @return Response
     */
    public function destroy(Request $request) {
        $request->user()->token()->revoke();

        return response()->noContent();
    }
}
