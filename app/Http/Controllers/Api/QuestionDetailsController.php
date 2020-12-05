<?php

namespace App\Http\Controllers\Api;

use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\QuestionDetailsResource;

class QuestionDetailsController extends Controller
{
	/**
	 * Handle the incoming request.
	 *
	 * @return \Illuminate\Http\Response
	 */
	// public function __invoke($slug, $question_id = null)
	// {

	// 	$slug = rtrim($slug, '_'); // if the ID hasn't been appended to the slug, the separator sign "_" is included in the slug
	// 	$q_id = (int) $question_id;
	// 	$question = $q_id > 0 ? Question::find($q_id) : null;

	// 	if (is_null($question)) { // if question couldn't be found by ID, try by slug
	// 		$question = Question::with('user')->where('slug', $slug, '_')->first();
	// 	}
	// 	return $question ? new QuestionDetailsResource($question) : response()->json(['message' => 'not found'], 404);
	// }
	public function __invoke($slug)
	{
		if (env('APP_ENV')== 'local')		sleep(1.5);
		$question = Question::where('slug', $slug)->firstOrFail();
		$question->increment('views');
		return new QuestionDetailsResource($question);
	}
}
