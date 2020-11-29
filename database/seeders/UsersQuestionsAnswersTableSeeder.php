<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Answer;
use App\Models\Question;
use Illuminate\Database\Seeder;

class UsersQuestionsAnswersTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		// clean up in case we want to seed to seed without recreating the whole set of tables using migrate:fresh --seed
		\DB::table('answers')->delete();
		\DB::table('questions')->delete();
		\DB::table('users')->delete();

		User::factory()->count(5)->create()->each(function($user) { 
			$user->questions()
			->saveMany( 
				Question::factory()->count(rand(5,12))->make()
			)
			->each(function($question) {
				$question->answers()->saveMany(
					Answer::factory()->count(rand(0, 10))->make()
				);
			});
		});

	}
}
