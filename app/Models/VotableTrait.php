<?php 

namespace App\Models;

trait VotableTrait {

	/**
	 * relation between user vote and Answer & Question Models
	 * 
	 * @return mixed
	 */
	public function votes() {
		return $this->morphToMany(User::class, 'votable')->withTimestamps(); // (related model, singular form of table name)
		// $modelInstance->votes() // returns collection of users who have voted for that question
		//
		// $modelInstance->votes()->withPivot('vote'); // returns the same but add the vote column with the value cast by the user

		// $modelInstance->votes()->wherePivot('vote', -1)->count(); // return the nb of negative votes
		// 
		// $modelInstance->votes()->wherePivot('vote', -1)->sum('vote'); // return the sum of all negative votes, ie 9 négatives would return -9
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
}