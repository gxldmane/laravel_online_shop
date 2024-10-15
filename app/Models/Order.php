<?php

namespace App\Models;

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'address',
        'total',
    ];

    // Отношение с пользователем
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Отношение с элементами заказа
    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function pizzas()
    {
        return $this->belongsToMany(Pizza::class, 'order_items')->withPivot('quantity');
    }
}
