<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Requests\AskQuestionRequest;

class QuestionsController extends Controller
{
	/**
	 * Constructor
	 * 
	 * @return void
	 */
	public function __construct() {
		$this->middleware('auth', ['except' => ['index', 'show']]);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		// \DB::enableQueryLog();
		$questions = Question::with('user')->latest()->paginate(4);
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
		$question->increment('views');
		// équivalent de :
		// $question->views = $question->views+1;
		// $question->save();

		return view('questions.show', compact('question'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\Question  $question
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Question $question)
	{
		$this->authorize('update', $question);
		return view('questions.edit')->with('question', $question);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  App\Http\Requests\AskQuestionRequest  $request
	 * @param  \App\Models\Question  $question
	 * 
	 * @return \Illuminate\Http\Response
	 */
	public function update(AskQuestionRequest $request, Question $question)
	{
		$this->authorize('update', $question);
		if ($request->body != $question->body || $request->title != $question->title) {
			
			$question->update($request->only('title', 'body'));
			
			if ($request->expectsJson()) {
				return response()->json([
					'message' => __('Your question has been updated'),
					'body_html' => $question->body_html
				]);
			}

			return redirect()->route('questions.index')->with('success', __('Your question has been updated'));
		} else {
			if ($request->expectsJson()) {
				return response()->json([
					'message' => __('There was an error trying to update the question. Please try again later'),
					'body_html' => $question->body_html
				]);
			}

			return redirect()->route('questions.index');
		} 
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\Question  $question
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Question $question)
	{
		$this->authorize('delete', $question);
		$question->delete();

		if (request()->expectsJson()) {
			return response()->json([
				'message' => __('Your question has been deleted')
			]);
		}
		return redirect()->route('questions.index')->with('success', __('Your question has been deleted'));
	}
}
