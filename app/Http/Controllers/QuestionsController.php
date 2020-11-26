<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Requests\AskQuestionRequest;

class QuestionsController extends Controller
{

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		// \DB::enableQueryLog();
		$questions = Question::with('user')->latest()->paginate(10);
		return view('questions.index', compact('questions'));

		// dd(\DB::getQueryLog());
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$question = new Question();

		return view('questions.create')->with('question', $question);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  App\Http\Requests\AskQuestionReques  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(AskQuestionRequest $request)
	{
		$request->user()->questions()->create($request->only('title', 'body'));
		return redirect()->route('questions.index')->with('success', __('Your question has been submitted'));
		// return redirect('/questions')->with('success, __('etc'));
		//dd('store');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\Question  $question
	 * @return \Illuminate\Http\Response
	 */
	public function show(Question $question)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\Question  $question
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Question $question)
	{
		return view('questions.edit')->with('question', $question);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  App\Http\Requests\AskQuestionReques  $request
	 * @param  \App\Models\Question  $question
	 * @return \Illuminate\Http\Response
	 */
	public function update(AskQuestionRequest $request, Question $question)
	{
		if ($request->body != $question->body || $request->title != $question->title) {
			$question->update($request->only('title', 'body'));
			return redirect()->route('questions.index')->with('success', __('Your question has been updated'));
		} else return redirect()->route('questions.index');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\Question  $question
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Question $question)
	{
		//
	}
}