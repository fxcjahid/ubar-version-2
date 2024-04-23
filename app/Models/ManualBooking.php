<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManualBooking extends Model
{
    use HasFactory;

    /**
     * @var massassignment
     */
    protected $fillable = [
        'booking_id',
        'customer_name',
        'phone',
        'email',
        'booking_start_date',
        'booking_end_date',
        'advance_amnt',
        'pending_amnt',
        'total_amnt',
        'status',
        'created_by_id',
        'driver_id',
        'pickup_location',
        'drop_location',
        'type_id',
        'category_id',
        'vehicle_id',
        'distance',
    ];
}
