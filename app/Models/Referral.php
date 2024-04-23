<?php

/** 
 * Creating Referral Model
 * @author Fxc Jahid <fxcjahid3@gmail.com>
 */

namespace App\Models;

use App\Models\User;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Referral extends Model
{
    use HasFactory, Notifiable, HasApiTokens, HasRoles;

    /**
     * Summary of STATUS
     * @var string
     */
    const STATUS_PENDING = 'pending';
    const STATUS_EARNED  = 'earned';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'referral_code',
        'referred_id',
        'status',
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
     * Store a new referral.
     *
     * @param array $data
     * @return Referral
     */
    public static function store(array $data)
    {
        return self::create($data);
    }

    /**
     * Relationship to the User model for the referrer user
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function referrer()
    {
        return $this->belongsTo(User::class, 'referral_code', 'referral_code');
    }

    /**
     * Relationship to the User model for the referred user
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function referred()
    {
        return $this->belongsTo(User::class, 'referred_id', 'id');
    }
}