<?php

namespace Plugins\SampleMaster\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $fillable = [
        'store_name',
        'store_phone',
        'store_address',
    ];

    public function manager()
    {
        return $this->hasOne(StoreManager::class)->withDefault();
    }
}

