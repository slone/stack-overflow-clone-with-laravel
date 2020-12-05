<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MyPostsController extends Controller
{
	/**
	 * Handle the incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function __invoke(Request $request)
	{
		if (env('APP_ENV')== 'local')	sleep(1.5);
		return response()->json([
			'data' => auth('api')->user()->posts()
//			'data' => $request->user()->posts()
		]);
	}
}
