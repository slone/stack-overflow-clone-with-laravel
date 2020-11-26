<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Answer;
use App\Models\Question;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->count(5)->create()->each(function($user) { 
            $user->questions()
            ->saveMany( 
                Question::factory()->count(rand(0,7))->make()
            )
            ->each(function($question) {
                $question->answers()->saveMany(
                    Answer::factory()->count(rand(0, 10))->make()
                );
            });
        });
    }
}
