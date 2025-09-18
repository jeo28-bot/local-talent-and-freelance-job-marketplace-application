<?php

namespace App\Models;
use App\Models\JobPost;

use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    protected $fillable = [
        'job_id',
        'user_id',
        'full_name',
        'email',
        'phone_num',
        'message',
        'status',
    ];

    public function job()
    {
        return $this->belongsTo(JobPost::class, 'job_id');
    }


    public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}

}

