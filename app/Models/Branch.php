<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{

    protected $fillable = ['branch_name', 'branch_address', 'city_id', 'PIN'];


    use HasFactory;

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function state()
    {
        return $this->hasOneThrough(State::class, City::class, 'id', 'id', 'city_id', 'state_id');
    }

    public function country()
    {
        return $this->hasOneThrough(Country::class, State::class, 'id', 'id', 'state_id', 'country_id');
    }
}
