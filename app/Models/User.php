<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'phone_number',
        'whatsapp_number',
        'email',
        'first_name',
        'last_name',
        'date_of_birth',
        'country',
        'city',
        'address',
        'id_type',
        'id_number',
        'id_issue_date',
        'id_expiry_date',
        'profile_picture_url',
        'front_id_photo_url',
        'back_id_photo_url',
        'selfie_photo_url',
        'otp_delivery_preference',
        'terms_accepted',
        'privacy_policy_accepted',
        'hashed_password',
        'is_active',
        'is_verified',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'hashed_password',
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
            'date_of_birth' => 'date',
            'id_issue_date' => 'date',
            'id_expiry_date' => 'date',
            'terms_accepted' => 'boolean',
            'privacy_policy_accepted' => 'boolean',
            'is_active' => 'boolean',
            'is_verified' => 'boolean',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * Get the password attribute for authentication
     */
    public function getAuthPassword()
    {
        return $this->hashed_password;
    }
}
