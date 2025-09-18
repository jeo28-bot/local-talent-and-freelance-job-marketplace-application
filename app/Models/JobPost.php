<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobPost extends Model
{
    protected $fillable = [
        'client_id',
        'job_title',
        'job_location',
        'job_type',
        'job_pay',
        'salary_release',
        'skills_required',
        'short_description',
        'full_description',
        'status',
    ];

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }
    public function savedByEmployees()
    {
        return $this->belongsToMany(User::class, 'saved_jobs')->withTimestamps();
    }
    public function savedBy()
    {
        return $this->hasMany(SavedJob::class, 'job_post_id');
    }


}
