<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Question;
use Illuminate\Database\Seeder;

class FavoritesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('favorites')->delete();
        $userIDs = User::pluck('id')->all();

        $nbUserIDs = count($userIDs);

        foreach (Question::all() as $question) {
            for ($i = 0; $i < rand(1, $nbUserIDs); $i++) {
                $userID = $userIDs[$i];

                $question->favorites()->attach($userID);
            }
        }

    }
}
