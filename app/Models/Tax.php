<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
    protected $fillable = [
        'tax_name',
        'tax_percentage',
        'role',
    ];

    use HasFactory;

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
