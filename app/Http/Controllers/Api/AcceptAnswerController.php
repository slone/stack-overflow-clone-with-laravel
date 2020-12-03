<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use Illuminate\Http\Request;

class AcceptAnswerController extends Controller
{	
	public function __invoke(Answer $answer) {
		$this->authorize('accept', $answer);

		$answer->question->acceptBestAnswer($answer);
		
		return response()->json([
			'message' => 'You have accepted this answer as best answer',
		]);
	}
}
