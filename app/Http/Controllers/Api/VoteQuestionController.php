<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\Request;

class VoteQuestionController extends Controller
{
	public function __construct() {
		$this->middleware('auth');
	}

	public function __invoke(Question $question) {
		$vote = (int) request()->vote;

		$votesCount = auth()->user()->voteQuestion($question, $vote);

		return response()->json([
			'message' => 'Thanks for the vote',
			'votesCount' => $votesCount,
			'voted' => $vote,
			'qId' => $question->id,
		]);
	}
}
