<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relationships\BelongsToMany;

class User extends Authenticatable
{
    use HasApiTokens;

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'first_name',
        'middle_name',
        'last_name',
        'email',
        'password',
        'current_team_id',
        'profile_photo_path',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
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

    // Gets first name
    public function getShortName(): string
    {
        return $this->first_name;
    }

    // Gets first and last name
    public function getName(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    // Gets long version of name
    public function getFullNameLong(): string
    {
        return $this->title . ' ' . $this->first_name . ($this->middle_name ? ' ' . $this->middle_name : '') . ' ' . $this->last_name;
    }

    // Gets first character of first name, and last name
    public function getFullNameShort(): string
    {
        return $this->first_name[0] . ' ' . $this->last_name;
    }

    // Gets created by user
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Gets updated by user
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // Gets deleted by user
    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    public function getProfilePhotoUrlAttribute()
    {
        return $this->profile_photo_path
            ? asset('storage/' . $this->profile_photo_path)
            : $this->defaultProfilePhotoUrl();
    }

    public function isAdmin()
    {
        return $this->role === config('roles.admin');
    }

    public function isEditor()
    {
        return $this->role === config('roles.editor');
    }
}
