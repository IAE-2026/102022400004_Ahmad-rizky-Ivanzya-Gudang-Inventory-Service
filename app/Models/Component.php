<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Component extends Model
{
    protected $fillable = [
        'name',
        'part_number',
        'stock',
        'minimum_stock',
        'unit',
        'receipt_number',
    ];
}
