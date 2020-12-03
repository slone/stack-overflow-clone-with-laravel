<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\Request;

class FavoritesController extends Controller
{

	public function store(Question $question) {
		$question->favorites()->attach(auth()->id());
		return response()->json(null, 204); // 204 means success but without any content to return
	}

	public function destroy(Question $question) {
		$question->favorites()->detach(auth()->id());
		return response()->json(null, 204);
	}
}
