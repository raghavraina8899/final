<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'product_name',
        'product_cost',
        'role',
        'tax_id',
        'image_url',
        'product_description',
    ];

    use HasFactory;

    public function tax()
    {
        return $this->belongsTo(Tax::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'product_user')->withPivot('quantity');
    }

}
