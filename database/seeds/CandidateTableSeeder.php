<?php

use App\Models\Candidate;
use App\Models\JobOffer;
use Faker\Provider\Company;
use Illuminate\Database\Seeder;

class CandidateTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        $jobOffers = JobOffer::all()->pluck('id')->toArray();

        factory(Candidate::class, 15)->make()->each(function ($candidate) use ($jobOffers, $faker) {
            $candidate->job_offer_id = $faker->randomElement($jobOffers);
            $candidate->save();
        });
    }
}
