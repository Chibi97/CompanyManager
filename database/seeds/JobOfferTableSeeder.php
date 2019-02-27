<?php

use App\Models\JobOffer;
use App\Models\Profession;
use App\Models\User;
use Illuminate\Database\Seeder;

class JobOfferTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Profession::class, 10)->create();

        $faker = \Faker\Factory::create();
        $professions = Profession::all()->pluck('id')->toArray();
        $users = User::all()->pluck('id')->toArray();

        factory(JobOffer::class, 15)->make()->each(function ($offer) use($faker, $professions, $users) {
            $offer->profession_id = $faker->randomElement($professions);
            $offer->user_id = $faker->randomElement($users);
            //$offer->profession()->save(factory(Profession::class)->make());
            //$offer->user()->save(factory(User::class)->make());
            $offer->save();
        });
    }
}
