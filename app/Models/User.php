<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens, HasRoles;

    protected $guard_name = 'web';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'username', 'first_name', 'last_name', 'phone', 'profile_pic', 'speed',
        'heading', 'lat', 'long', 'is_online', 'app_token', 'is_phone_verified', 'reset_hash',
        'reset_at', 'reset_expires', 'activate_hash', 'status', 'status_message', 'active',
        'user_type', 'address', 'gender', 'emergency_number', 'unique_id', 'car_assign', 'user_register_from', 'licence_number',
        'car_owner_mobile', 'driver_email', 'ride_service', 'ride_package', 'car_model', 'car_cc', 'car_number', 'car_register_year',
        'driver_phone_number', 'verification_code', 'city_id', 'points', 'referral_code',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function driverDoc() : HasOne
    {
        return $this->hasOne(DriverDoc::class, 'driver_id');
    }

    /**
     * Summary of referrals
     * @author Fxc Jahid <fxcjahid3@gmail.com>
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function referrals()
    {
        return $this->hasMany(Referral::class, 'referral_code', 'referral_code')
            ->with(['referrer', 'referred']);
    }
}