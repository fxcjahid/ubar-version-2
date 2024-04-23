<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    /**
     * @param Var massassignment
     */
    protected $fillable = [
        'city',
        'status'
    ];
}
