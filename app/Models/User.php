<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_type',
        'phoneNum',   
        'address',
        'about_details',    
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

   public function savedJobs()
    {
        return $this->belongsToMany(JobPost::class, 'saved_jobs', 'user_id', 'job_post_id')->withTimestamps();
    }
    
    public function uploads()
    {
        return $this->hasMany(Upload::class);
    }

    protected static function booted()
    {
        static::saving(function ($user) {
            if (empty($user->slug)) {
                $user->slug = Str::slug($user->name);
            }
        });
    }


}
