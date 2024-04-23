<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    /**
     * @param Var massassignment
     */
     
     protected $table='payments';
    protected $fillable = [
        'payment_method','mobile_no','transaction_no','status','amount',
    ];
}
