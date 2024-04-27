<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverDoc extends Model
{
    use HasFactory;

    protected $fillable = [
        'driver_id',
        'driver_licence_front_pic',
        'driver_licence_back_pic',
        'car_pic',
        'electricity_bill_pic',
        'bank_check_book_pic',
        'car_front_side_pic',
        'car_back_side_pic',
        'car_registration_pic',
        'car_tax_token_licence',
        'car_fitness_licence',
        'car_insurance_licence',
        'car_route_permit_licence',
        'add_extra_pic',
        'gps_tracking',
        'cctv_sur',
    ];
}