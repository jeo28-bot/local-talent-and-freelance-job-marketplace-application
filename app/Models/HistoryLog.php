<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoryLog extends Model
{
    protected $fillable = [
        'user_id',
        'user_type',
        'details',
    ];

    /**
     * Relation to the User model.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
