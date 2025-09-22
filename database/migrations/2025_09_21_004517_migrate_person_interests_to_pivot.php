<?php

use App\Models\Interest;
use App\Models\Person;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $people = Person::all();
        foreach ($people as $person) {
            if ($person->interests && is_array($person->interests)) {
                foreach ($person->interests as $interestName) {
                    $interest = Interest::firstOrCreate(['name' => $interestName]);
                    $person->interests()->attach($interest->id);
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Detach all interests from people
        Person::all()->each(function ($person) {
            $person->interests()->detach();
        });
    }
};
