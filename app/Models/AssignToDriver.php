<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignToDriver extends Model
{
    use HasFactory;

    /**
     * @var massassignment
     */
    protected $fillable = [
        'vehicle_id',
        'user_id',
        'status'
    ];
}
