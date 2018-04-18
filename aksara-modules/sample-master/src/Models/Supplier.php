<?php

namespace Plugins\SampleMaster\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = [
        'supplier_name',
        'supplier_phone',
        'supplier_address',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}

