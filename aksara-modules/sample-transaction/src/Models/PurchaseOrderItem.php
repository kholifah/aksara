<?php

namespace Plugins\SampleTransaction\Models;

use Illuminate\Database\Eloquent\Model;
use Plugins\SampleMaster\Models\Product;

class PurchaseOrderItem extends Model
{
    protected $fillable = [
        'product_id',
        'qty',
        'discount',
    ];

    public function purchase_order()
    {
        return $this->belongsTo(PurchaseOrder::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function calculateNettPrice()
    {
        $grossTotal = $this->qty * $this->product->price;
        $discount = $grossTotal * ($this->discount / 100);
        return $grossTotal - $discount;
    }

    private function updateFields()
    {
        $this->product_name = $this->product->name;
        $this->unit_price = $this->product->price;
        $this->sub_total = $this->calculateNettPrice();
    }

    private function updateParentFields()
    {
        $this->purchase_order->updateFields();
        $this->purchase_order->save();
    }

    public static function boot()
    {
        static::saving(function (PurchaseOrderItem $model) {
            $model->updateFields();
        });

        static::saved(function (PurchaseOrderItem $model) {
            $model->updateParentFields();
        });

        static::deleted(function (PurchaseOrderItem $model) {
            $model->updateParentFields();
        });
    }
}
