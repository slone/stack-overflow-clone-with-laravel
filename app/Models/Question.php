<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use League\CommonMark\CommonMarkConverter;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Question extends Model
{
	use HasFactory;

	protected $fillable = ['title', 'body'];

	public function user() {
		return $this->belongsTo(User::class);
	}

	public function answers() {
		return $this->hasMany(Answer::class);
	}

	/**
	 * set up the many-to-many relationship 
	 * between a question and the user who picked it as favorite
	 * 
	 * @return mixed
	 */
	public function favorites() {
		return $this->belongsToMany(User::class, 'favorites')->withTimestamps(); // you can also add 2 more parameters to specify key names if convention is not followed
		// can be used like this
		// $question->favorites()->attach($user->id);
		// or by passing a User::class instance as parameter
		// $question->favorites->attach($userInstance);
		// or by passing a collection of IDs
		// $question->favorites->attach([$user1->id, $user2->id, $user3->id]);
		//
		// the property favorites can be read but is not automatically refreshed
		// $question->favorites // returns a collection of User::class instances
		//
		// to refresh and get the up-to-date version of the list
		// $question->load('favorites'); // returns a collection of User::class instances
		//
		// query example to know if a user as favorited an specific question: 
		// $question->favorites->where('user_id', $user->id)->count() > 0

	}

	public function isFavorited() {
		return $this->favorites()->where('user_id', auth()->id())->count() > 0;
		// $this->favorites() returns a query
		// $this->favorites returns a collection
	}

	public function getIsFavoritedAttribute() {
		return $this->isFavorited();
	}

	public function getFavoritesCountAttribute() {
		return $this->favorites->count();
	}


	/**
	 * relation between user vote and Question
	 * 
	 * @return mixed
	 */
	public function votes() {
		return $this->morphToMany(User::class, 'votable')->withTimestamps(); // (related model, singular form of table name)
		// $questionInstance->votes() // returns collection of users who have voted for that question
		//
		// $questionInstance->votes()->withPivot('vote'); // returns the same but add the vote column with the value cast by the user

		// $questionIsntance->votes()->wherePivot('vote', -1)->count(); // return the nb of negative votes
		// 
		// $questionInstance->votes()->wherePivot('vote', -1)->sum('vote'); // return the sum of all negative votes, ie 9 négatives would return -9
	}

	/**
	 * return collection of positive votes
	 * 
	 * @return Array
	 */
	public function upVotes() {
		return $this->votes()->wherePivot('vote', 1);
	}

	/**
	 * return collection of negative votes
	 * 
	 * @return Array
	 */
	public function downVotes() {
		return $this->votes()->wherePivot('vote', -1);
	}


	public function setTitleAttribute($value) {
		$this->attributes['title']  = $value;
		$this->attributes['slug']   = Str::slug($value);
	}

	public function getUrlAttribute() {
		return route("questions.show", $this->slug);
	}

	public function getCreatedDateAttribute() {
		return $this->created_at->diffForHumans();
	}

	public function getStatusTextAttribute() {
		if ($this->answers_count > 0) {
			if ($this->best_answer_id) return 'answered-accepted';
			return 'answered';
		}
		return 'unanswered';
	}

	public function getBodyHtmlAttribute() {
		$markdown = new CommonMarkConverter(['allow_unsafe_links' => false]);
		return $markdown->convertToHtml($this->body);
	}

	public function acceptBestAnswer($answer) {
		$this->best_answer_id = $answer->id;
		$this->save();
	}
}
