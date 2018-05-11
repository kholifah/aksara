<?php

namespace Plugins\SampleMaster\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $fillable = [
        'store_name',
        'store_phone',
        'store_address',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function manager()
    {
        return $this->hasOne(StoreManager::class)->withDefault();
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public static function boot()
    {
        static::creating(function (Store $model) {
            $user = \Auth::user();
            $model->created_by = $user->id;
        });
    }
}

