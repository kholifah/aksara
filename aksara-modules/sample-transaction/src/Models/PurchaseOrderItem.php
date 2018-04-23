<?php

namespace Plugins\SampleTransaction\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrderItem extends Model
{
    protected $fillable = [
        'product_id',
        'product_name',
        'qty',
        'unit_price',
        'discount',
        'sub_total',
    ];

    public function purchase_order()
    {
        return $this->belongsTo(PurchaseOrder::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
