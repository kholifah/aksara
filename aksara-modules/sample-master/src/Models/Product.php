<?php

namespace Plugins\SampleMaster\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'supplier_id',
        'code',
        'name',
        'stock',
        'price',
        'date_product',
        'date_expired',
    ];

    protected $casts = [
        'price' => 'float',
    ];

    protected $dates = [
        'date_product',
        'date_expired',
    ];

    public function stores()
    {
        return $this->belongsToMany(Store::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public static function boot()
    {
        static::creating(function (Product $model) {
            $user = \Auth::user();
            $model->created_by = $user->id;
        });
    }
}
