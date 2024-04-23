<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Privilage extends Model
{
    use HasFactory;

    /**
     * @var massassignment
     */
    protected $fillable = [
        'staff_id',
        'module',
        'submodule',
        'access',
        'add',
        'edit',
        'delete',
        'status',
        'created_by'
    ];
}
