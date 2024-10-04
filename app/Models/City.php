<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = [
        'city_name',
        'PIN',
        'role',
        'state_id',
    ];

    use HasFactory;

    public function state()
    {
        return $this->belongsTo(State::class);
    }
}
