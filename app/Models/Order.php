<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total_amount',
        'payment_method',
        'status',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }


    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // app/Models/Order.php
    public function feedback()
    {
        return $this->hasOne(Feedback::class);
    }

    /**
     * Check if the order can receive feedback
     */
    public function canReceiveFeedback()
    {
        return in_array($this->status, ['Delivered', 'Completed']) && !$this->feedback;
    }

    /**
     * Check if the order has feedback
     */
    public function hasFeedback()
    {
        return $this->feedback !== null;
    }

    /**
     * Get available status list
     */
    public static function getStatusList()
    {
        return [
            'Pending' => 'Menunggu',
            'Processing' => 'Diproses', 
            'Shipped' => 'Dikirim',
            'Delivered' => 'Diterima',
            'Completed' => 'Selesai',
            'Cancelled' => 'Dibatalkan'
        ];
    }

}