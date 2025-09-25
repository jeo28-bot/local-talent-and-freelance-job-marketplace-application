<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Upload extends Model
{
    use HasFactory;

    // Table name (optional, only if not "uploads")
    protected $table = 'uploads';

    // Mass-assignable fields
    protected $fillable = [
        'user_id',
        'type',
        'path',
        'original_name',
    ];

    // Relationship: each upload belongs to one user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
