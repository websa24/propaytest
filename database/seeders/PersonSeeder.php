<?php

namespace Database\Seeders;

use App\Models\Interest;
use App\Models\Person;
use Illuminate\Database\Seeder;

class PersonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Person::factory(50)->create()->each(function ($person) {
            $interestIds = Interest::inRandomOrder()->limit(rand(1, 5))->pluck('id');
            $person->interests()->attach($interestIds);
            event(new \App\Events\PersonCreated($person));
        });
    }
}
