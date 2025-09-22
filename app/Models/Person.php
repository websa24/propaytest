<?php

namespace App\Models;

use App\Events\PersonCreated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Person extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'surname',
        'sa_id_number',
        'mobile_number',
        'email',
        'birth_date',
        'language',
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];

    public function interests()
    {
        return $this->belongsToMany(Interest::class, 'person_interest', 'person_id', 'interest_id');
    }
}
