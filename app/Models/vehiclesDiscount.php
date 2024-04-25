<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class vehiclesDiscount extends Model
{
    use HasFactory, Notifiable, HasApiTokens, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'vehicle_type',
        'vehicle_number',
        'discount_code',
        'discount_type',
        'discount_amount',
        'status',
        'start_at',
        'expired_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime:d-m-Y',
    ];

    /**
     * Store a new vehicles discount
     *
     * @param array $data
     * @return Referral
     */
    public static function store(array $data)
    {
        return self::create($data);
    }

    /**
     * Relationship to the vehicles type model
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function vehicleType()
    {
        return $this->belongsTo(Type::class, 'vehicle_type', 'id');
    }
}