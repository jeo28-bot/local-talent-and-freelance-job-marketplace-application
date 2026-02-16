<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\JobApplication;

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
        'vacancies'
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
    use SoftDeletes;
    public function applications()
    {
        return $this->hasMany(JobApplication::class, 'job_id');
    }

    public function acceptedApplications()
    {
        return $this->applications()->where('status', 'accepted');
    }
    public function getRemainingVacanciesAttribute()
    {
        $acceptedCount = $this->acceptedApplications()->count();

        return max(0, $this->vacancies - $acceptedCount);
    }



}
