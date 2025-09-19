<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'shop_name',
        'status',
        'processed_at',
        'processed_by',
        'rejection_reason',
    ];

    protected $casts = [
        'processed_at' => 'datetime',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function processedBy() {
        return $this->belongsTo(User::class, 'processed_by');
    }

    public function isPending() {
        return $this->status === 'pending';
    }

    public function isApproved() {
        return $this->status === 'approved';
    }

    public function isRejected() {
        return $this->status === 'rejected';
    }
}
