<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
	use HasFactory, Notifiable;

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
	 * setting up a many-to-many relationship
	 * between user and his/her favorites
	 * 
	 * @return mixed
	 */
	public function favorites() {
		return $this->belongsToMany(Question::class, 'favorites')->withTimestamps; // table name must be specified obviously
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
