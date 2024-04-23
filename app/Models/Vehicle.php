<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    /**
     * @var massassignment
     */
    protected $fillable = [
        'vehicle_pic',
        'vehicle_category',
        'vehicle_number',
        'vehicle_brand',
        'vehicle_model',
        'vehicle_color',
        'vehicle_seats',
        'vehicle_status',
        'created_by',
        'vehicle_type',
        'user_assign',
        'car_model_year',
        'car_regi_year',
        'owner_name',
        'owner_photo',
        'owner_mobile',
        'owner_email',
    ];
}
