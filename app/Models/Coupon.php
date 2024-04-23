<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    /**
     * @var massassignment
     */

     protected $fillable = [
        'coupon_code',
        'start_date',
        'end_date',
        'percentage',
        'status'
    ];
}
