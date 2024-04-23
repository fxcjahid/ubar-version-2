<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Fare extends Model
{
    use HasFactory;

    /**
     * @var massassignment
     */
    protected $fillable = [
        'type_id',
        'category_id',
        'fare_category_id',
        'km',
        'per_hour_fare',
        'per_day_fare',
        'per_week_fare',
        'per_month_fare',
        'holiday_fare',
        'per_holiday_fare', 
        'officeTime',
        'lunchHours',
        'eveningHours',
        'nightHours',
        'mindNight',
        'morningTime',
        'created_by',
    ];

    public function type() : BelongsTo
    {
        return $this->belongsTo(Type::class);
    }

    public function category() : BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function fare_category() : BelongsTo
    {
        return $this->belongsTo(FareCategory::class);
    }
}