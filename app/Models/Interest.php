<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Interest extends Model
{
    protected $fillable = ['name'];

    public function people()
    {
        return $this->belongsToMany(Person::class, 'person_interest', 'interest_id', 'person_id');
    }
}
