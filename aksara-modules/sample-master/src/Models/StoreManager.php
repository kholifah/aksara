<?php

namespace Plugins\SampleMaster\Models;

use Illuminate\Database\Eloquent\Model;

class StoreManager extends Model
{
    protected $fillable = [
        'store_id',
        'manager_name',
        'manager_phone',
        'manager_address',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}

