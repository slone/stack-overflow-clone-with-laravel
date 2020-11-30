<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use League\CommonMark\CommonMarkConverter;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Answer extends Model
{
	use VotableTrait;
	
	use HasFactory;

	protected $fillable = ['body', 'user_id'];
	protected $appends = ['body_html','created_date'];

	/**
	 * Relation to Question model
	 * 
	 * @return mixed
	 */
	public function question() {
		return $this->belongsTo(Question::class);
	}

	/**
	 * Relation to User model
	 * 
	 * @return mixed
	 */
	public function user() {
		return $this->belongsTo(User::class);
	}

	public function getBodyHtmlAttribute() {
		$markdown = new CommonMarkConverter(['allow_unsafe_links' => false]);
		return $markdown->convertToHtml($this->body);
	}
	
	public function getCreatedDateAttribute() {
		return $this->created_at->diffForHumans();
	}

	public static function boot() {
		parent::boot();
		
		static::created(function($answer) {
			$answer->question->increment('answers_count');
		});

		static::deleted(function($answer) {
			$answer->question->decrement('answers_count');
		});
	}

	public function getStatusAttribute() {
		return $this->isBest ? 'vote-accepted' : '';
	}

	public function getIsBestAttribute() {
		return $this->id === $this->question->best_answer_id;
	}

}
