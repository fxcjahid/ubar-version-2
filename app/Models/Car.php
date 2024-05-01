<?php

/**
 * Summary of namespace App\Models
 * @author Fxc Jahid <fxcjahid3@gmail.com>
 */

namespace App\Models;

use App\Enums\UserType;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Car extends Model
{
    use HasFactory, Notifiable, HasApiTokens, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'owner_name',
        'owner_bank_acc',
        'owner_mobile_number',
        'owner_nid_number',
        'model_name',
        'car_number',
        'registration_number',
        'color_name',
        'engine_number',
        'cc_number',
        'seats_number',
        'chassize_number',
        'bluebook_number',
        'route_permit_number',
        'fleetness_number',
        'fitness_ensuring_at',
        'fitness_expired_at',
        'insurance_number',
        'tax_token_number',
        'ride_service',
        'ride_package',
        'gps_tracking',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //TODO:
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        //TODO:
    ];
}