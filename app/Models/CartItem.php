<?php

namespace App\Models;

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'pizza_id',
        'quantity',
    ];

    // Отношение с пользователем
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Отношение с пиццей
    public function pizza()
    {
        return $this->belongsTo(Pizza::class);
    }
}
