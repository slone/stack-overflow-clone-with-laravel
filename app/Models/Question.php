<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use League\CommonMark\CommonMarkConverter;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Question extends Model
{
	use VotableTrait;
	use HasFactory;

	protected $fillable = ['title', 'body'];

	public function user() {
		return $this->belongsTo(User::class);
	}

	/**
	 * define relationship between a question and its answers
	 * 
	 */
	public function answers() {
		return $this->hasMany(Answer::class)->orderBy('votes_count', 'DESC');
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



	public function setTitleAttribute($value) {
		$this->attributes['title']  = $value;
		$this->attributes['slug']   = Str::slug($value);
	}

	// public function setBodyAttribute($value) {
	// 	$this->attributes['body'] 	= clean($value);
	// }

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
		return clean($this->bodyHtml());
	}

	public function acceptBestAnswer($answer) {
		$this->best_answer_id = $answer->id;
		$this->save();
	}

	public function getExcerptAttribute() {
		return $this->excerpt(350);
	}

	public function excerpt($length = 100) {
		return Str::limit(strip_tags($this->bodyHtml()), $length);		
	}

	private function bodyHtml() {
		$markdown = new CommonMarkConverter(['allow_unsafe_links' => false]);
		return $markdown->convertToHtml($this->body);
	}
}
