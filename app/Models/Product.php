<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'original_price',
        'discount_price',
        'expiration_date',
        'seller_id',
        'times_sold',
<<<<<<< HEAD
        'image',
=======
>>>>>>> baf3751b6fbd3347660d4ee782ad84b269b0883c
    ];

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }
    protected $casts = [
    'expiration_date' => 'datetime',
];
public function orders()
{
    return $this->hasMany(Order::class);
}

}
