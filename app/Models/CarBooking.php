<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CarBooking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'driver_id',
        'pickup_location',
        'destination',
        'vehicle_id',
        'payment_type',
        'total_fare',
        'total_distance',
        'invoice_id',
        'booking_status',
        'otp',
        'booking_type',
        'trip_type',
        'pickup_date',
        'pickup_time',
        'return_date',
        'return_time',
        'drop_location',
        'pickup_location_lat',
        'pickup_location_lng',
        'drop_location_lat',
        'drop_location_lng',
        'type_id',
        'category_id',
        'total_booking_hour',
        'total_day',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime:d-m-Y',
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function driver() : BelongsTo
    {
        return $this->belongsTo(User::class, 'driver_id');
    }

    public function vehicle() : BelongsTo
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }

    public function category() : BelongsTo
    {
        return $this->belongsTo(Category::class, 'vehicle_id');
    }
}