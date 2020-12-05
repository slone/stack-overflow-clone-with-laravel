<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
	use HasFactory, Notifiable, HasApiTokens;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name',
		'email',
		'password',
	];


	/**
	 * dynamic attributes to be included when instancing the model
	 * 
	 * @var array
	 */
	protected $appends = [
		'url', 'avatar'
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password',
		'remember_token',
	];

	/**
	 * The attributes that should be cast to native types.
	 *
	 * @var array
	 */
	protected $casts = [
		'email_verified_at' => 'datetime',
	];

	public function questions() {
		return $this->hasMany(Question::class);
	}

	public function answers() {
		return $this->hasMany(Answer::class);
	}

	/**
	 * return the head of all questions and answers for a given user
	 * 
	 * @return collection
	 */
	public function posts() {
		$type = request()->get('type');

		if ($type === 'questions') {
			$posts = $this->questions()->get();
		} else {
			$posts = $this->answers()->with('question')->get();
			if ($type !== 'answers') {
				$posts2 = $this->questions()->get();
				$posts = $posts->merge($posts2);
			}
		}

		$data = collect();

		foreach($posts as $post) {
			$item =[
				'votes_count' => $post->votes_count,
				'created_at' => $post->created_at->format('Y-m-d')
			];

			if ($post instanceof Answer) {
				$item['type'] = 'A';
				$item['title'] = $post->question->title;
				$item['accepted'] = $post->question->best_answer_id === $post->id ? true : false;
			}
			elseif ($post instanceof Question) {
				$item['type'] = 'Q';
				$item['title'] = $post->title;
				$item['accepted'] = (bool) $post->best_answer_id;
			}
			$data->push($item);
		}
		$data->sortByDesc('votes_count')->values()->all();

		return $data;
	}


	/**
	 * setting up a many-to-many relationship
	 * between user and his/her favorites
	 * 
	 * @return mixed
	 */
	public function favorites() {
		return $this->belongsToMany(Question::class, 'favorites')->withTimestamps(); // table name must be specified obviously
		// return $this->belongsToMany(Question::class, 'favorites', 'user_id', 'question_id'); // full set of possible parameters
		// 
		// can be used like this: 
		// $userInstance->favorites()->attach($questionInstance->id);
		// or pass an Question::class instance as parameter
		// $userInstance->favorites()->attach($questionInstance);
		// or pass an array of Id as parameter
		// $userInstance->favorites()->attach([$questionInstance1->id, $questionInstance2->id, etc.]);
		// 
		// the favorites property is read like this (note: its content is not automatically refreshed in a session) :
		// $userInstance->favorites; // returns an array of Question::class instances
		//
		// to refresh the instance property and get the up-to-date list of favorites: 
		// $userInstance->load('favorites'); // return an array of Question::class instances

	}

	/**
	 * setting many-to-many polymorphic relation between Users and Questions
	 * 
	 * @return mixed
	 */
	public function voteQuestions() {
		return $this->morphedByMany(Question::class, 'votable')->withTimestamps(); // (related model, singular form of table name)

		// can be used like this: 
		// $userInstance->voteQuestions()->attach($questionInstance, ['vote' => 1]); // to create record in pivot table
		// $userInstance->voteQuestions()->where('votable_id', $questionInstance->id)->exists(); to check if user has cast a vote for that question
		// $userInstance->voteQuestions()->updateExistingPivote($questionInstance, ['vote' => -1]) // to modify record in pivot table
	}
	/**
	 * setting many-to-many polymorphic relation between Users and Answers
	 * 
	 * @return mixed
	 */
	public function voteAnswers() {
		return $this->morphedByMany(Answer::class, 'votable'); // (related model, singular form of table name)

		// can be used like this: 
		// $userInstance->voteAnswers()->attach($answerInstance, ['vote' => 1]); // to create record in pivot table
		// $userInstance->voteAnswers()->where('votable_id', $answerInstance->id)->exists(); // to check if user has cast a vote for that question
		// $userInstance->voteAnswers()->udpateExistingPivot($answerInstance, ['vote' => -1]); // to modify record in pivot table
	}


	/**
	 * User cast a vote for a question
	 * @param App\Models\Question 	$question
	 * 
	 * @return void
	 */
	public function voteQuestion(Question $question, $vote) {
		$voteQuestions = $this->voteQuestions();
		return $this->_vote($voteQuestions, $question, $vote);
	}

	/**
	 * User cast a vote for an answer
	 * @param App\Models\Answer 	$question
	 * 
	 * @return void
	 */
	public function voteAnswer(Answer $answer, $vote) {
		$voteAnswers = $this->voteAnswers();
		return $this->_vote($voteAnswers, $answer, $vote);
	}

	/**
	 * cast a vote for a question or an answer positively or negatively
	 * 
	 * @param Illuminate\Database\Eloquent\Relations\MorphToMany	$relationship
	 * @param mixed 				$model 
	 * @param int 													$vote
	 * 
	 * @return void
	 */
	private function _vote($relationship, $model, $vote) {
		if ($relationship->where('votable_id', $model->id)->exists()) {
			$relationship->updateExistingPivot($model, ['vote' => $vote]);
		} else {
			$relationship->attach($model, ['vote' => $vote]);
		}
		$model->load('votes');
		$downvotes 	= (int) $model->downVotes()->sum('vote');
		$upvotes 	= (int) $model->upVotes()->sum('vote');
		$model->votes_count = $upvotes + $downvotes;
		$model->save();
		
		return $model->votes_count;
	}



	public function getUrlAttribute() {
		// return route("questions.show", $this->id);
		return '#';
	}

	public function getAvatarAttribute() {
		$email = $this->email;
		$size = 32;
		return "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) . "&s=" . $size;
	}
}
