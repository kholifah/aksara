<?php

namespace Plugins\SampleTransaction\Models;

use Illuminate\Database\Eloquent\Model;
use Plugins\SampleMaster\Models\Supplier;

class PurchaseOrder extends Model
{
    protected $fillable = [
        'document_number',
        'supplier_id',
        'order_date',
        'estimated_delivery_date',
        'is_applied',
        'is_void',
    ];

    protected $casts = [
        'is_applied' => 'boolean',
        'is_void' => 'boolean',
    ];

    protected $dates = [
        'order_date',
        'estimated_delivery_date',
    ];

    public function items()
    {
        return $this->hasMany(PurchaseOrderItem::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function getStatusAttribute($value)
    {
        if ($this->is_void) return 'Void';
        if ($this->is_applied) return 'Applied';

        return 'Draft';
    }

    public function updateFields()
    {
        $this->total_amount = $this->items->sum(function ($item) {
            return $item->calculateNettPrice();
        });
    }
}
