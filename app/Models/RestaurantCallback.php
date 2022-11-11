<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestaurantCallback extends Model
{
    use HasFactory;

    protected $table = 'restaurant_callback';

    protected $fillable = [
        'order_id',
        'restaurant_answer',
        'deliver_in',
        'why_rejected',
    ];

    public $timestamps = [
        'created_at',
        'updated_at',
    ];

    public function order()
    {
        return $this->belongsTo(\App\Order::class, 'order_id');
    }
}
