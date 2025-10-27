<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable = [
        'user_id', 'reference', 'feature', 'status', 'payment_link', 'meta'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

