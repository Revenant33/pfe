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
        'image',
        'category', 
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
public function carts()
{
    return $this->hasMany(\App\Models\Cart::class);
}


}
