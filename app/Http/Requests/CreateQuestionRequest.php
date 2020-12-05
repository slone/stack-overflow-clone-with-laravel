<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateQuestionRequest extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		if (env('APP_ENV')== 'local')		sleep(1.5);
		return [
			'title' 	=> 'required|unique:questions|max:255',
			'body' 		=> 'required|min:50',
		];
	}

}
