<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;

class AnswersController extends Controller
{

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Question $question, Request $request)
	{
		$question->answers()->create(
			$request->validate([
				'body' => 'required',
			]) + [ 'user_id' => \Auth::id() ]);
		
		return back()->with('success', __('Your answer has been submitted successfully'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\Answer  $answer
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Question $question, Answer $answer)
	{
		$this->authorize('update', $answer);
		
		return view('answers.edit', compact('question', 'answer'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Models\Answer  $answer
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Question $question, Answer $answer)
	{
		$this->authorize('update', $answer);
		$answer->update($request->validate([
			'body' => 'required',
		]));

		if ($request->expectsJson()) {
			return response()->json([
				'message' => __('your answser has been modified'),
				'body_html' => $answer->body_html
			]);
		}

		// default uses route to view
		return redirect()->route('questions.show', $question->slug)->with('success', __('your answser has been modified'));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\Answer  $answer
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Question $question, Answer $answer)
	{
		$this->authorize('delete', $answer);

		$answer->delete();

		return back()->with('success', __('Your answer has been removed.'));
		
	}
}
