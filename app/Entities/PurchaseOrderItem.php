<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrderItem extends Model
{
    /**
     * Whitelisted fields for mass assignment.
     *
     * @var array
     **/
    protected $fillable = ['qty', 'invoice_id', 'product_name', 'unit_cost', 'notes', 'pack_size', 'product_id', 'received_qty'];

    /**
     * Product relation.
     *
     * @return Product
     **/
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    /**
     * undocumented function.
     *
     * @author
     **/
    public function scopeTotal($query)
    {
        return $query->get()->map(function ($item) {
            return $item->unit_cost * $item->qty;
        })->sum();
    }
}
