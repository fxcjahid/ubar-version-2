<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    /**
     * @param var massassignment
     */
    protected $fillable = [
        'category_name',
        'category_icon',
        'category_image',
        'category_description',
        'category_type',
        'type_id',
        'type_name',
        'category_status',
        'created_by',
        'person'
    ];
}
