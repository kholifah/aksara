<?php

namespace Plugins\SampleTransaction\Models;

use Illuminate\Database\Eloquent\Model;
use Plugins\SampleMaster\Models\Supplier;
use Collective\Html\Eloquent\FormAccessible;
use Carbon\Carbon;

class PurchaseOrder extends Model
{
    use FormAccessible;

    protected $fillable = [
        'document_number',
        'supplier_id',
        'order_date',
        'estimated_delivery_date',
        'status',
    ];

    protected $casts = [
        'is_applied' => 'boolean',
        'is_void' => 'boolean',
    ];

    protected $dates = [
        'order_date',
        'estimated_delivery_date',
    ];

    public function formOrderDateAttribute($value)
    {
        $formatted = Carbon::parse($value)->format('Y-m-d');
        return $formatted;
    }

    public function formEstimatedDeliveryDateAttribute($value)
    {
        $formatted = Carbon::parse($value)->format('Y-m-d');
        return $formatted;
    }

    public function getSupplierPhoneAttribute($v)
    {
        return $this->supplier->supplier_phone;
    }

    public function items()
    {
        return $this->hasMany(PurchaseOrderItem::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function setStatusAttribute($value)
    {
        $lower = strtolower($value);

        switch ($lower) {
        case 'applied': $this->is_applied = true; break;
        case 'void': $this->is_void = true; break;
        }
    }

    public function getStatusAttribute($value)
    {
        if ($this->is_void) return __('sample-transaction::po.labels.void');
        if ($this->is_applied) return __('sample-transaction::po.labels.applied');

        return __('sample-transaction::po.labels.draft');
    }

    public function updateFields()
    {
        $this->total_amount = $this->items->sum(function ($item) {
            return $item->calculateNettPrice();
        });
    }
}
