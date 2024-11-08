<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'first_name',
        'last_name',
        'mobile_number',
        'otp_verification_code',
        'profile_image',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'status',
        'password',
        'remember_token',
    ];

    protected $appends = ['profile_image_url'];

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

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function getProfileImageUrlAttribute()
    {
        if ($this->profile_image && filter_var($this->profile_image, FILTER_VALIDATE_URL) && strpos($this->profile_image, 'https') === 0) {
            return $this->profile_image;
        }

        return $this->profile_image ? url(Storage::url('profile_images/' . $this->profile_image)) : null;

        // return $this->profile_image ? config('app.url') . Storage::url('profile_images/'.$this->profile_image) : null;
    }
}
